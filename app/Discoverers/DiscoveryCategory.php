<?php

namespace App\Discoverers;

/**
 * Class DiscoveryCategory
 * @package App\Discoverers
 */
class DiscoveryCategory implements DiscoveryContract
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
     * @return null/string
     */
    public function detect()
    {
       return null;
    }
}
