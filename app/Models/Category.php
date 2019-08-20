<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 *
 * @property int $id
 * @property string $name
 * @property string $description
 *
 * @property \Illuminate\Database\Eloquent\Collection $news
 *
 * @package App\Models
 */
class Category extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
		'name',
		'description'
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function news()
	{
		return $this->hasMany(\App\Models\Article::class);
	}
}
