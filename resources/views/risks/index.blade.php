@extends('risks.layout')
 
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Risk Register</h2>
            </div>
            <div class="pull-right mb-2">
                <a class="btn btn-success" href="{{ route('risks.create') }}"> Create New Risk</a>
                <a class="btn btn-info" href="{{ url('risks/bulk-upload') }}"> Bulk Upload</a>
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    @php
    $riskLevelColors = [
        'Critical' => 'table-danger',
        'High' => 'table-warning',
        'Medium' => 'table-info',
        'Low' => 'table-success',
    ];
    @endphp

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Risk Name</th>
            <th>Description</th>
            <th>Likelihood</th>
            <th>Consequences</th>
            <th>Risk Level</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($risks as $risk)
        <tr class="{{ $riskLevelColors[$risk->risk_level] ?? '' }}">
            <td>{{ $risk->id }}</td>
            <td>{{ $risk->risk_name }}</td>
            <td>{{ $risk->description }}</td>
            <td>{{ $risk->likelihood }}</td>
            <td>{{ $risk->consequences }}</td>
            <td>{{ $risk->risk_level }}</td>
            <td>
                <form action="{{ route('risks.destroy',$risk->id) }}" method="POST">
   
                    <a class="btn btn-primary" href="{{ route('risks.edit',$risk->id) }}">Edit</a>
   
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
@endsection