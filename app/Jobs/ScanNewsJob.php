<?php

namespace App\Jobs;

use App\Processors\ProcessorNews;
use App\Queues\NewsQueue;

/**
 * Class ScanNewsJob
 * @package App\Jobs
 */
class ScanNewsJob extends Job
{
    /**
     * @var int
     */
    public $tries = 3;

    /**
     * @var NewsQueue
     */
    public $newsQueue;

    /**
     * Create a new job instance.
     * @param NewsQueue $newsQueue
     */
    public function __construct(NewsQueue $newsQueue)
    {
        $this->newsQueue = $newsQueue;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        $job = $this->newsQueue->getFirstPendding();

        $robot = $job->getRobot();
        $source = $job->getSource();

        $processor = new ProcessorNews($robot, $source);
        $processor->start();

        $job->removeFromQueue($source);
    }
}
