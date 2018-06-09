@extends('adminlte::page')

@section('title', 'Bahan')

@section('content_header')
    <h1>Bahan</h1>
@stop
 

@section('content')

@include('flash::message')
<a href="{{ URL::to('master/bahan/create') }}" class="btn btn-primary btn-lg" role="button"><i class="fa fa-plus-circle"></i> Add New Bahan</a>
<div class="row">&nbsp;</div>

@include('master::Bahan.form-search')  

<div class="row">
    <div class="box">
        {{-- <div class="box-header with-border">
            <h3 class="box-title">Bordered Table</h3>
        </div> --}}
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered" id="table-bahan">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Satuan</th>
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

var bahanTable;
$(function() {
    bahanTable = $('#table-bahan').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
                url:'{{ url("master/bahan/loaddatabahan") }}',
                data: function (d) {
                    return $.extend( {}, d, {
                        "nama_bahan": $("#nama_bahan").val(),
                        "status": $("#status").val(),
                    } );
                }
        },
        columns: [
            {data: 'nomor', name: 'nomor'},
            {data: 'nama', name: 'nama', orderable: false},
            {data: 'satuan', name: 'satuan', orderable: false},
            {data: 'status', name: 'status', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        bFilter : false,
    });
});

$('#filter-bahan-table').click(function(){
    bahanTable.ajax.reload();
});

 $('#reset-filter-bahan-table').click(function(event) {
    $("#nama_bahan").val(null);
    $("#status").val('all');
    bahanTable.ajax.reload();
});

//$(".datepicker").datepicker({dateFormat: 'dd-mm-yy'});


});

$('#table-bahan').on('click','.hapus-bahan',function(event){
    //event.preventDefault();

    if(confirm("Anda yakin akan menghapus bahan ini?")){
        return true;
    }else{
        return false;
    }
});

</script>
@endpush

