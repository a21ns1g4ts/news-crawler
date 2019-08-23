<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Article
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
 * @property \App\Models\Category $category
 * @property \App\Models\Source $source
 *
 * @package App\Models
 * @method create($data)
 */
class Article extends Model
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
		'updated_at',
        'created_at'
	];

    /**
     * @var array
     */
    protected $fillable = [
		'category_id',
        'description',
        'author',
		'source_id',
		'title',
		'content',
		'url',
		'url_to_image',
        'updated_at',
        'created_at'
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
	{
		return $this->belongsTo(\App\Models\Category::class);
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function source()
	{
		return $this->belongsTo(\App\Models\Source::class);
	}

    /**
     * Get article by url
     *
     * @param $url
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getByUrl($url)
    {
        return self::query()->where('url' , '=' , $url)->first();
    }

}
