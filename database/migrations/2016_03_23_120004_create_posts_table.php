<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * The table name.
     *
     * @var
     */
    protected $table = 'posts';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->integer('author_id')->unsigned();
            $table->string('tag', 128);
            $table->string('subject', 128);                 
            $table->text('body')->nullable();             
            $table->integer('views')->default(0);  
                       
            $table->foreign('product_id')
            ->references('id')->on('products')
            ->onUpdate('cascade')->onDelete('cascade');    

            $table->foreign('author_id')
            ->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->integer('updated_at');
            $table->integer('created_at');
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
