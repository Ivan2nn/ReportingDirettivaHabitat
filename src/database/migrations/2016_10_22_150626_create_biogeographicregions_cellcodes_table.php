<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiogeographicregionCellcodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biogeographicregion_cellcode', function(Blueprint $table) {
            $table->integer('biogeographicregion_id')->unsigned();
            $table->integer('cellcode_id')->unsigned();

            $table->foreign('biogeographicregion_id')
                ->references('id')
                ->on('biogeographicregions')
                ->onDelete('cascade');
            
            $table->foreign('cellcode_id')
                ->references('id')
                ->on('cellcodes')
                ->onDelete('cascade');

            $table->primary(['biogeographicregion_id','cellcode_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('biogeographicregion_cellcode');
    }
}
