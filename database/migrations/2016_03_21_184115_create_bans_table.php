<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBansTable extends Migration
{
    /**
     * The table name.
     *
     * @var
     */
    protected $table = 'bans';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');

            $table->integer('product_id')->unsigned();
            $table->integer('user_id')->unsigned();                     //user that got banned
            // $table->integer('issuer_id')->unsigned();                   //user that issued the ban

            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');

            // $table->foreign('issuer_id')
            // ->references('id')->on('users')
            // ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('product_id')
            ->references('id')->on('products')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->string('reason', 255);
            
            $table->integer('updated_at');
            $table->integer('created_at');
            $table->integer('expires_at');
            $table->unique(array('product_id', 'user_id'));
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
