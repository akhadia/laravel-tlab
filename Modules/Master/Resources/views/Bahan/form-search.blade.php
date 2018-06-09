<div class="row">
   <div class="form-group col-md-3">
        {{-- <input class="form-control" id="no_pemesanan" name="no_pemesanan" placeholder="Enter text.."> --}}
        {{ Form::text('nama_bahan', '', array('id' => 'nama_bahan', 'class' => 'form-control', 'placeholder' => 'Nama Bahan...')) }}
    </div> 
</div>

<div class="row">
    <div class="form-group col-md-3">
        {{-- <label for="sel1">Status</label> --}}
        <select class="form-control" id="status" name="status">
            <option value="all">All Status</option>
            <option value="Y">Aktif</option>
            <option value="N">Non Aktif</option>
        </select>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="col-md-offset-0 col-md-12">
            <button class="btn btn-warning" onclick="" id="filter-bahan-table"><i class="fa fa-search"></i> Search</button>
            <button class="btn btn-warning" type="reset" id="reset-filter-bahan-table" >Reset</button>
        </div>
    </div>
</div>
<div class="row">&nbsp;</div>