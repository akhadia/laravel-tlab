<div class="row">
   <div class="form-group col-md-3">
        {{-- <input class="form-control" id="no_pemesanan" name="no_pemesanan" placeholder="Enter text.."> --}}
        {{ Form::text('nama_resep', '', array('id' => 'nama_resep', 'class' => 'form-control', 'placeholder' => 'Nama Resep...')) }}
    </div> 
</div>

<div class="row">
    <div class="form-group col-md-3">
        {{-- <label for="sel1">Status</label> --}}
        <select class="form-control" id="status" name="status">
            <option value="all">All Status</option>
            <option value="Y">Open</option>
            <option value="N">Closed</option>
        </select>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="col-md-offset-0 col-md-12">
            <button class="btn btn-warning" onclick="" id="filter-resep-table"><i class="fa fa-search"></i> Search</button>
            <button class="btn btn-warning" type="reset" id="reset-filter-resep-table" >Reset</button>
        </div>
    </div>
</div>
<div class="row">&nbsp;</div>