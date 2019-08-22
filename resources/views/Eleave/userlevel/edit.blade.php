@extends('Eleave.layout.main')

@section('title','Eleave | Edit UserLevel')

@section('content')
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-bank font-green"></i>
            <span class="caption-subject font-green bold uppercase">Add User Levels</span>
        </div>
        <div class="actions">
        </div>
    </div>

    <div class="portlet-body">
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="{{ URL::to(env('APP_URL').'/eleave/userlevel/'.$userlevellist->id.'/update') }}" class="form-horizontal" method="post">
                
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Level Name</label>
                        <div class="col-md-4">
                            <input class="form-control" name="txt_userlevel_name" value="{{$userlevellist->userlevel_name}}" data-validation="required" data-validation-error-msg="'Level Name' is required." maxlength="255">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Description</label>
                        <div class="col-md-4">
                            <input class="form-control" name="txt_description" value="{{$userlevellist->description}}">
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn btn-circle green"><i class="fa fa-save"></i> Submit</button>
                            <a href="{{ URL::to('eleave/userlevel/index') }}" class="btn btn-circle grey-salsa btn-outline"><i class="fa fa-times"></i> Cancel</a>
                        </div>
                    </div>
                </div>
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="PUT">
                
            </form>
        </div>

    </div>
</div>

@endsection