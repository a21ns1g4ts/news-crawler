<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Robot
 *
 * @property int $id
 * @property string $model
 * @property string $function
 * @property string $health
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $update_at
 *
 * @property \Illuminate\Database\Eloquent\Collection $sources
 *
 * @package App\Models
 */
class Robot extends Model
{
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
		'model',
		'function',
		'health',
		'update_at'
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sources()
	{
		return $this->belongsToMany(\App\Models\Source::class, 'source_has_robots', 'robot_id');
	}
}
