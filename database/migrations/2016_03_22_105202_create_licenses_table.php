<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLicensesTable extends Migration
{
    /**
     * The table name.
     *
     * @var
     */
    protected $table = 'licenses';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();             //user that claimed the register code
            $table->integer('reigster_code_id')->unsigned();

            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('reigster_code_id')
            ->references('id')->on('register_codes')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->timestamp('expires_at')->useCurrent();
            $table->integer('updated_at');  //last accessed at.
            $table->integer('created_at');
            $table->unique(array('user_id', 'reigster_code_id'));
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
