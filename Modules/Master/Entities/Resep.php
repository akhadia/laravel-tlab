<?php

namespace Modules\Master\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Resep extends Model
{
    use LogsActivity;
    protected $table = 'resep';
    protected $fillable = ['id_kategori','nama','deskripsi','user_input','user_update'];

    protected static $logAttributes = ['id_kategori','nama','deskripsi'];

    public function kategori()
    {
        return $this->belongsTo('Modules\Master\Entities\Kategori','id_kategori');
    }

    public function user(){
        return $this->belongsTo('App\User','user_input');
    }

    public function resep_detail(){
        return $this->hasMany('Modules\Master\Entities\ResepDetail');
    }


}

