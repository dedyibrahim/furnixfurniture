<?php

namespace App\Http\Controllers;

use App\Models\Banners;
use App\Models\Beritas;
use App\Models\GambarProduks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Permintaans;
use Illuminate\Support\Facades\Validator;
use App\Models\Kategoris;
use App\Models\Produks;
use App\Models\Tamus;
use Illuminate\Support\Facades\File;
class DashboardController extends ApiController
{
    public function SimpanKategori(Request $request){

        $kategoris = DB::table('tb_kategoris')
        ->orderBy('id_kategori', 'desc')
        ->limit(1)
        ->first();

        if (isset($kategoris->id_kategori)) {
            $urutan = (int) substr($kategoris->id_kategori, 3) + 1;
        } else {
            $urutan = 1;
        }

    $id_kategori    =  "KTG" . str_pad($urutan, 4, "0", STR_PAD_LEFT);

    if($request->post('id_kategori')){
    Kategoris::where('id_kategori',$request->post('id_kategori'))->update(['nama_kategori'=>$request->post("nama_kategori")]);
    }else{
    Kategoris::create(['id_kategori'=>$id_kategori,'nama_kategori'=>$request->post("nama_kategori")]);
    }

    return $this->successResponse(NULL, "Berhasil menyimpan kategori");

    }

    public function DataKategori(){

        $query = Kategoris::get();


       $data = array();
        foreach($query as $r){
         $data[] = array(
            'id_kategori'     => $r->id_kategori,
            'nama_kategori'   => $r->nama_kategori,
            'jumlah_produk'   => Produks::where('id_kategori',$r->id_kategori)->count(),
          );
        }

        return $this->successResponse($data, "Berhasil menampilkan data kategori");

    }
    public function SimpanProduk(Request $request){
        if(!$request->post('id_produk')){

        $produks = DB::table('tb_produks')
        ->orderBy('id_produk', 'desc')
        ->limit(1)
        ->first();

        if (isset($produks->id_produk)) {
            $urutanp = (int) substr($produks->id_produk, 3) + 1;
        } else {
            $urutanp = 1;
        }

        $id_produk    =  "IDP" . str_pad($urutanp, 4, "0", STR_PAD_LEFT);
        $produks = array(
            'id_produk'   => $id_produk,
            'id_kategori'  => $request->post('kategori'),
            'nama_produk'  => $request->post('nama_produk'),
            'keterangan'   => $request->post('keterangan'),
            'harga_produk' => $request->post('harga_produk'),
           );
           Produks::insert($produks);
        }else{
          $id_produk = $request->post('id_produk');
          $produks = array(
            'id_produk'   =>  $id_produk,
            'id_kategori'  => $request->post('kategori'),
            'nama_produk'  => $request->post('nama_produk'),
            'keterangan'   => $request->post('keterangan'),
            'harga_produk' => $request->post('harga_produk'),
           );
           Produks::where('id_produk',$request->post('id_produk'))->update($produks);

       }

        if($request->hasfile('files'))
        {

           foreach($request->file('files') as $key => $file){

            $gambar = DB::table('tb_gambarproduks')
            ->orderBy('id_gambar', 'desc')
            ->limit(1)
            ->first();

            if (isset($gambar->id_gambar)) {
                $urutan = (int) substr($gambar->id_gambar, 3) + 1;
            } else {
                $urutan = 1;
            }
            $id_gambar    =  "IDG" . str_pad($urutan, 4, "0", STR_PAD_LEFT);

            $extension = $file->getClientOriginalExtension();
            $filenameSimpan = $id_gambar.'.'.$extension;
            $foto = $file;
            $foto->move('assets/imgproduk',$filenameSimpan);

            GambarProduks::insert(array(
                'id_gambar'   => $id_gambar,
                'id_produk'   => $id_produk,
                'name'        => $filenameSimpan,
            ));

         }
        }
       return $this->successResponse(NULL, "Berhasil Menambahkan Produk baru");

    }



    public function DataProduk(){

        $query = DB::table('tb_produks')
                ->leftJoin('tb_kategoris', 'tb_produks.id_kategori', '=', 'tb_kategoris.id_kategori')
                ->select('tb_produks.id_produk','tb_kategoris.id_kategori','tb_kategoris.nama_kategori','tb_produks.nama_produk','tb_produks.harga_produk','tb_produks.keterangan')
                ->orderBy('id_produk', 'desc')
                ->get();

        $data = array();

        foreach($query as $r){
        $gb = GambarProduks::where('id_produk',$r->id_produk)->get();
        $gambar = array();
        foreach($gb as $g){
            $gambar[] = array(
                 'id_gambar'=>$g->id_gambar,
                 'name'     =>$g->name
            );
        }

         $data[] = array(
            'id_produk'         => $r->id_produk,
            'id_kategori'       => $r->id_kategori,
            'nama_kategori'     => $r->nama_kategori,
            'nama_produk'       => $r->nama_produk,
            'harga_produk'      => $r->harga_produk,
            'keterangan'        => $r->keterangan,
            'gambar'            => $gambar
         );
        }

        return $this->successResponse($data, "Berhasil menampilkan data permintaan");

    }

    public function HapusGambarProduk(Request $request){
      $data  = GambarProduks::where('id_gambar',$request->id_gambar)->first();
      $image_path = public_path("assets/imgproduk/".$data->name);

      if (file_exists($image_path)) {
          unlink($image_path);
      }
      GambarProduks::where('id_gambar',$request->id_gambar)->delete();

       return $this->successResponse(NULL, "Berhasil Menghapus Gambar");
    }

    public function DeleteProduk(Request $request){

       for($i=0; $i<count($request->post('gambar')); $i++){
        $data  = $request->post('gambar');
        $image_path = public_path('assets/imgproduk/'.$data[$i]['name']);

      if (file_exists($image_path)) {
          unlink($image_path);
      }
      GambarProduks::where('id_gambar',$data[$i]['id_gambar'])->delete();

       }
       Produks::where('id_produk',$request->id_produk)->delete();

       return $this->successResponse(NULL, "Berhasil Menghapus Produk");

    }
    public function DeleteKategori(Request $request){

        $cek = Produks::where('id_kategori',$request->post('id_kategori'))->count();

        if($cek > 0 ){
            return $this->errorResponse(NULL, "Tidak dapat menghapus kategori ini",401);

        }else{

        Kategoris::where('id_kategori',$request->post('id_kategori'))->delete();
        }
        return $this->successResponse(NULL, "Berhasil menghapus kategori");

    }
    public function DataBerita(){
       $data = Beritas::get();

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
      return $this->successResponse($result, "Berhasil menampilkan berita");
    }

    public function SimpanBerita(Request $request){

        $request->validate([
            'judul'      => 'required',
            'keterangan' => 'required',
        ]);


        if(!$request->post('id_berita')){

            $berita = DB::table('tb_beritas')
            ->orderBy('id_berita', 'desc')
            ->limit(1)
            ->first();

            if (isset($berita->id_berita)) {
                $urutanp = (int) substr($berita->id_berita, 3) + 1;
            } else {
                $urutanp = 1;
            }
            $id_berita    =  "IDB" . str_pad($urutanp, 4, "0", STR_PAD_LEFT);
             $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $filenameSimpan = $id_berita.'.'.$extension;
            $foto = $file;
            $foto->move('assets/imgberita',$filenameSimpan);
            $beritas = array(
                'id_berita'   => $id_berita,
                'judul'       => $request->post('judul'),
                'keterangan'  => $request->post('keterangan'),
                'gambar'      => $filenameSimpan,
                'create'      => date('Y-m-d H:i:s'),

               );
               Beritas::insert($beritas);
            }else{
              $id_berita = $request->post('id_berita');
              $un = Beritas::where('id_berita',$request->post('id_berita'))->first();
              $image_path = public_path("assets/imgberita/".$un->gambar);

              if (file_exists($image_path)) {
                  unlink($image_path);
              }

              if($request->hasfile('file')){
              $file = $request->file('file');
              $extension = $file->getClientOriginalExtension();
              $filenameSimpan = $id_berita.'.'.$extension;
              $foto = $file;
              $foto->move('assets/imgberita',$filenameSimpan);
              $beritas = array(
                'id_berita'   => $id_berita,
                'judul'       => $request->post('judul'),
                'keterangan'  => $request->post('keterangan'),
                'gambar'      => $filenameSimpan,
                'create'      => date('Y-m-d H:i:s'),

               );
              }else{
                $beritas = array(
                    'id_berita'   => $id_berita,
                    'judul'       => $request->post('judul'),
                    'keterangan'  => $request->post('keterangan'),
                    'create'      => date('Y-m-d H:i:s'),

                   );

              }
               Beritas::where('id_berita',$request->post('id_berita'))->update($beritas);

           }

           return $this->successResponse(NULL, "Berhasil Menambahkan Produk baru");

    }

    public function DeleteBerita(Request $request){

        $image_path = public_path("assets/imgberita/".$request->post('gambar'));

        if (file_exists($image_path)) {
            unlink($image_path);
        }
        Beritas::where('id_berita',$request->id_berita)->delete();

         return $this->successResponse(NULL, "Berhasil Menghapus Berita");
      }

    public function DataTamu(Request $request){




        $data = Tamus::orderBy('id_tamu', 'desc')->get();

        $result= array();
        foreach($data as $t){
         $result[] = array(
        'id_tamu'       =>$t->id_tamu,
        'nama'          =>$t->nama,
        'email'         =>$t->email,
        'tlp'           =>$t->tlp,
        'keterangan'    =>$t->keterangan,
         );
        }

        return $this->successResponse($result, "Berhasil Menampilkan Buku Tamu");

    }
    public function DeleteTamu(Request $request){
        $data = Tamus::where('id_tamu',$request->post('id_tamu'))->delete();

        return $this->successResponse($data, "Berhasil Menghapus buku");

    }

    public function SimpanBanner(Request $request){

        $banner = DB::table('tb_banners')
            ->orderBy('id_banner', 'desc')
            ->limit(1)
            ->first();

            if (isset($banner->id_banner)) {
                $urutanp = (int) substr($banner->id_banner, 3) + 1;
            } else {
                $urutanp = 1;
            }
            $id_banner    =  "IDB" . str_pad($urutanp, 4, "0", STR_PAD_LEFT);

            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $filenameSimpan = $id_banner.'.'.$extension;
            $foto = $file;
            $foto->move('assets/imgbanner',$filenameSimpan);

            $banners = array(
                'id_banner'   => $id_banner,
                'gambar'      => $filenameSimpan,
               );
               Banners::insert($banners);


           return $this->successResponse(NULL, "Berhasil Menyimpan Banner");

    }
    public function DataBanner(){
       $d = Banners::get();
       $result = array();
       foreach($d as $r){
         $result[]= array(
             'id_banner'=>$r->id_banner,
             'gambar'   =>$r->gambar,
         );
       }
       return $this->successResponse($result, "Berhasil Mengambil Banner");

    }
    public function DeleteBanner(Request $request){

         $image_path = public_path('assets/imgbanner/'.$request->post('gambar'));

       if (file_exists($image_path)) {
           unlink($image_path);
       }
       Banners::where('id_banner',$request->post('id_banner'))->delete();
       return $this->successResponse(null, "Berhasil Menghapus Banner");

        }

}
