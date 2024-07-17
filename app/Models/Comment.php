<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;


class Comment extends Model
{
	use PresentableTrait;

	protected $presenter = 'App\Presenters\CommentPresenter';

    protected $fillable = ['post_id', 'name', 'email', 'message'];

    public function post()
    {
    	return $this->belongsTo(Post::class);
    }
}
