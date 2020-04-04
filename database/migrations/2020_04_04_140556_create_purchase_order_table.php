<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_order',100)->nullable();
            $table->string('nama_supplier',100)->nullable();
            $table->datetime('tgl_order')->nullable();
            $table->unsignedInteger('id_supplier')->nullable();
            $table->unsignedInteger('id_barang')->nullable();
            $table->unsignedInteger('id_user')->nullable();
            $table->float('jumlah')->nullable();
            $table->string('flag_purchase',1)->nullable();

            $table->foreign('id_supplier')->references('id')->on('supplier')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_barang')->references('id')->on('barang')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('purchase_order');
    }
}
