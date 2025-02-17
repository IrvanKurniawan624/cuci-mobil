<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterPresentaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_presentase', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('presentase-kas')->unsigned();
            $table->integer('presentase-pekerja')->unsigned();
            $table->integer('presentase-operasional')->unsigned();
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
        Schema::dropIfExists('master_presentase');
    }
}
