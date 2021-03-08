<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $fillable = ['roleName', 'permission'];

    // public function role() {
    //     return $this->belogsTo('');
    // }
}
