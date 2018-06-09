@extends('adminlte::page')

@section('title', 'Satuan')

@section('content_header')
    <h1>Satuan</h1>
@stop

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Form Satuan</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    {{ Form::model($satuan,array('route' => array((!$satuan->exists)?'satuan.store':'satuan.update',$satuan->id),
    'class'=>'form-horizontal','id'=>'satuan-form','method'=>(!$satuan->exists)?'POST':'PUT')) }}

        <div class="box-body">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nama_satuan" class="col-sm-2 control-label">Nama</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="nama_satuan" name="nama_satuan" value="{{$satuan->nama}}" placeholder="">
                    </div>
                </div>
                <?php
                    $display_none = "display:none";
                    if($satuan->id && !empty($satuan)){
                        $display_none = "";
                    }
                ?>
                <!-- radio -->
                <div class="form-group" style="{{$display_none}}">
                  <label for="nama_satuan" class="col-sm-2 control-label">Status</label>
                  <div class="col-sm-10">
                    <div class="radio">
                        <label>
                        <input type="radio" name="status" id="status" value="Y" {{($satuan->aktif == 'Y') ? "checked" : '' }}>
                        Aktif
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                        <input type="radio" name="status" id="status" value="N" {{($satuan->aktif == 'N') ? "checked" : '' }}>
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
            <div class="col-md-6">
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

    $('#satuan-form').validate({ // initialize the plugin
        rules: {
            nama_satuan: {
                required: true,
                minlength: 5
            },
        }
    });
}); //=== /document.ready ====//



</script>
@endpush