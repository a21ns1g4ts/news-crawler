<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Source
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $url
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \Illuminate\Database\Eloquent\Collection $articles
 * @property \Illuminate\Database\Eloquent\Collection $robots
 *
 * @package App\Models
 * @method create($data)
 */
class Source extends Model
{
    /**
     * @var string
     */
    protected $table = 'sources';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $dates = [
		'updated_at'
	];

    /**
     * @var array
     */
    protected $fillable = [
		'name',
		'description',
		'url',
		'updated_at'
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function news()
	{
		return $this->hasMany(\App\Models\Article::class);
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function robots()
	{
		return $this->belongsToMany(\App\Models\Robot::class, 'source_has_robots', 'source_id', 'robot_id');
	}

    /**
     * Get source by url
     *
     * @param $url
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getByUrl($url)
    {
        return self::query()->where('url' , '=' , $url)->first();
    }

    /**
     * Get the pending sources to crawler
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getPenndingSources()
    {
        return self::query()
            ->where('updated_at' , '<=' , Carbon::now())
            ->orWhere('updated_at' , '=', null)
            ->get();
    }

}
