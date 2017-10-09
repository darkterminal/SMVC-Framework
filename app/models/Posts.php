<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Posts extends Eloquent {
    public $name;
    public $timestamps = ['created_at','updated_at'];

    protected $fillable = ['title', 'body','author'];
}