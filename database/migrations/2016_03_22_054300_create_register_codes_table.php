<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegisterCodesTable extends Migration
{
    /**
     * The table name.
     *
     * @var
     */
    protected $table = 'register_codes';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();     //User that created the code
            $table->integer('product_id')->unsigned();
            $table->string('code', 40)->unique();
            $table->integer('duration');                //duration in days!?
            $table->string('notes'); 

            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('product_id')
            ->references('id')->on('groups')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->timestamp('expires_at');
            $table->integer('updated_at');
            $table->integer('created_at');
            $table->unique(array('user_id', 'product_id'));
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
