<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustRole;
use Spatie\Activitylog\Traits\LogsActivity;

class Role extends EntrustRole
{
    use LogsActivity;

    protected $fillable = [
        'name', 'display_name', 'description'
    ];

    protected static $logAttributes =  ['name', 'display_name', 'description'];
}
