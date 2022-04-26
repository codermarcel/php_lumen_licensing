<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePiviotGroupPermissionTable extends Migration
{
    /**
     * The table name.
     *
     * @var
     */
    protected $table = 'group_permission';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->integer('group_id')->unsigned();
            $table->integer('product_id')->unsigned()->nullable();
            $table->integer('permission_id')->unsigned();

            $table->foreign('group_id')->references('id')->on('groups')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('permission_id')->references('id')->on('permissions')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('product_id')->references('id')->on('products')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->integer('updated_at');
            $table->integer('created_at');
            $table->primary(['group_id', 'permission_id']);
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
