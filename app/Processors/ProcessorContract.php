<?php

namespace App\Processors;

/**
 * Interface ProcessorContract
 *
 * @package App\Processors
 */
interface ProcessorContract
{
    /**
     * Sync data given by robots
     *
     * @param array $data
     * @return mixed
     */
    public function syncData(array $data);

    /**
     * Handle processor
     *
     * @return void
     */
    public function handle();
}
