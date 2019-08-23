<?php

namespace App\Discoverers;

/**
 * Interface DiscoveryContract
 * @package App\Discoverers
 */
interface DiscoveryContract
{
    /**
     * Detect the property of content
     *
     * @return void
     */
    public function detect();
}
