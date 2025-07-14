@extends('risks.layout')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Bulk Upload Risks</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('risks.index') }}"> Back</a>
        </div>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<p>Upload a CSV file with the following columns in order: <strong>Risk Name, Description, Likelihood, Consequences</strong>.</p>
<p>The first row should be a header and will be skipped.</p>
<p>
    Example:
    <pre><code>risk_name,description,likelihood,consequences
"Server Overload","Production server slows down during peak hours","High","Moderate"
"Third-party API Failure","An external API service is unavailable","Low","Minor"
</code></pre>
</p>

<form action="{{ url('risks/bulk-process') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>CSV File:</strong>
                <input type="file" name="bulk_file" class="form-control">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
            <button type="submit" class="btn btn-primary">Upload and Process</button>
        </div>
    </div>
</form>
@endsection
