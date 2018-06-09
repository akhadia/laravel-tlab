@extends('adminlte::page')

@section('title', 'Satuan')

@section('content_header')
    <h1>Satuan</h1>
@stop
 

@section('content')

@include('flash::message')
<a href="{{ URL::to('master/satuan/create') }}" class="btn btn-primary btn-lg" role="button"><i class="fa fa-plus-circle"></i> Add New Satuan</a>
<div class="row">&nbsp;</div>

@include('master::Satuan.form-search')  

<div class="row">
    <div class="box">
        {{-- <div class="box-header with-border">
            <h3 class="box-title">Bordered Table</h3>
        </div> --}}
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered" id="table-satuan">
            <thead>
                <tr>
                    <th>No</th>
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

var satuanTable;
$(function() {
    satuanTable = $('#table-satuan').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
                url:'{{ url("master/satuan/loaddatasatuan") }}',
                data: function (d) {
                    return $.extend( {}, d, {
                        "nama_satuan": $("#nama_satuan").val(),
                        "status": $("#status").val(),
                    } );
                }
        },
        columns: [
            {data: 'nomor', name: 'nomor'},
            {data: 'nama', name: 'nama', orderable: false},
            {data: 'status', name: 'status', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        bFilter : false,
    });
});

$('#filter-satuan-table').click(function(){
    satuanTable.ajax.reload();
});

 $('#reset-filter-satuan-table').click(function(event) {
    $("#nama_satuan").val(null);
    $("#status").val('all');
    satuanTable.ajax.reload();
});

//$(".datepicker").datepicker({dateFormat: 'dd-mm-yy'});


});

$('#table-satuan').on('click','.hapus-satuan',function(event){
    //event.preventDefault();

    if(confirm("Anda yakin akan menghapus satuan ini?")){
        return true;
    }else{
        return false;
    }
});

</script>
@endpush

