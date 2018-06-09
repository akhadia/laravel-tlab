<?php

namespace Modules\Master\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class Satuan extends Model
{
    use LogsActivity;

    protected $table = 'satuan';
    protected $fillable = ['nama', 'aktif'];
    
    protected static $logAttributes = ['nama', 'aktif'];

    public function bahan()
    {
        return $this->hasMany('Modules\Master\Entities\Bahan','id_satuan');
    }

     // this is a recommended way to declare event handlers
     protected static function boot() {
        parent::boot();

        // static::deleting(function($satuan) { // before delete() method call this
        //      $satuan->bahan()->delete();
        //      // do the rest of the cleanup...
        // });
    }

}
