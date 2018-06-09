@extends('adminlte::page')

@section('title', 'Role')

@section('content_header')
    <h1>Role</h1>
@stop
 

@section('content')

@include('flash::message')
<a href="{{ URL::to('role/create') }}" class="btn btn-primary btn-lg" role="button"><i class="fa fa-plus-circle"></i> Add New Role</a>
<div class="row">&nbsp;</div>

@include('Role.form-search')  

<div class="row">
    <div class="box">
        {{-- <div class="box-header with-border">
            <h3 class="box-title">Bordered Table</h3>
        </div> --}}
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered" id="table-role">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Display Name</th>
                    {{-- <th>Status</th> --}}
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

var roleTable;
$(function() {
    roleTable = $('#table-role').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
                url:'{{ url("role/loaddata") }}',
                data: function (d) {
                    return $.extend( {}, d, {
                        "nama_role": $("#nama_role").val(),
                        "status": $("#status").val(),
                    } );
                }
        },
        columns: [
            {data: 'nomor', name: 'nomor'},
            {data: 'name', name: 'name', orderable: false},
            {data: 'display_name', name: 'display_name', orderable: false},
            //{data: 'status', name: 'status', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        bFilter : false,
    });
});

$('#filter-role-table').click(function(){
    roleTable.ajax.reload();
});

 $('#reset-filter-role-table').click(function(event) {
    $("#nama_role").val(null);
    $("#status").val('all');
    roleTable.ajax.reload();
});

//$(".datepicker").datepicker({dateFormat: 'dd-mm-yy'});
$('#table-role').on('click','.hapus-role',function(event){
    //event.preventDefault();
    var id_role = $(this).attr('val');

    if(confirm("Anda yakin akan hapus role ini?")){
        //return true;
        console.log('okk');
        var url = "{{url('role/deleterole')}}";
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: url,
            data:{
                'id_role': id_role,
            },
            success: function (response) {
                if(response == true){
                    toastr.success('Data role berhasil dihapus',"Success");
                    roleTable.ajax.reload();
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



//== /document.ready ===//
});

</script>
@endpush

