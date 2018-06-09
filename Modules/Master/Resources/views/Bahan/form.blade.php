@extends('adminlte::page')

@section('title', 'Bahan')

@section('content_header')
    <h1>Bahan</h1>
@stop

@section('content')

<!-- Horizontal Form -->
    <div class="box box-info">
        <div class="box-header with-border">
        <h3 class="box-title">Bahan Form</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        {{ Form::model($bahan,array('route' => array((!$bahan->exists)?'bahan.store':'bahan.update',$bahan->id),
        'class'=>'form-horizontal','id'=>'bahan-form','method'=>(!$bahan->exists)?'POST':'PUT')) }}
        {{-- <form class="form-horizontal"> --}}
        <div class="box-body">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="bahan" class="col-sm-2 control-label">Bahan</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama_bahan" name="nama_bahan" value="{{(isset($bahan->id))?$bahan->nama:''}}" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="satuan" class="col-sm-2 control-label">Satuan</label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <!-- /btn-group -->
                            <input readonly type="text" class="form-control" name="nama_satuan" id="nama_satuan" value="{{(isset($bahan->id))?$bahan->satuan->nama:''}}">
                            <input type="hidden" class="form-control" name="old_nama_satuan" id="old_nama_satuan" value="{{(isset($bahan->id))?$bahan->satuan->nama:''}}">
                            <input type="hidden" class="form-control" name="id_satuan" id="id_satuan" value="{{(isset($bahan->id))?$bahan->id_satuan:''}}">
                            <div class="input-group-btn">
                                <button id="btn_search" type="button" class="btn btn-info btn_search"><i class="fa fa-search"></i> Search</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- radio -->
                <?php
                    $display_none = "display:none";
                    if($bahan->id && !empty($bahan)){
                        $display_none = "";
                    }
                ?>
                <div class="form-group" style="{{$display_none}}">
                    <label for="nama_bahan" class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-10">
                    <div class="radio">
                        <label>
                        <input type="radio" name="status" id="status" value="Y" {{($bahan->aktif == 'Y') ? "checked" : '' }}>
                        Aktif
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                        <input type="radio" name="status" id="status" value="N" {{($bahan->aktif == 'N') ? "checked" : '' }}>
                        Non Aktif
                        </label>
                    </div>
                    </div>
                </div>
              
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            {{-- <button type="submit" class="btn btn-default">Cancel</button> --}}
            <button type="submit" class="btn btn-info pull-right">Submit</button>
        </div>
        <!-- /.box-footer -->
        {{-- </form> --}}
        {{ Form::close() }}
    </div>
    <!-- /.box -->
    <div id="myModal"></div>
 
</div>
 
@stop

@push('js')
<script type="text/javascript">
$(document).ready(function() {
    $('#bahan-form').validate({ // initialize the plugin
        rules: {
            nama_bahan: {
                required: true,
                minlength: 5
            },
            nama_satuan: {
                required: true,
            },
        }
    });

});

function showPopUpSatuan(rowId){
  var url = "{{url('master/satuan/popupsatuan')}}";
  $('#myModelDialog').html('');

  $.ajax({
        url: url,
        data:{
          'ajax':1,
        },
        cache: false,
        dataType: 'html',
        success: function(msg){
            $('#myModelDialog').html(msg);
            $('#myModelDialog').modal();
        },
        error: function(){
            //$('#myModelDialog').html("request gagal dibuka");
            //$('#myModelDialog').modal('show');
            console.log('gagal');
        }
  });

  return true;
}

$(document).on('click','.btn_search',function(){
    showPopUpSatuan();
    //var url = '{{ url("master/resep/loaddataresep") }}';

    //$.get(url, function (data) {
        //success data
        //console.log(data);
        //$('#tour_id').val(data.id);
        //$('#name').val(data.name);
        //$('#details').val(data.details);
        //$('#btn-save').val("update");
        //$('#myModal').modal('show');
    //}) 
});
</script>
@endpush