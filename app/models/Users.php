<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Users extends Eloquent {
    public $name;
    public $timestamps = ['created_at','updated_at'];

    protected $fillable = ['username', 'email'];
}