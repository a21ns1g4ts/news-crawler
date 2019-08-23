<?php

namespace App\Discoverers;

/**
 * Class DiscoveryCategory
 * @package App\Discoverers
 */
class DiscoveryCategory implements DiscoveryContract, DiscoveryCategoryContract
{

    /**
     * The content to analyze
     *
     * @var string
     */
    private $content;

    /**
     * DiscoveryCategory constructor
     *
     * @param $content
     */
    public function __construct($content){
        $this->content = $content;
        return $this;
    }

    /**
     * Detect the property of content
     *
     * @return void
     */
    public function detect()
    {

    }

    /**
     * Get category
     *
     * @return mixed|null
     */
    public function getCategory()
    {
       return null;
    }
}
