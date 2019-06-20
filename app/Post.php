<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
	use SoftDeletes;

	protected $dates = ['deleted_at'];

	protected $fillable = [ 'title', 'thumbnail', 'description', 'content', 'slug', 'user_id', 'category_id', 'view_count' ];

	public function categories()
	{
		return $this->belongsToMany('\App\Category', 'posts_category', 'post_id', 'category_id');
	}

	public function tags()
	{
		return $this->belongsToMany('\App\Tag', 'post_tags', 'post_id', 'tag_id');
	}

	public function user()
	{
		return $this->belongsTo('\App\User');
	}

}
