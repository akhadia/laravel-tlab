<?php

namespace Modules\Master\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class kategori extends Model
{
    use LogsActivity;
    protected $table = 'kategori';
    protected $fillable = ['nama', 'aktif'];

    protected static $logAttributes =  ['nama', 'aktif'];

    public function resep()
    {
        return $this->hasMany('Modules\Master\Entities\Resep','id_kategori');
    }
}
