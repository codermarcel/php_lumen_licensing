<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * The table name.
     *
     * @var
     */
    protected $table = 'users';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');                               //Has to be nullable for reference purpose.
            $table->integer('owner_id')->unsigned()->nullable();
            $table->string('username');
            $table->string('email');
            $table->string('password', 64);                 //sha256 hash length
            $table->string('salt')->nullable();             //legacy support (^.^)

            $table->foreign('owner_id')
            ->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');
            
            $table->integer('credits')->default(0);            
            $table->boolean('email_confirmed')->default(false);

            $table->integer('updated_at');
            $table->integer('created_at');
            $table->unique(array('owner_id', 'username'));
            $table->unique(array('owner_id', 'email'));
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
