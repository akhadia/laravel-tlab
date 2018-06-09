@extends('adminlte::page')

@section('title', 'Kategori')

@section('content_header')
    <h1>Kategori</h1>
@stop

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Form Kategori</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    {{ Form::model($kategori,array('route' => array((!$kategori->exists)?'kategori.store':'kategori.update',$kategori->id),
    'class'=>'form-horizontal','id'=>'kategori-form','method'=>(!$kategori->exists)?'POST':'PUT')) }}

        <div class="box-body">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nama_kategori" class="col-sm-2 control-label">Nama</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="{{$kategori->nama}}" placeholder="">
                    </div>
                </div>
                <?php
                    $display_none = "display:none";
                    if($kategori->id && !empty($kategori)){
                        $display_none = "";
                    }
                ?>
                <!-- radio -->
                <div class="form-group" style="{{$display_none}}">
                  <label for="nama_kategori" class="col-sm-2 control-label">Status</label>
                  <div class="col-sm-10">
                    <div class="radio">
                        <label>
                        <input type="radio" name="status" id="status" value="Y" {{($kategori->aktif == 'Y') ? "checked" : '' }}>
                        Aktif
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                        <input type="radio" name="status" id="status" value="N" {{($kategori->aktif == 'N') ? "checked" : '' }}>
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

    $('#kategori-form').validate({ // initialize the plugin
        rules: {
            nama_kategori: {
                required: true,
                minlength: 5
            },
        }
    });
}); //=== /document.ready ====//

</script>
@endpush