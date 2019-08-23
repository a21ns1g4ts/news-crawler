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
 * @property \Illuminate\Database\Eloquent\Collection $articles
 *
 * @method create($data)
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
    public function articles()
	{
		return $this->hasMany(\App\Models\Article::class);
	}

    /**
     * Get category by name
     *
     * @param $name
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getByName($name)
    {
        return self::query()->where('name' , '=' , $name)->first();
    }

}
