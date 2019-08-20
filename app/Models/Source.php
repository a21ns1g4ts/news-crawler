<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Source
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $url
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $update_at
 *
 * @property \Illuminate\Database\Eloquent\Collection $news
 * @property \Illuminate\Database\Eloquent\Collection $robots
 *
 * @package App\Models
 */
class Source extends Model
{
    /**
     * @var string
     */
    protected $table = 'source';

    /**
     * @var bool
     */
    public $timestamps = false;

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
		'name',
		'description',
		'url',
		'update_at'
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
}
