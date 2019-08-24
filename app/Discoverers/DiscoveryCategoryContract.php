<?php


namespace App\Discoverers;


/**
 * Interface DiscoveryCategoryContract
 * @package App\Discoverers
 */
interface DiscoveryCategoryContract
{
    /**
     * Get category
     *
     * @return string|null
     */
    public function getCategory();
}
