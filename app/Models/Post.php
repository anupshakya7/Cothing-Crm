<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Cviebrock\EloquentSluggable\Sluggable;


class Post extends Model
{
    use PresentableTrait;
    use Sluggable;

    protected $presenter = 'App\Presenters\PostPresenter';
    protected $fillable = ['category_id', 'author_id', 'title', 'slug', 'image', 'body', 'excerpt', 'published_at', 'language'];
    protected $dates = ['published_at'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function setPublishedAttribute($value)
    {
        $this->attributes['published_at'] = $value ?: null;
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    	// return $this->belongsTo('App\User', 'author_id');
    }

    public function category()
    {
        return $this->belongsTo(Page::class);
    	// return $this->belongsTo('App\Page', 'category_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
