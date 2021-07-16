<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxonomiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxonomies', function (Blueprint $table) {
            $table->primary('species_code');
            $table->integer('kingdome_id')->nullable();
            $table->integer('philum_id')->nullable();
            $table->integer('class_id')->nullable();
            $table->integer('order_id')->nullable();
            $table->integer('family_id')->nullable();
            $table->integer('genus_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('taxonomies');
    }
}
