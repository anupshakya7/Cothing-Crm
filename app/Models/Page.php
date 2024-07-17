<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Baum\Node;


class Page extends Node
{
	use PresentableTrait;
	protected $presenter = 'App\Presenters\PagePresenter';
    protected $fillable = ['title', 'name', 'uri', 'type', 'content', 'user_id', 'hidden', 'template', 'language'];
    protected $appends = ['paddleTitle'];

    public function updateOrder($order, $orderPage)
    {
        if ($order=='before') {
            $this->moveToLeftOf($orderPage);
        }elseif ($order=='after') {
            $this->moveToRightOf($orderPage);
        }elseif ($order=='childOf') {
            $this->makeChildOf($orderPage);
        }
    }

    public function getPaddedTitleAttribute()
    {
        // return str_repeat("&nbsp; ", $this->depth * 2).$this->title;
         return str_repeat("_", $this->depth * 2).$this->title;
    }


    // Set method
    public function setTemplateAttribute($value)
    {
        $this->attributes['template'] = !empty($value) ? $value : null;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = !empty($value) ? $value : null;
    }

    public function setLanguageAttribute($value)
    {
        $this->attributes['language'] = !empty($value) ? $value : Lang::getLocale();
    }

    public function setHiddenAttribute($value)
    {
        $this->attributes['hidden'] = !empty($value) ? $value : 0;
    }

    public function posts()
    {
        return $this->hasMany('App\Post', 'category_id');
    }

    public function blocks()
    {
        return $this->hasMany('App\Block', 'category_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

}
