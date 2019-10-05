<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use GrahamCampbell\Markdown\Facades\Markdown;
class Post extends Model
{	
    protected $fillable = ['title', 'slug', 'excerpt', 'body', 'published_at', 'category_id', 'image'];
    protected $dates = ['published_at'];

	public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function getImageUrlAttribute($value){
    	$imageUrl = "";
    	if(! is_null($this->image)){

    		$imagePath = public_path()."/app/img/".$this->image;
    		if(file_exists($imagePath)) $imageUrl = asset("app/img/". $this->image);
    	}
    	return $imageUrl;
    }

    public function getImageThumbUrlAttribute($value)
    {
        $imageUrl = "";

        if ( ! is_null($this->image))
        {
            $ext       = substr(strrchr($this->image, '.'), 1);
            $thumbnail = str_replace(".{$ext}", "_thumb.{$ext}", $this->image);
            $imagePath = public_path() . "/app/img/" . $thumbnail;
            if (file_exists($imagePath)) $imageUrl = asset("app/img/" . $thumbnail);
        }

        return $imageUrl;
    }


    public function getDateAttribute($value)
    {
        return is_null($this->published_at) ? '' : $this->published_at->diffForHumans();
    }


    public function getBodyHtmlAttribute($value)
    {
        return $this->body ? Markdown::convertToHtml(e($this->body)) : NULL;
    }


    public function getExcerptHtmlAttribute($value)
    {
        return $this->excerpt ? Markdown::convertToHtml(e($this->excerpt)) : NULL;
    }

    public function dateFormatted($showTimes = false)
    {
        $format = "d/m/Y";
        if ($showTimes) $format = $format . " H:i:s";
        return $this->created_at->format($format);
    }

    public function publicationLabel()
    {
        if ( ! $this->published_at) {
            return '<span class="label label-warning">Draft</span>';
        }
        elseif ($this->published_at && $this->published_at->isFuture()) {
            return '<span class="label label-info">Schedule</span>';
        }
        else {
            return '<span class="label label-success">Published</span>';
        }
    }


    public function scopeLatestFirst($query)
    {
        return $query->orderBy('published_at', 'desc');
    }


    public function scopePopular($query)
    {
        return $query->orderBy('view_count','desc');
    }


    public function scopePublished($query)
    {
        return $query->where("published_at", "<=", Carbon::now());
    }

}
