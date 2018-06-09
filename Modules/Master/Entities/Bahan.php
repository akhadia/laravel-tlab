<?php

namespace Modules\Master\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Bahan extends Model
{
    use LogsActivity;

    protected $table = 'bahan';
    protected $fillable = ['nama','id_satuan','aktif'];

    protected static $logAttributes =  ['nama','id_satuan','aktif'];

    public function satuan()
    {
        return $this->belongsTo('Modules\Master\Entities\Satuan','id_satuan');
    }

   



}
