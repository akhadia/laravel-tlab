<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResepTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resep', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_kategori')->nullable();
            $table->string('nama')->nullable();
            $table->string('deskripsi')->nullable();
            $table->unsignedInteger('user_input')->nullable();
            $table->unsignedInteger('user_update')->nullable();
            $table->timestamps();
            $table->foreign('id_kategori','resep_fk_kategori')->references('id')->on('kategori');
            $table->foreign('user_update','resep_fk_user_update')->references('id')->on('users');
            $table->foreign('user_input','resep_fk_user_input')->references('id')->on('users');
        });

        Schema::create('resep_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_resep')->nullable();
            $table->unsignedInteger('id_bahan')->nullable();
            $table->unsignedInteger('id_satuan')->nullable();
            // $table->timestamps();
            $table->foreign('id_resep','resep_detail_fk_resep')->references('id')->on('resep');
            $table->foreign('id_bahan','resep_detail_fk_bahan')->references('id')->on('bahan');
            $table->foreign('id_satuan','resep_detail_fk_satuan')->references('id')->on('satuan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resep');
        Schema::dropIfExists('resep_detail');
    }
}
