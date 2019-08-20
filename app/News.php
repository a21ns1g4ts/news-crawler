<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class News
 *
 * @property int $id
 * @property int $category_id
 * @property int $source_id
 * @property string $title
 * @property string $content
 * @property string $url
 * @property string $url_to_image
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $update_at
 *
 * @property \App\Category $category
 * @property \App\Source $source
 *
 * @package App
 */
class News extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $casts = [
		'category_id' => 'int',
		'source_id' => 'int'
	];

    /**
     * @var array
     */
    protected $dates = [
		'update_at'
	];

    /**
     * @var array
     */
    protected $fillable = [
		'category_id',
		'source_id',
		'title',
		'content',
		'url',
		'url_to_image',
		'update_at'
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
	{
		return $this->belongsTo(\App\Category::class);
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function source()
	{
		return $this->belongsTo(\App\Source::class);
	}
}
