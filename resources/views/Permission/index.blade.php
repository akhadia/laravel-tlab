@extends('adminlte::page')

@section('title', 'Permission')

@section('content_header')
    <h1>Permission</h1>
@stop
 

@section('content')

@include('flash::message')
<a href="{{ URL::to('permission/create') }}" class="btn btn-primary btn-lg" permission="button"><i class="fa fa-plus-circle"></i> Add New Permission</a>
<div class="row">&nbsp;</div>

@include('Permission.form-search')  

<div class="row">
    <div class="box">
        {{-- <div class="box-header with-border">
            <h3 class="box-title">Bordered Table</h3>
        </div> --}}
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered" id="table-permission">
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

var permissionTable;
$(function() {
    permissionTable = $('#table-permission').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
                url:'{{ url("permission/loaddata") }}',
                data: function (d) {
                    return $.extend( {}, d, {
                        "nama_permission": $("#nama_permission").val(),
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

$('#filter-permission-table').click(function(){
    permissionTable.ajax.reload();
});

 $('#reset-filter-permission-table').click(function(event) {
    $("#nama_permission").val(null);
    $("#status").val('all');
    permissionTable.ajax.reload();
});

//$(".datepicker").datepicker({dateFormat: 'dd-mm-yy'});
$('#table-permission').on('click','.hapus-permission',function(event){
    //event.preventDefault();
    var id_permission = $(this).attr('val');

    if(confirm("Anda yakin akan hapus permission ini?")){
        //return true;
        
        var url = "{{url('permission/delete')}}";
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: url,
            data:{
                'id_permission': id_permission,
            },
            success: function (response) {

                if(response == true){
                    toastr.success('Data permission berhasil dihapus',"Success");
                    permissionTable.ajax.reload();
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

