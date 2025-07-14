@extends('risks.layout')
   
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Risk</h2>
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
  
    <form action="{{ route('risks.update',$risk->id) }}" method="POST">
        @csrf
        @method('PUT')
   
         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Risk Name:</strong>
                    <input type="text" name="risk_name" value="{{ $risk->risk_name }}" class="form-control" placeholder="Name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Description:</strong>
                    <textarea class="form-control" style="height:150px" name="description" placeholder="Detail">{{ $risk->description }}</textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Likelihood:</strong>
                    <select name="likelihood" class="form-control">
                        @foreach (['Very Low', 'Low', 'Equal', 'High', 'Very High'] as $likelihood)
                            <option value="{{ $likelihood }}" @if($risk->likelihood == $likelihood) selected @endif>{{ $likelihood }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Consequences:</strong>
                    <select name="consequences" class="form-control">
                        @foreach (['Insignificant', 'Minor', 'Moderate', 'High', 'Severe'] as $consequence)
                            <option value="{{ $consequence }}" @if($risk->consequences == $consequence) selected @endif>{{ $consequence }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
   
    </form>
@endsection