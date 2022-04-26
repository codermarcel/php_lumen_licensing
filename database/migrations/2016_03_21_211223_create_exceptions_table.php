<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExceptionsTable extends Migration
{
    /**
     * The table name.
     *
     * @var
     */
    protected $table = 'exceptions';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exceptions_data_id')->unsigned();
            $table->integer('parent_exception_id')->unsigned()->nullable();
            $table->integer('product_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->foreign('exceptions_data_id')
            ->references('id')->on('exceptions_data')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('product_id')
            ->references('id')->on('products')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->boolean('is_root')->default(false);
            $table->string('name', 255);
            $table->string('source', 255);
            $table->string('message', 255);

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
