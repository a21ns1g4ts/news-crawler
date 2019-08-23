<?php

namespace App\Robots;

/**
 * Interface RobotContract
 * @package App\Robots
 */
interface RobotContract
{
    /**
     * Scan the given string and return an array
     * that contains objects searched by crawler
     *
     * @param $html
     * @return array
     */
    public function scan($html);

    /**
     * Get the robot function name
     *
     * @return string
     */
    public function getFunction();
}
