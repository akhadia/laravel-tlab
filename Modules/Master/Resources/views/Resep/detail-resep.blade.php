@extends('adminlte::page')

@section('title', 'Resep')

@section('content_header')
    <h1>Resep</h1>
@stop

@section('content')

<!-- Horizontal Form -->
    <div class="box box-info">
        <div class="box-header with-border">
        <h3 class="box-title">Resep Form</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        {{ Form::model($resep,array('route' => array((!$resep->exists)?'resep.addresep':'resep.addeditresep',$resep->id),
        'class'=>'form-horizontal','id'=>'resep-form','method'=>(!$resep->exists)?'POST':'PUT')) }}

        <input type="hidden" value="{{(!empty($resep->id))?$resep->id:'' }}" id="id_resep" name="id_resep"/>
        
        <?php
            $display_none = "display:none";
            $readonly = "";
            $disabled="";
            if(isset($resep) && !empty($resep)){
                if($resep->aktif == 'N'){
                    $disabled="disabled";
                    $readonly = "readonly";
                }
            }
        ?>
     
        {{-- <form class="form-horizontal"> --}}
        <div class="box-body">
            <div class="col-md-6">

                <div class="form-group ">
                    <label for="kategori" class="col-sm-2 control-label">Kategori</label>
                    <div class="col-sm-10">
                        <select {{$disabled}} class="form-control" id="kategori" name="kategori">
                            @foreach($kategori as $val)
                                <?php
                                    $selected='';
                                    if(isset($detailResep) && !empty($detailResep)){
                                        if($resep->id_kategori == $val->id){
                                            $selected='selected';
                                        }
                                    }
                                ?>
                                <option  value="{{$val->id}}" {{$selected}}>{{$val->nama}}</option>
                            @endforeach
                        </select>
                    </div>  
                </div>

                <div class="form-group">
                    <label for="resep" class="col-sm-2 control-label">Nama</label>

                    <div class="col-sm-10">
                        <input {{$readonly}} type="text" class="form-control" id="nama_resep" name="nama_resep" value="{{(isset($resep->id))?$resep->nama:''}}" placeholder="">
                    </div>
                </div>

                <div class="form-group">
                    <label for="resep" class="col-sm-2 control-label">Deskripsi</label>

                    <div class="col-sm-10">
                        <textarea {{$readonly}} class="form-control" rows="4" id="deskripsi" name="deskripsi" placeholder="">{{(isset($resep->id))?$resep->deskripsi:''}}</textarea>
                    </div>
                </div>

                <!-- radio -->
                <div class="form-group" style="{{$display_none}}">
                    <label for="nama_resep" class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-10">
                    <div class="radio">
                        <label>
                        <input type="radio" name="status" id="status" value="Y" {{($resep->aktif == 'Y') ? "checked" : '' }}>
                        Aktif
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                        <input type="radio" name="status" id="status" value="N" {{($resep->aktif == 'N') ? "checked" : '' }}>
                        Non Aktif
                        </label>
                    </div>
                    </div>
                </div>
              
            </div>

            <div class="row">&nbsp;</div>

            <div class="col-md-12">
                @include('master::Resep.add-resep-detail')
            </div>

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            {{-- <button type="submit" class="btn btn-default">Cancel</button> --}}
            {{-- <button class="btn btn-lg btn-primary submit_button" status-form="simpan">Submit</button>&nbsp; --}}
            @if ($resep->aktif !== 'N')
                <button class="btn btn-info pull-right submit-button">Submit</button>
            @endif
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