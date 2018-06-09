@extends('adminlte::page')

@section('title', 'Permission')

@section('content_header')
    <h1>Permission</h1>
@stop

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Form Permission</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    {{ Form::model($permission,array('route' => array((!$permission->exists)?'permission.store':'permission.update',$permission->id),
    'class'=>'form-horizontal','id'=>'permission-form','method'=>(!$permission->exists)?'POST':'PUT')) }}

        <div class="box-body">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nama_permission" class="col-sm-3 control-label">Name</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="nama_permission" name="nama_permission" value="{{(isset($permission->id))?$permission->name:''}}" placeholder="">
                    </div>
                </div>

                <div class="form-group">
                    <label for="display_name" class="col-sm-3 control-label">Display Name</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="display_name" name="display_name" value="{{(isset($permission->id))?$permission->display_name:''}}" placeholder="">
                    </div>
                </div>

                <div class="form-group">
                    <label for="description" class="col-sm-3 control-label">Description</label>

                    <div class="col-sm-9">
                        <textarea class="form-control" rows="4" id="description" name="description" placeholder="">{{(isset($permission->id))?$permission->description:''}}</textarea>
                    </div>
                </div>

                <?php
                    $display_none = "display:none";
                    if($permission->id && !empty($permission)){
                        $display_none = "";
                    }
                ?>
                <!-- radio -->
                <div class="form-group" style="{{$display_none}}">
                  <label for="status" class="col-sm-3 control-label">Status</label>
                  <div class="col-sm-9">
                    <div class="radio">
                        <label>
                        <input type="radio" name="status" id="status" value="Y" {{($permission->aktif == 'Y') ? "checked" : '' }}>
                        Aktif
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                        <input type="radio" name="status" id="status" value="N" {{($permission->aktif == 'N') ? "checked" : '' }}>
                        Non Aktif
                        </label>
                    </div>
                  </div>
                </div>

               
            </div>
        </div>
        <div class="row">&nbsp;</div>
        <!-- /.box-body -->
        <div class="box-footer">
            <div class="col-md-12">
                {{-- <button type="submit" class="btn btn-default">Cancel</button> --}}
                <button type="submit" class="btn btn-info pull-right">Submit</button>
            </div>
        </div>
        <!-- /.box-footer -->
    {{ Form::close() }}
</div>
 
@stop

@push('js')
<script type="text/javascript">
$(document).ready(function() {

    $('#permission-form').validate({ // initialize the plugin
        rules: {
            nama_permission: {
                required: true,
                minlength: 5
            },
        }
    });
}); //=== /document.ready ====//

</script>
@endpush

