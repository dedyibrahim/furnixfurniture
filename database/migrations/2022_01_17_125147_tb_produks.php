<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbProduks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("tb_produks",function(Blueprint $table){
            $table->string("id_produk",15)->primary();
            $table->foreign('id_kategori')->references('id_kategori')->on('tb_kategoris');
            $table->string("id_kategori",15);

            $table->string("nama_produk",150);
            $table->decimal("harga_produk",8,0);
            $table->text("keterangan");
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
        //
    }
}
