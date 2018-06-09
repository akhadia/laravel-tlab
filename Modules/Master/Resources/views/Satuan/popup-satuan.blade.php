@extends('layouts.modal')

@section('title', $title='Cari Satuan')
@section('modalClass')
@section('sub-content')

<div class="row">
    <div class="col-md-12">
        {{ Form::model(null,array('class'=>'form-inline form-bordered','id'=>'satuan-form','method'=>'POST','onsubmit'=>'return false')) }}

             <div class="form-group">
                    {{-- <label for="bahan" class="col-sm-2 control-label">Bahan</label> --}}
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nama_satuan" name="nama_satuan" value="" placeholder="Nama satuan...">
                </div>
            </div>
            <button class="btn blue" onclick="" id="filter-satuan-popup-table">Search</button>

        {{ Form::close() }}
    </div>
</div>

<div class="modal-body">
    <div class="table-responsive">
            <table class="table table-bordered" id="satuan-popup-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Satuan</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            </table>
    </div>
</div>

@endsection

{{-- @push('css')
<style type="text/css"> 
    table.dataTable thead th {
        border-bottom: 0;
    }
    table.dataTable.no-footer {
        border-bottom: 0;
    }
</style>
@endpush --}}

@push('js')
<script type="text/javascript">

var satuanTable;
$(function() {
    satuanTable = $('#satuan-popup-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
                url:'{{ url("master/satuan/loaddatapopupsatuan") }}',
                data: function (d) {
                    return $.extend( {}, d, {
                        "nama_satuan": $("#nama_satuan").val(),
                    } );
                }
        },
        columns: [
            {data: 'nomor', name: 'nomor'},
            {data: 'nama', name: 'nama', orderable: false},
            {data: 'status', name: 'status', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        bLengthChange: false,
        bFilter : false,
        bInfo : false,
    });
});

$('#filter-satuan-popup-table').click(function(){
    satuanTable.ajax.reload();
});


//$(".datepicker").datepicker({dateFormat: 'dd-mm-yy'});

$("#satuan-popup-table").delegate('.select-satuan-from-popup', 'click', function(event) {
    $.getJSON('{{ url('master/satuan/getsatuan') }}/'+$(this).data("id"), {}, function(json, textStatus) {
        $(json).each(function(idx,vl){
            console.log(vl);
            $("#bahan-form").find('#id_satuan').val(vl.id);
            $("#bahan-form").find('#nama_satuan').val(vl.nama);
            $("#bahan-form").find('#old_nama_satuan').val(vl.nama);
        });

        $("#close-popup").click();
    });
});

</script>
@endpush