<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotesTable extends Migration
{
    /**
     * The table name.
     *
     * @var
     */
    protected $table = 'notes';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('author_user_id')->unsigned();

            $table->boolean('from_user_deleted')->default(false);
            $table->boolean('to_user_deleted')->default(false); 

            $table->foreign('product_id')
            ->references('id')->on('products')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('author_user_id')
            ->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->text('note');
         
            $table->integer('updated_at');
            $table->integer('created_at');
            $table->unique(array('product_id', 'user_id', 'author_user_id'));
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
