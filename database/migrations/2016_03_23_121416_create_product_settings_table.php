<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSettingsTable extends Migration
{
    /**
     * The table name.
     *
     * @var
     */
    protected $table = 'product_settings';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->string('name', 30);
            $table->text('value', 1024);
                       
            $table->foreign('product_id')
            ->references('id')->on('products')
            ->onUpdate('cascade')->onDelete('cascade');    

            $table->timestamp('accessed_at')->useCurrent();
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
