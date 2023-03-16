<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use SebastianBergmann\FileIterator\Factory;
use App\Models\User;
use App\Models\Barangs;
use App\Models\karyawans;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            'name' => "Administrator",
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin@123'),
        ]);

        $data = array(
            array('id_kategori'=>'KTG0001','nama_kategori'=>'Kursi Kantor'),
            array('id_kategori'=>'KTG0002','nama_kategori'=>'Meja Kantor Eksekutif'),
            array('id_kategori'=>'KTG0003','nama_kategori'=>'Meja Kantor Meeting'),
            array('id_kategori'=>'KTG0004','nama_kategori'=>'Meja Kantor Staff'),
            array('id_kategori'=>'KTG0005','nama_kategori'=>'Partisi Kantor'),
            array('id_kategori'=>'KTG0006','nama_kategori'=>'Perlengkapan Kantor'),
        );

        DB::table('tb_kategoris')->insert($data);

        $tb_produks = array(
            array('id_produk' => 'IDP0001','id_kategori' => 'KTG0001','nama_produk' => 'Kursi Direktur Arruga','harga_produk' => '0','keterangan' => '-','created_at' => NULL,'updated_at' => NULL),
            array('id_produk' => 'IDP0002','id_kategori' => 'KTG0001','nama_produk' => 'Kursi Direktur Tipe AD - 91','harga_produk' => '0','keterangan' => '-','created_at' => NULL,'updated_at' => NULL),
            array('id_produk' => 'IDP0003','id_kategori' => 'KTG0001','nama_produk' => 'Kursi Manager Tipe AD - 90','harga_produk' => '0','keterangan' => '-','created_at' => NULL,'updated_at' => NULL),
            array('id_produk' => 'IDP0004','id_kategori' => 'KTG0001','nama_produk' => 'Kursi Victory 55','harga_produk' => '0','keterangan' => '-','created_at' => NULL,'updated_at' => NULL),
            array('id_produk' => 'IDP0005','id_kategori' => 'KTG0006','nama_produk' => 'Perlengkapan Kantor - 892b_2','harga_produk' => '0','keterangan' => '-','created_at' => NULL,'updated_at' => NULL),
            array('id_produk' => 'IDP0006','id_kategori' => 'KTG0006','nama_produk' => 'Perlengkapan Kantor - pcl spo 1275c_1','harga_produk' => '0','keterangan' => '-','created_at' => NULL,'updated_at' => NULL),
            array('id_produk' => 'IDP0007','id_kategori' => 'KTG0006','nama_produk' => 'Sofa Tamu 1 Seater, 2 Seater dan 3 Seater','harga_produk' => '0','keterangan' => '-','created_at' => NULL,'updated_at' => NULL),
            array('id_produk' => 'IDP0008','id_kategori' => 'KTG0006','nama_produk' => 'Credenza 4 Pintu','harga_produk' => '0','keterangan' => '-','created_at' => NULL,'updated_at' => NULL),
            array('id_produk' => 'IDP0009','id_kategori' => 'KTG0005','nama_produk' => 'Workstation Konfigurasi 6 staff','harga_produk' => '0','keterangan' => '-','created_at' => NULL,'updated_at' => NULL),
            array('id_produk' => 'IDP0010','id_kategori' => 'KTG0005','nama_produk' => 'Workstation Sekat Minimalis Kaki Hollow','harga_produk' => '0','keterangan' => '-','created_at' => NULL,'updated_at' => '2022-01-24 14:24:28'),
            array('id_produk' => 'IDP0011','id_kategori' => 'KTG0001','nama_produk' => 'Kursi Mesh C30','harga_produk' => '3000000','keterangan' => 'Kursi Mesh C30','created_at' => NULL,'updated_at' => '2022-01-24 14:23:43'),
            array('id_produk' => 'IDP0012','id_kategori' => 'KTG0003','nama_produk' => 'Meja Meeting Kantor 14 Seat','harga_produk' => '10000000','keterangan' => 'Meja Meeting Kantor 14','created_at' => NULL,'updated_at' => '2022-01-24 14:23:32'),
            array('id_produk' => 'IDP0013','id_kategori' => 'KTG0003','nama_produk' => 'Meja Meeting Kantor 14 Seat','harga_produk' => '10000000','keterangan' => 'Meja Meeting Kantor 14','created_at' => NULL,'updated_at' => '2022-01-24 14:46:22')
          );

          DB::table('tb_produks')->insert($tb_produks);
    }
}
