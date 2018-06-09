@extends('adminlte::page')

@section('title', 'Resep')

@section('content_header')
    <h1>Resep</h1>
@stop
 

@section('content')

@include('flash::message')

@permission('resep-create')
<a href="{{ URL::to('master/resep/createresep') }}" class="btn btn-primary btn-lg" role="button"><i class="fa fa-plus-circle"></i> Add New Resep</a>
<div class="row">&nbsp;</div>
@endpermission


@include('master::Resep.search-form')  

<div class="row">
    <div class="box">
        {{-- <div class="box-header with-border">
            <h3 class="box-title">Bordered Table</h3>
        </div> --}}
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered" id="table-resep">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            </table>
        </div>
    </div>
</div>
@stop

@push('css')
<style type="text/css"> 
    table.dataTable thead th {
        border-bottom: 0;
    }
    table.dataTable.no-footer {
        border-bottom: 0;
    }
</style>
@endpush

@push('js')
<script type="text/javascript">
$(document).ready(function() {

var resepTable;
$(function() {
    resepTable = $('#table-resep').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
                url:'{{ url("master/resep/loaddataresep") }}',
                data: function (d) {
                    return $.extend( {}, d, {
                        "nama_resep": $("#nama_resep").val(),
                        "status": $("#status").val(),
                    } );
                }
        },
        columns: [
            {data: 'nomor', name: 'nomor'},
            {data: 'kategori', name: 'kategori', orderable: false},
            {data: 'nama', name: 'nama', orderable: false},
            {data: 'status', name: 'status', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        bFilter : false,
    });
});

$('#filter-resep-table').click(function(){
    resepTable.ajax.reload();
});

 $('#reset-filter-resep-table').click(function(event) {
    $("#nama_resep").val(null);
    $("#status").val('all');
    resepTable.ajax.reload();
});

//$(".datepicker").datepicker({dateFormat: 'dd-mm-yy'});

$('#table-resep').on('click','.status-resep',function(event){
    //event.preventDefault();
    var id_resep = $(this).attr('val');
    var status = $(this).attr('status');
    var status2 = (status == 'tutup')?'menutup':'membuka';

    if(confirm("Anda yakin akan "+status2+" resep ini?")){
        //return true;
        var url = "{{url('master/resep/editstatusresep')}}";
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "PUT",
            url: url,
            data:{
                'id_resep': id_resep,
                'status' : status,
            },
            success: function (response) {
                if(response == 'success'){
                    resepTable.ajax.reload();
                }
            },
            error: function (response) {
                //console.log('Error:', data);
            }
        });
         
    }else{
        return false;
    }
});


}); //=== /document.ready ====//



</script>
@endpush

