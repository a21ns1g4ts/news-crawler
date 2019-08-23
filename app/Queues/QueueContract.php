<?php

namespace App\Queues;

use App\Models\Source;

/**
 * Interface QueueContract
 * @package App\Queues
 */
interface QueueContract
{
    /**
     * Get the first source to crawler
     *
     * @return $this
     */
    public function getFirstPendding();

    /**
     * Get the robot to action the target
     *
     * @return $this
     */
    public function getRobot();

    /**
     * Get the source to robot read
     *
     * @return Source
     */
    public function getSource();

    /**
     * Remove source from active queue
     *
     * @param Source $source
     * @return void
     */
    public function removeFromQueue(Source $source);

}
