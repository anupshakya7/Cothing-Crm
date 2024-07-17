<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $fillable = ['title', 'show_title', 'position', 'display', 'order', 'published', 'filter', 'limit', 'category_id', 'style'];
    public function setShowTitleAttribute($value)
    {
        $this->attributes['show_title'] = !empty($value) ? $value : 0;
    }
    public function setPublishedAttribute($value)
    {
        $this->attributes['published'] = !empty($value) ? $value : 0;
    }
    public function setColumnAttribute($value)
    {
        $this->attributes['column'] = !empty($value) ? $value : 'col-md-12';
    }
    public function setFilterAttribute($value)
    {
        $this->attributes['filter'] = !empty($value) ? $value : 'recent';
    }
    public function setLimitAttribute($value)
    {
        $this->attributes['limit'] = !empty($value) ? $value : 6;
    }
    public function setCategoryIdAttribute($value)
    {
        $this->attributes['category_id'] = !empty($value) ? $value : 0;
    }
    public function setOrderAttribute($value)
    {
        $this->attributes['order'] = !empty($value) ? $value : 0;
    }

    public function category()
    {
        return $this->belongsTo(Page::class);
    }
}
