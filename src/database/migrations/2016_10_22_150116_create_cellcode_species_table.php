<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCellcodeSpeciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cellcode_species', function(Blueprint $table) {
            $table->integer('species_code')->unsigned();
            $table->integer('cellcode_id')->unsigned();
            $table->primary(['species_code','cellcode_id']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cellcode_species');
    }
}
