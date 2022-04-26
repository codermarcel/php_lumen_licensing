<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * The table name.
     *
     * @var
     */
    protected $table = 'roles';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();        //user that has this group assigned, NOT THE CREATOR/OWNER
            $table->integer('group_id')->unsigned();

            $table->foreign('group_id')
            ->references('id')->on('groups')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->integer('updated_at');
            $table->integer('created_at');
            $table->unique(array('user_id', 'group_id'));
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
