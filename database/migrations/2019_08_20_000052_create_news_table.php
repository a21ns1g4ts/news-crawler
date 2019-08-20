<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateNewsTable
 */
class CreateNewsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'news';

    /**
     * Run the migrations.
     * @table news
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('source_id');
            $table->string('title', 250);
            $table->text('content');
            $table->string('url', 250);
            $table->string('url_to_image', 250)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('update_at')->nullable();

            $table->index(["category_id"], 'fk_news_category_idx');

            $table->index(["source_id"], 'fk_news_targets_idx');


            $table->foreign('source_id', 'fk_news_targets_idx')
                ->references('id')->on('source')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('category_id', 'fk_news_category_idx')
                ->references('id')->on('categories')
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
