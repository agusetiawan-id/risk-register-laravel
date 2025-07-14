@extends('risks.layout')
  
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Add New Risk</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('risks.index') }}"> Back</a>
        </div>
    </div>
</div>
   
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
   
<form action="{{ route('risks.store') }}" method="POST">
    @csrf
  
     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Risk Name:</strong>
                <input type="text" name="risk_name" class="form-control" placeholder="Risk Name">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Description:</strong>
                <textarea class="form-control" style="height:150px" name="description" placeholder="Description"></textarea>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Likelihood:</strong>
                <select name="likelihood" class="form-control">
                    <option value="Very Low">Very Low</option>
                    <option value="Low">Low</option>
                    <option value="Equal">Equal</option>
                    <option value="High">High</option>
                    <option value="Very High">Very High</option>
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Consequences:</strong>
                <select name="consequences" class="form-control">
                    <option value="Insignificant">Insignificant</option>
                    <option value="Minor">Minor</option>
                    <option value="Moderate">Moderate</option>
                    <option value="High">High</option>
                    <option value="Severe">Severe</option>
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
                <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
   
</form>
@endsection