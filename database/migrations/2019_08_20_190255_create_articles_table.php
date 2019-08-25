<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateArticlesTable
 */
class CreateArticlesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'articles';

    /**
     * Run the migrations.
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
            $table->string('author', 100)->nullable();
            $table->text('description');
            $table->text('content')->nullable();
            $table->text('url');
            $table->text('url_to_image')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->index(["category_id"], 'fk_news_category_idx');

            $table->index(["source_id"], 'fk_news_targets_idx');


            $table->foreign('source_id', 'fk_news_targets_idx')
                ->references('id')->on('sources')
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
