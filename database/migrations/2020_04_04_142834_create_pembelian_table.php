<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePembelianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelian', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_faktur_pembelian',100)->nullable();
            $table->unsignedInteger('id_supplier')->nullable();
            $table->unsignedInteger('id_user')->nullable();
            $table->datetime('tgl_masuk')->nullable();
            $table->float('total',14,2)->nullable();
            $table->string('flag_kirim',1)->nullable();
            $table->string('flag_terima',1)->nullable();

            $table->foreign('id_supplier')->references('id')->on('supplier')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('pembelian');
    }
}
