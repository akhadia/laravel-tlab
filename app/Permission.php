<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustPermission;
use Spatie\Activitylog\Traits\LogsActivity;

class Permission extends EntrustPermission
{
    use LogsActivity;

    protected $fillable = [
        'name', 'display_name', 'description'
    ];

    protected static $logAttributes =  ['name', 'display_name', 'description'];
}
