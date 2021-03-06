<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SourceHasRobot
 *
 * @property int $source_id
 * @property int $robot_id
 *
 * @property \App\Models\Robot $robot
 * @property \App\Models\Source $source
 *
 * @package App\Models
 */
class SourceHasRobot extends Model
{
    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $casts = [
		'source_id' => 'int',
		'robot_id' => 'int'
	];

    /**
     * @var array
     */
    protected $fillable = [
		'source_id',
		'robot_id'
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function robot()
	{
		return $this->belongsTo(\App\Models\Robot::class, 'robot_id');
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function source()
	{
		return $this->belongsTo(\App\Models\Source::class);
	}
}
