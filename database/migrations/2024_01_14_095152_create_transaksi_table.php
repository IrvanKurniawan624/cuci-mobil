<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_mobil');
            $table->string('layanan_jasa');
            $table->string('plat_nomor', 10);
            $table->float('total_harga');
            $table->string('payment');
            $table->integer('presentase_kas')->unsigned();
            $table->integer('presentase_pekerja')->unsigned();
            $table->integer('presentase_operasional')->unsigned();
            $table->timestamps();
            $table->unsignedBigInteger('deleted_by');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
}
