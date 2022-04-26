<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * The table name.
     *
     * @var
     */
    protected $table = 'products';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id')->unsigned()->nullable();           //Has to be nullable for reference purpose.
            $table->integer('user_id')->unsigned();
            $table->string('name', 32);
            $table->string('description')->nullable();
            
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->integer('updated_at');
            $table->integer('created_at');
            $table->unique(array('user_id', 'name'));
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
