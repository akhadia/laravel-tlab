
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Aksi</th>
            <th>Bahan</th>
            <th>Jumlah</th>
            <th>Satuan</th>
        </tr>
    </thead>
    <tbody id="isi_tabel_bahan">
        @if (isset($detailResep) && !empty($detailResep))
            @foreach ($detailResep as $num => $row)
                <tr class="isi_data_bahan" id="data_bahan_ke-{{$num+1}}">
                    <td>
                        @if($resep->aktif !== 'N')
                        <a id="{{$num+1}}" class="delete_bahan_edit_detail btn btn-xs btn-danger" href="#">
                            <span title="Batal" class="glyphicon glyphicon-trash"></span>
                        </a>
                        @endif
                    </td>
                    <td id="bahan_nama_place_{{$num+1}}">
                        <input {{$readonly}} type="text" id="bahan_nama_{{$num+1}}" name="bahan_nama_edit[]" class="form-control input-small cari_bahan typeahead input-xlarge"
                                value="{{$row->bahan->nama}}" tujuan="{{$num+1}}" ></input>
                        <input type="hidden" id="id_bahan_{{$num+1}}" name="id_bahan_edit[]" class="id_bahan_value" value="{{$row['id_bahan']}}"/>
                
                    </td>
                    <td id="bahan_qty_place_{{$num+1}}" align="center">
                        <input {{$readonly}} type="text" id="bahan_qty_{{$num+1}}" name="bahan_qty_edit[]" class="form-control input-xsmall" 
                                value="{{$row['qty_bahan']}}" tujuan="{{$num+1}}"></input>
                    </td>
                    <td id="bahan_satuan_place_{{$num+1}}" align="center">
                        <span id="bahan_satuan_text_{{$num+1}}">{{ ($row->satuan->nama != null)?$row->satuan->nama:''}}</span>
                        <input type="hidden" id="id_satuan_{{$num+1}}" name="id_satuan_edit[]" class="id_satuan_value" value="{{$row['id_satuan']}}"/>                                    </td>
                    </td>
                    <input type="hidden" id="count_input_{{$num+1}}" name="count[]" value="{{$num+1}}"/>
                    <input type="hidden" id="old_id_resep_bahan_{{$num+1}}" name="old_id_resep_bahan_edit[]" class="old_id_resep_bahan_input" value="{{$row['id']}}"/>
                </tr>
            @endforeach
        @endif
    </tbody>

</table>

<div id="delete_details_bahan"></div>

<br />
<input type="hidden" value="{{ (isset($num)) ? $num+2 : 1 }}" id="hide_count_bahan" name="hide_count_bahan"/>
@if ($resep->aktif !== 'N')
    <button type="button" name="add_data_bahan" id="add_data_bahan" class="btn btn-success">Tambah Data Bahan</button>
@endif


@include('master::Resep.add-resep-detail-js')