<?php

namespace Modules\Master\Entities;

use Illuminate\Database\Eloquent\Model;

class ResepDetail extends Model
{
    protected $table = 'resep_detail';
    protected $fillable = ['id_resep', 'id_bahan', 'id_satuan', 'qty_bahan'];

    // public function resep(){
    //     return $this->hasOne('Modules\Master\Entities\Resep');
    // }

    public function resep()
    {
        return $this->belongsTo('Modules\Master\Entities\Resep','id_resep');
    }

    public function bahan()
    {
        return $this->belongsTo('Modules\Master\Entities\Bahan','id_bahan');
    }

    public function satuan()
    {
        return $this->belongsTo('Modules\Master\Entities\Satuan','id_satuan');
    }

    
}
