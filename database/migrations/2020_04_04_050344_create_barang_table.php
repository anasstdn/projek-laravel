<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_barang_golongan');
            $table->string('barcode',100)->nullable();
            $table->string('nama_barang',100)->nullable();
            $table->unsignedInteger('id_satuan');
            $table->float('harga_beli',14,2)->nullable();
            $table->float('harga_jual',14,2)->nullable();
            $table->float('diskon')->nullable();
            
            $table->foreign('id_barang_golongan')->references('id')->on('barang_golongan')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_satuan')->references('id')->on('satuan')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('barang');
    }
}
