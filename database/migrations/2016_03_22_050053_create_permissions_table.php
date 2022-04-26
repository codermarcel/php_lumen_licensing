<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * The table name.
     *
     * @var
     */
    protected $table = 'permissions';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('isGlobal')->default(false);
            $table->string('name');
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->integer('updated_at');
            $table->integer('created_at');
            $table->unique(array('isGlobal', 'name'));
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
