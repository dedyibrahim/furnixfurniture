<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GambarProduks;
use Illuminate\Support\Facades\DB;
use App\Models\Beritas;
use App\Models\Tamus;

class UserController extends ApiController
{
    public function HomeDataProduk(){

        $query = DB::table('tb_kategoris')
                ->select('tb_kategoris.id_kategori','tb_kategoris.nama_kategori')
                ->orderByDesc("tb_kategoris.id_kategori")
                ->get();

        $data = array();

        foreach($query as $r){

       $dt = DB::table("tb_produks")
            ->leftJoin('tb_gambarproduks', 'tb_produks.id_produk', '=', 'tb_gambarproduks.id_produk')
            ->select('tb_produks.id_produk','tb_gambarproduks.name','tb_produks.nama_produk','tb_produks.harga_produk','tb_produks.keterangan')
            ->where('tb_produks.id_kategori',$r->id_kategori)
            ->groupBy('tb_produks.id_produk')
            ->orderBy('tb_produks.id_produk',"Desc")
            ->get();

            $detail = array();
            foreach($dt as  $r2){
                $detail[] = array(
                    'id_produk'         => $r2->id_produk,
                    'nama_produk'       => $r2->nama_produk,
                    'harga_produk'      => $r2->harga_produk,
                    'keterangan'        => $r2->keterangan,
                    'gambar'            => $r2->name

                 );
            }

         $data[] = array(
            'id_kategori'       => $r->id_kategori,
            'nama_kategori'     => $r->nama_kategori,
            'detail'            => $detail
         );
        }

        return $this->successResponse($data, "Berhasil menampilkan data produk");

    }

    public function HomeDataProdukWhere(Request $request){

        if($request->post('nama_kategori')){
            $dt = DB::table("tb_produks")
            ->leftJoin('tb_kategoris', 'tb_produks.id_kategori', '=', 'tb_kategoris.id_kategori')
            ->leftJoin('tb_gambarproduks', 'tb_produks.id_produk', '=', 'tb_gambarproduks.id_produk')
            ->select('tb_produks.id_produk','tb_gambarproduks.name','tb_produks.nama_produk','tb_produks.harga_produk','tb_produks.keterangan')
            ->where('tb_kategoris.nama_kategori',$request->post('nama_kategori'))
            ->limit($request->post('limit'))
            ->groupBy('tb_produks.id_produk')
            ->orderBy('tb_produks.id_produk','desc')
            ->get();

            $count = DB::table("tb_produks")
            ->leftJoin('tb_kategoris', 'tb_produks.id_kategori', '=', 'tb_kategoris.id_kategori')
            ->where('tb_kategoris.nama_kategori',$request->post('nama_kategori'))
            ->count();

        }else{
            $dt = DB::table("tb_produks")
            ->leftJoin('tb_kategoris', 'tb_produks.id_kategori', '=', 'tb_kategoris.id_kategori')
            ->leftJoin('tb_gambarproduks', 'tb_produks.id_produk', '=', 'tb_gambarproduks.id_produk')
            ->select('tb_produks.id_produk','tb_gambarproduks.name','tb_produks.nama_produk','tb_produks.harga_produk','tb_produks.keterangan')
            ->limit($request->post('limit'))
            ->orderBy('tb_produks.id_produk','desc')
            ->groupBy('tb_produks.id_produk')
            ->get();
            $count = DB::table("tb_produks")
            ->count();

        }
            $detail = array();
            foreach($dt as  $r2){
                $detail[] = array(
                    'id_produk'         => $r2->id_produk,
                    'nama_produk'       => $r2->nama_produk,
                    'harga_produk'      => $r2->harga_produk,
                    'keterangan'        => $r2->keterangan,
                    'gambar'            => $r2->name,
                    'batas'             => $count
                 );
            }

            if($request->post('limit') >  $count){
                $state = "Selesai";
            }else{
                $state = "Lanjut";
            }

           $status = array(
            'detail' => $detail,
            'status' => $state,
            'batas'  => $count,
           );

        return $this->successResponse($status, "Berhasil menampilkan data produk");

    }

    public function DetailProduct(Request $request){


            $dt = DB::table("tb_produks")
            ->leftJoin('tb_kategoris', 'tb_produks.id_kategori', '=', 'tb_kategoris.id_kategori')
            ->leftJoin('tb_gambarproduks', 'tb_produks.id_produk', '=', 'tb_gambarproduks.id_produk')
            ->select('tb_produks.id_produk','tb_gambarproduks.name','tb_produks.nama_produk','tb_produks.harga_produk','tb_produks.keterangan')
            ->where('nama_produk',$request->post('nama_produk'))
            ->groupBy('tb_produks.id_produk')
            ->limit(1)
            ->get();


            $detail = array();
            foreach($dt as  $r2){
                $gb = GambarProduks::where('id_produk',$r2->id_produk)->get();
                $gambar = array();

                foreach($gb as $g){
                    $gambar[] = array(
                         'id_gambar'=>$g->id_gambar,
                         'name'     =>$g->name
                    );
                }

                $detail[] = array(
                    'id_produk'         => $r2->id_produk,
                    'nama_produk'       => $r2->nama_produk,
                    'harga_produk'      => $r2->harga_produk,
                    'keterangan'        => $r2->keterangan,
                    'gambar'            => $gambar

                 );
            }

        return $this->successResponse($detail, "Berhasil menampilkan detail produk");

    }
    public function Pencarian(Request $request){
        $dt = DB::table("tb_produks")
            ->leftJoin('tb_kategoris', 'tb_produks.id_kategori', '=', 'tb_kategoris.id_kategori')
            ->leftJoin('tb_gambarproduks', 'tb_produks.id_produk', '=', 'tb_gambarproduks.id_produk')
            ->select('tb_produks.id_produk','tb_gambarproduks.name','tb_produks.nama_produk','tb_produks.harga_produk','tb_produks.keterangan')
            ->where('tb_produks.nama_produk','like', '%'.$request->post('kata_kunci').'%')
            ->groupBy('tb_produks.id_produk')
            ->get();


          $detail = array();
            foreach($dt as  $r2){
                $detail[] = array(
                    'id_produk'         => $r2->id_produk,
                    'nama_produk'       => $r2->nama_produk,
                    'harga_produk'      => $r2->harga_produk,
                    'keterangan'        => $r2->keterangan,
                    'gambar'            => $r2->name

                 );
            }

        return $this->successResponse($detail, "Berhasil menampilkan data produk");

    }

    public function DataBerita(Request $request){
        $data = Beritas::limit($request->post('limit'))->orderBy('id_berita','desc')->get();
        $count = Beritas::count();

        $result= array();
        foreach($data as $d){
          $result[] = array(
              'id_berita'    =>$d->id_berita,
              'judul'        =>$d->judul,
              'keterangan'   =>$d->keterangan,
              'gambar'       =>$d->gambar,
              'create'       =>$d->create,
          );
        }
        if($request->post('limit') >= $count){
            $state = "Selesai";
        }else{
            $state = "Lanjut";
        }
        $status = array(
            'detail' => $result,
            'status' => $state,
            'batas'  => $count,
           );

       return $this->successResponse($status, "Berhasil menampilkan berita");
     }

     public function SimpanTamu(Request $request){
        $request->validate([
            'nama'      =>['required'],
            'email'     =>['required'],
            'tlp'       =>['required'],
            'keterangan'=>['required'],
           ]);

        $tamus = DB::table('tb_tamus')
        ->orderBy('id_tamu', 'desc')
        ->limit(1)
        ->first();

        if (isset($tamus->id_tamu)) {
            $urutanp = (int) substr($tamus->id_tamu, 3) + 1;
        } else {
            $urutanp = 1;
        }

        $id_tamu   =  "IDT" . str_pad($urutanp, 4, "0", STR_PAD_LEFT);

      $data = array(
          'id_tamu'     =>$id_tamu,
          'nama'        =>$request->post('nama'),
          'email'       =>$request->post('email'),
          'tlp'         =>$request->post('tlp'),
          'keterangan'  =>$request->post('keterangan'),
      );
      Tamus::create($data);
      return $this->successResponse(NULL, "Berhasil menyimpan");
    }
    public function DetailBerita(Request $request){
        $data = Beritas::where('judul',$request->post('nama_berita'))->limit(1)->get();

        foreach($data as $d){
          $result = array(
              'id_berita'    =>$d->id_berita,
              'judul'        =>$d->judul,
              'keterangan'   =>$d->keterangan,
              'gambar'       =>$d->gambar,
              'create'       =>$d->create,
          );


        }
       return $this->successResponse($result, "Berhasil menampilkan berita");
     }

     }

