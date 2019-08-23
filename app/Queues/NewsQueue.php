<?php

namespace App\Queues;

use App\Models\Source;
use App\Robots\RobotContract;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class NewsQueue
 * @package App\Queue
 */
class NewsQueue implements QueueContract
{
    /**
     * @var Source
     */
    private $source;

    /**
     * NewsQueue constructor.
     */
    public function __construct()
    {
        $this->source = new Source();
    }

    /**
     * Get the first source to crawler
     *
     * @return $this
     */
    public function getFirstPendding(){

        $this->source = $this->source
            ->newQuery()
            ->orderBy('updated_at' , 'asc')
            ->whereHas('robots' , function (Builder $query){
                return  $query->where('function', '=' , 'copiar_noticias_recentes');
            })
            ->first();

        return $this;
    }

    /**
     * Get the robot to action the source
     *
     * @return RobotContract
     */
    public function getRobot()
    {
        $robot = $this->source->robots[0];

        return app()->make($robot->model);
    }

    /**
     * Get the source to robot read
     *
     * @return Source
     */
    public function getSource()
    {
        return $this->source;
    }


    /**
     * Remove target of the current queue
     *
     * @param Source $source
     * @return void
     */
    public function removeFromQueue(Source $source)
    {
        $source->updated_at= Carbon::now()->timestamp;
        $source->save();
    }
}
