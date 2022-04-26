<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * The table name.
     *
     * @var
     */
    protected $table = 'packages';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned(); 
            $table->string('name');
            $table->string('description')->nullable();

            $table->integer('updated_at');
            $table->integer('created_at');
            $table->unique(array('product_id', 'name'));
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
