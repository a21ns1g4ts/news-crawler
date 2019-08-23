<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateSourceHasRobotsTable
 */
class CreateSourceHasRobotsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'source_has_robots';

    /**
     * Run the migrations.
     * @table source_has_robots
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('source_id');
            $table->unsignedInteger('robot_id');

            $table->index(["robot_id"], 'fk_source_has_robots_robot_idx');

            $table->index(["source_id"], 'fk_source_has_robots_source_idx');


            $table->foreign('source_id', 'fk_source_has_robots_source_idx')
                ->references('id')->on('sources')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('robot_id', 'fk_source_has_robots_robot_idx')
                ->references('id')->on('robots')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->tableName);
     }
}
