<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
{
    /**
     * The table name.
     *
     * @var
     */
    protected $table = 'requests';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('owner_id')->unsigned(); 
            $table->integer('amount');
            $table->integer('time_frame');
            $table->boolean('hit_limit');

            $table->foreign('owner_id')
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
