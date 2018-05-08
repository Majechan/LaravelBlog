<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bloglist extends Model
{
    //
    //table name
    protected $table = 'bloglists';
    // primary key
    public $primaryKey = 'id';
    //timestamps
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
