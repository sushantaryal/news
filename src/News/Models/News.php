<?php

namespace Taggers\News\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class News extends Model
{
    use Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'image', 'image_thumb', 'description', 'status',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /*****************/
    /* Relationships */
    /*****************/
    public function categories()
    {
		return $this->belongsToMany(NewsCategory::class, 'category_news', 'news_id', 'category_id')->withTimestamps();
    }

    /**********/
	/* Scopes */
	/**********/
    public function scopePublished($query)
	{
		return $query->where('status', 1);
	}

    /**********************/
	/* Additional Methods */
	/**********************/
	public function delete()
	{
		$this->categories()->detach();
		if($this->image && app('files')->exists($this->image)) {
			app('files')->delete($this->image);
			app('files')->delete($this->image_thumb);
		}
		parent::delete();
	}

    public static function archives()
	{
		$archives = self::select(DB::raw('
				YEAR(created_at) AS year,
				MONTH(created_at) AS month,
				MONTHNAME(created_at) AS monthname,
				COUNT(*) AS count
			'))
			->published()
			->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y%m")'))
			->groupBy('created_at')
			->orderBy('created_at', 'desc')
			->get();
		// Convert it to a nicely formatted array so we can easily render the view
		$results = [];
		foreach ($archives as $archive)
		{
			$results[$archive->year][$archive->month] = [
				'monthname' => $archive->monthname,
				'count'     => $archive->count
			];
		}
		return $results;
	}

    public function categoryArray()
	{
		return $this->categories()->pluck('category_id')->all();
	}

	public function categoryString()
	{
		return implode(', ', $this->categories()->pluck('title')->all());
	}

	public function statusString()
	{
		if($this->status == 1) {
			return '<a href="'.route('news.updatestatus', $this->id).'"><span class="label label-success">Public</span></a>';
		} else {
			return '<a href="'.route('news.updatestatus', $this->id).'"><span class="label label-danger">Hidden</span></a>';
		}
	}
}
