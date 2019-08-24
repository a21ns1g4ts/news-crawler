<?php

namespace App\Discoverers;

use App\Models\Category;
use AYLIEN\TextAPI;
use Illuminate\Support\Str;

/**
 * Class DiscoveryAylienCategory
 * @package App\Discoverers
 */
class DiscoveryAylienCategory implements DiscoveryContract, DiscoveryCategoryContract
{

    /**
     * The content to analyze
     *
     * @var string
     */
    private $content;

    /**
     * @var TextAPI
     */
    private $service;

    /**
     * @var null
     */
    private $category = null;

    /**
     * @var
     */
    private $detected;

    /**
     * DiscoveryAylienCategory constructor
     *
     * @param $content
     */
    public function __construct($content){
        $this->content = $content;
        $this->service = new TextAPI(env('DISCOVERY_AYLIEN_APP_ID'), env('DISCOVERY_AYLIEN_API_KEY'));
        return $this;
    }

    /**
     * Detect the property of content
     *
     * @return void
     */
    public function detect()
    {
       $keyWords = $this->service->Entities(
           [
               'text' => $this->content,
               'language' => env('DISCOVERY_LANG')
           ]
       )->entities;

        $this->detected = isset($keyWords->keyword) ? $keyWords->keyword : [];

    }

    /**
     * Get the category
     *
     * @return string|null
     */
    public function getCategory()
    {
        $categoriesCandidates = [];

        $categories = Category::all()->pluck('name')->toArray();

        $categories = array_map('strtolower', $categories);

        $keyWords = $this->detected;

        foreach ($keyWords as $keyWord){
            if (in_array(Str::lower($keyWord) , $categories)){
                $categoriesCandidates[] = $keyWord;
            }
        }

        if (count($categoriesCandidates) > 0){
            return $this->category = $categoriesCandidates[0];
        }

        $this->category = Str::title($this->category);

        if (count($categoriesCandidates) === 0){
            $this->category = null;
        }

        return $this->category;
    }
}
