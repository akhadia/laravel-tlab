@extends('adminlte::page')

@section('title', 'Kategori')

@section('content_header')
    <h1>Kategori</h1>
@stop
 

@section('content')

@include('flash::message')
<a href="{{ URL::to('master/kategori/create') }}" class="btn btn-primary btn-lg" role="button"><i class="fa fa-plus-circle"></i> Add New Kategori</a>
<div class="row">&nbsp;</div>

@include('master::Kategori.form-search')  

<div class="row">
    <div class="box">
        {{-- <div class="box-header with-border">
            <h3 class="box-title">Bordered Table</h3>
        </div> --}}
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered" id="table-kategori">
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

var kategoriTable;
$(function() {
    kategoriTable = $('#table-kategori').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
                url:'{{ url("master/kategori/loaddatakategori") }}',
                data: function (d) {
                    return $.extend( {}, d, {
                        "nama_kategori": $("#nama_kategori").val(),
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

$('#filter-kategori-table').click(function(){
    kategoriTable.ajax.reload();
});

 $('#reset-filter-kategori-table').click(function(event) {
    $("#nama_kategori").val(null);
    $("#status").val('all');
    kategoriTable.ajax.reload();
});

//$(".datepicker").datepicker({dateFormat: 'dd-mm-yy'});


});

$('#table-kategori').on('click','.hapus-kategori',function(event){
    //event.preventDefault();

    if(confirm("Anda yakin akan menghapus kategori ini?")){
        return true;
    }else{
        return false;
    }
});

</script>
@endpush

