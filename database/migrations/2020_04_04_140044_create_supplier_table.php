<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_supplier',100)->nullable();
            $table->text('alamat_supplier')->nullable();
            $table->string('kota',100)->nullable();
            $table->unsignedInteger('id_provinsi');
            $table->string('no_telp',100)->nullable();
            $table->string('no_fax',100)->nullable();
            $table->string('cp_nama',100)->nullable();
            $table->string('cp_telp',100)->nullable();

            $table->foreign('id_provinsi')->references('id')->on('provinsi')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('supplier');
    }
}
