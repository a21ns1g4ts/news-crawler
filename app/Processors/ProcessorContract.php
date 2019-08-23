<?php

namespace App\Processors;

/**
 * Interface ProcessorContract
 * @package App\Processors
 */
interface ProcessorContract
{
    /**
     * Sync objects given by robots
     *
     * @param array $data
     * @return mixed
     */
    public function syncObjects(array $data);

    /**
     * Start the robot
     *
     * @return void
     */
    public function start();
}
