<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailPembelianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pembelian', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_pembelian')->nullable();
            $table->unsignedInteger('id_barang')->nullable();
            $table->float('harga_beli',14,2)->nullable();
            $table->float('jumlah')->nullable();
            $table->float('sub_total',14,2)->nullable();

            $table->foreign('id_pembelian')->references('id')->on('pembelian')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_barang')->references('id')->on('barang')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('detail_pembelian');
    }
}
