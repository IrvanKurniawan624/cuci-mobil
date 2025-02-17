<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterSnackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_snack', function (Blueprint $table) {
            $table->id();
            $table->string('snack_name');
            $table->int('stock');
            $table->int('harga_beli');
            $table->int('harga_jual');
            $table->int('keuntungan')->comment('harga beli - harga jual');
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
        Schema::dropIfExists('master_snack');
    }
}
