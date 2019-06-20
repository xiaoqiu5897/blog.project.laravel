<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [ 'thumbnail', 'description', 'name', 'slug','parent_id' ];

    protected $table = 'categories';

    
}
