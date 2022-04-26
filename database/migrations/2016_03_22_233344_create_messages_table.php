<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * The table name.
     *
     * @var
     */
    protected $table = 'messages';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->integer('from_user_id')->unsigned();
            $table->integer('to_user_id')->unsigned();

            $table->boolean('from_user_deleted')->default(false);                //duration in days!?
            $table->boolean('to_user_deleted')->default(false); 

            $table->foreign('from_user_id')
            ->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('to_user_id')
            ->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('product_id')
            ->references('id')->on('groups')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->string('subject', 128);
            $table->text('body');

            $table->timestamp('read_at')->nullable();               
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
