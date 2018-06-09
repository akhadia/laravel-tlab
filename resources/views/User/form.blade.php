@extends('adminlte::page')

@section('title', 'User')

@section('content_header')
    <h1>User</h1>
@stop

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h4 class="box-title">Form User</h4>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    {{ Form::model($user,array('route' => array((!$user->exists)?'user.store':'user.update',$user->id),
    'class'=>'form-horizontal','id'=>'user-form','method'=>(!$user->exists)?'POST':'PUT')) }}

        <div class="box-body">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name" class="col-sm-4 control-label">Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="name" name="name" value="{{(isset($user->id))?$user->name:''}}" placeholder="">
                    </div>
                </div>

                <div class="form-group">
                    <label for="username" class="col-sm-4 control-label">Username</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="username" name="username" value="{{(isset($user->id))?$user->username:''}}" placeholder="">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="col-sm-4 control-label">Email</label>
                    <div class="col-sm-8">
                        <input type="email" class="form-control" id="email" name="email" value="{{(isset($user->id))?$user->email:''}}" placeholder="">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="col-sm-4 control-label">Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="password" name="password" value="" placeholder="">
                    </div>
                </div>

                <div class="form-group">
                    <label for="c_password" class="col-sm-4 control-label">Confirm Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="c_password" name="c_password" value="" placeholder="">
                    </div>
                </div>

                <?php
                    $display_none = "display:none";
                    if($user->id && !empty($user)){
                        $display_none = "";
                    }
                ?>
                <!-- radio -->
                <div class="form-group" style="{{$display_none}}">
                  <label for="status" class="col-sm-4 control-label">Status</label>
                  <div class="col-sm-8">
                    <div class="radio">
                        <label>
                        <input type="radio" name="status" id="status" value="Y" {{($user->aktif == 'Y') ? "checked" : '' }}>
                        Aktif
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                        <input type="radio" name="status" id="status" value="N" {{($user->aktif == 'N') ? "checked" : '' }}>
                        Non Aktif
                        </label>
                    </div>
                  </div>
                </div>
                

                <!-- checkbox -->
                <div class="form-group">
                    <label for="status" class="col-sm-4 control-label">Role</label>
                    <div class="col-sm-8">
                    @foreach ($role as $val)
                        <?php
                            $checked = "";
                            if(isset($role_user) && !empty($role_user)){
                                foreach($role_user as $val2){
                                    if($val->id == $val2->role_id){
                                        $checked = "checked";
                                    }
                                }
                            }
                         
                        ?>
                        <div class="checkbox">
                            <label>
                            <input {{$checked}} type="checkbox" name="role[]" value="{{$val->id}}">
                                {{$val->name}}
                            </label>
                        </div>
                    @endforeach
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

    $('#user-form').validate({ // initialize the plugin
        rules: {
            name: {
                required: true,
                minlength: 5
            },
            username: {
                  required: true,
                  minlength: 5
            },
            email: {
                  required: true,
                  email: true
            },
            password: {
                  required: true,
                  minlength: 4
            },
            c_password: {
                minlength: 4,
                equalTo: "#password"
            }
            
        }
    });
}); //=== /document.ready ====//

</script>
@endpush