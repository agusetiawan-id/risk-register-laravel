<?php

namespace App\Http\Controllers;

use App\Models\Risk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RiskRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $risks = Risk::all();
        return view('risks.index', compact('risks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('risks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'risk_name' => 'required|string|max:255',
            'description' => 'required|string',
            'likelihood' => 'required|string|in:Very Low,Low,Equal,High,Very High',
            'consequences' => 'required|string|in:Insignificant,Minor,Moderate,High,Severe',
        ]);

        $validated['risk_level'] = $this->calculateRiskLevel($validated['likelihood'], $validated['consequences']);

        Risk::create($validated);

        return redirect()->route('risks.index')
                         ->with('success', 'Risk created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Risk $risk)
    {
        return view('risks.edit', compact('risk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Risk $risk)
    {
        $validated = $request->validate([
            'risk_name' => 'required|string|max:255',
            'description' => 'required|string',
            'likelihood' => 'required|string|in:Very Low,Low,Equal,High,Very High',
            'consequences' => 'required|string|in:Insignificant,Minor,Moderate,High,Severe',
        ]);

        $validated['risk_level'] = $this->calculateRiskLevel($validated['likelihood'], $validated['consequences']);
        
        $risk->update($validated);

        return redirect()->route('risks.index')
                         ->with('success', 'Risk updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Risk $risk)
    {
        $risk->delete();

        return redirect()->route('risks.index')
                         ->with('success', 'Risk deleted successfully.');
    }

    /**
     * Show the form for bulk uploading risks.
     */
    public function showBulkForm()
    {
        return view('risks.bulk-upload');
    }

    /**
     * Process the bulk upload file.
     */
    public function processBulkUpload(Request $request)
    {
        $request->validate([
            'bulk_file' => 'required|file|mimes:csv,txt',
        ]);

        $path = $request->file('bulk_file')->getRealPath();
        $file = fopen($path, 'r');

        // Skip header row
        fgetcsv($file); 

        $rules = [
            'risk_name' => 'required|string|max:255',
            'description' => 'required|string',
            'likelihood' => 'required|string|in:Very Low,Low,Equal,High,Very High',
            'consequences' => 'required|string|in:Insignificant,Minor,Moderate,High,Severe',
        ];

        DB::beginTransaction();
        try {
            while (($row = fgetcsv($file)) !== FALSE) {
                $data = [
                    'risk_name' => $row[0] ?? null,
                    'description' => $row[1] ?? null,
                    'likelihood' => $row[2] ?? null,
                    'consequences' => $row[3] ?? null,
                ];

                $validator = Validator::make($data, $rules);

                if ($validator->fails()) {
                    // If one row fails, rollback and return with error
                    DB::rollBack();
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                $data['risk_level'] = $this->calculateRiskLevel($data['likelihood'], $data['consequences']);
                Risk::create($data);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred during the bulk upload process.');
        } finally {
            fclose($file);
        }

        return redirect()->route('risks.index')->with('success', 'Bulk upload completed successfully.');
    }

    /**
     * Calculate the risk level based on a predefined matrix.
     */
    private function calculateRiskLevel(string $likelihood, string $consequences): string
    {
        $matrix = [
            // Consequences ->
            // Insignificant, Minor, Moderate, High, Severe
            'Very High' => ['Medium', 'High',   'High',     'Critical', 'Critical'],
            'High'      => ['Medium', 'Medium', 'High',     'Critical', 'Critical'],
            'Equal'     => ['Low',    'Medium', 'High',     'High',     'Critical'],
            'Low'       => ['Low',    'Low',    'Medium',   'Medium',   'High'],
            'Very Low'  => ['Low',    'Low',    'Low',      'Medium',   'High'],
        ];

        $consequencesMap = [
            'Insignificant' => 0,
            'Minor' => 1,
            'Moderate' => 2,
            'High' => 3,
            'Severe' => 4,
        ];

        return $matrix[$likelihood][$consequencesMap[$consequences]] ?? 'Low';
    }
}
