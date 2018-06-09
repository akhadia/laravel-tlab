@push('js')
<script type="text/javascript">
$(document).ready(function() {

	//validasi semua inputan jika tombol simpan ditekan
	$('.submit-button').click(function() {
		var n=input_validation_bahan();
		console.log(n);
		if(n > 0){
			return false;
		}
	});
	
});


//tombol add data
$('#add_data_bahan').click(function() {

	$('.cari_bahan').typeahead('destroy'); 	//destroy typeahead binding event before adding new row

    var count = $('#hide_count_bahan').val();
    count = parseInt(count);
    var count2 = count+1;
    $('#hide_count_bahan').val(count2);
    add_data_bahan_to_table(count);
	typeahead_bahan_initialize();
    return false;
});

//tambah data ke tabel
function add_data_bahan_to_table(count){
    $('<tr class="isi_data_bahan" id="data_bahan_ke-'+count+'">\n\
	 		<td>\n\
	          <a id="'+count+'" class="delete_bahan_data_detail btn btn-xs btn-danger" href="#">\n\
	          <span title="Batal" class="glyphicon glyphicon-trash"></span></a>&nbsp;&nbsp;\n\
	      	</td>\n\
            <td id="bahan_nama_place_'+count+'">\n\
				<input type="text" id="bahan_nama_'+count+'" name="bahan_nama[]" class="form-control cari_bahan typeahead" tujuan="'+count+'" autocomplete="off">\n\
				<input type="hidden" id="id_bahan_'+count+'" name="id_bahan[]" class="id_bahan_value" value=""/>\n\
			</td>\n\
            <td id="bahan_qty_place_'+count+'">\n\
				<input type="text" id="bahan_qty_'+count+'" name="bahan_qty[]" class="form-control input-xsmall qty_bahan" tujuan="'+count+'" ></input>\n\
			</td>\n\
			<td id="bahan_satuan_place_'+count+'" align="center">\n\
				<span id="bahan_satuan_text_'+count+'"></span>\n\
				<input type="hidden" id="id_satuan_'+count+'" name="id_satuan[]" class="form-control input-small" value="" tujuan="'+count+'" ></input>\n\
			</td>\n\
  	</tr>').appendTo('#isi_tabel_bahan')
}

//delete row tabel new
$( "#isi_tabel_bahan" ).on( "click", ".delete_bahan_data_detail", function() {
    var no = $(this).attr('id');
    var stat ='new';
    delete_data_bahan_table(no,stat);
    return false;
});

//delete row tabel edit
$( "#isi_tabel_bahan" ).on( "click", ".delete_bahan_edit_detail", function() {
	var no = $(this).attr('id');
	var stat ='edit';
	delete_data_bahan_table(no,stat);
	return false;
});

//fungsi untuk delete row tabel
function delete_data_bahan_table(no,stat){
	if(confirm("Anda yakin akan menghapus data ini?")){

		if(stat == 'edit'){
			var id_detail = $('#old_id_resep_bahan_'+no).val();
        	$('<input type="hidden"  name="details_deleted[]" value="'+id_detail+'"/>').appendTo('#delete_details_bahan');
		}

		$('#data_bahan_ke-'+no).detach();

		if($('.isi_data_bahan').length < 1){
			$('#hide_count_bahan').val(1);
			$('#kaki_tabel_bahan').fadeOut('fast');
		}
		return false;
	}
}

//== autocomplete bahan ==//
function typeahead_bahan_initialize() {
	var engine = new Bloodhound({
		remote: {
			url: '{{ url("master/autocomplete/bahan") }}?q=%QUERY',
			wildcard: "%QUERY"
		},
		datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
		queryTokenizer: Bloodhound.tokenizers.whitespace
	});

	$(".cari_bahan").typeahead({
		hint: true,
		highlight: true,
		minLength: 1
	}, {
		source: engine.ttAdapter(),
		name: 'bahan',
		displayKey: "nama_bahan",

		templates: {
			empty: [
				'<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'
			],
			header: [
				'<div class="list-group search-results-dropdown">'
			],
			suggestion: function (data) {
				return '<div class="list-group-item">' + data.nama_bahan + '</div>'
			}
		}
	}).bind("typeahead:selected", function(obj, datum, name) {
		var no = $(this).attr('tujuan');
		console.log(no);
		$('#id_bahan_'+no).val(datum.id_bahan);
		$('#id_satuan_'+no).val(datum.id_satuan);
		$('#bahan_satuan_text_'+no).text(datum.nama_satuan);

	}).bind("typeahead:change", function(obj, datum, name) {
		//do..
	});
}

//fungsi validasi
function input_validation_bahan(status){
	var n=0;var pesan='';

	//jika tombol submit ditekan maka semua inputan
	var nama_resep = $('#nama_resep').val();
	if(nama_resep == '' || nama_resep == null){
		n=n+1;
		error = "Kolom nama resep belum diisi dengan benar!<br/><br/>\n";
		pesan = pesan+error;
	}

	var cari_bahan = $(".cari_bahan.typeahead.tt-input");
	cari_bahan.each( function(i) {
		var value=$(this).val();
		var no = $(this).attr('tujuan');
		var j = i+1;
		var id_bahan = $('#id_bahan_'+no).val();

		if(value.length < 1){
			n=n+1;
		}

		if(id_bahan.length == '' || id_bahan.length == null){
			n=n+1;
		}

		if(n > 0){
			error = "Kolom bahan no "+j+" belum diisi dengan benar!<br/><br/>\n";
			pesan = pesan+error;
		}
		
	});

	var qty_bahan = $(".qty_bahan");
	qty_bahan.each( function(i) {
		var value=$(this).val();
		var no = $(this).attr('tujuan');
		var j = i+1;
		if(isNaN(value) || value < 1){
			error = "Kolom qty no "+j+" belum diisi dengan benar!<br/><br/>\n";
			pesan = pesan+error;
			n=n+1;
		}
	});


	if(n > 0){
		toastr.error(pesan,"Gagal","error");
		// alert(pesan);
	}
	return n;
}


</script>
@endpush