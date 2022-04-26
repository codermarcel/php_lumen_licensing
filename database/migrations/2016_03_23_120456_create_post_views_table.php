<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostViewsTable extends Migration
{
    /**
     * The table name.
     *
     * @var
     */
    protected $table = 'post_views';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_id')->unsigned();
            $table->string('ip_address');
                       
            $table->foreign('post_id')
            ->references('id')->on('posts')
            ->onUpdate('cascade')->onDelete('cascade');    

            $table->integer('updated_at');
            $table->integer('created_at');
            $table->unique(array('post_id', 'ip_address'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop($this->table);
    }
}
