<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Gambarproduks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create("tb_gambarproduks",function(Blueprint $table){
            $table->string("id_gambar",15)->primary();
            $table->string("id_produk");
            $table->foreign('id_produk')->references('id_produk')->on('tb_produks');
            $table->string("name",70);

         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
