<?php

namespace App\Http\Controllers\Api;

use App\Helpers\JsonFormatter;
use App\Http\Controllers\Controller;
use App\Models\Produk;
use Exception;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    // mendapatkan list dari produk
    public function produk(){
        $data = Produk::all();

        if($data){
            return JsonFormatter::JsonFormat(200, "Berhasil mendapatkan data", sizeof($data), $data);
        }else{
            return JsonFormatter::JsonFormat(400, "Gagal mendapatkan data produk");
        }
    }

    // cretae new produk
    public function storeProduk(Request $request){
        try{
            $request->validate([
                'nama' => 'required|string',
                'tahun_keluar' => 'required',
                'harga' => 'required',
                'rating' => 'required',
                'suka' => 'required',
            ]);

            $produk = Produk::create([
                'nama' => $request->nama,
                'tahun_keluar' => $request->tahun_keluar,
                'harga' => $request->harga,
                'rating' => $request->rating,
                'suka' => $request->suka
            ]);

            $data = Produk::where('id', $produk->id)->get();

            if($data){
                return JsonFormatter::JsonFormat(200, "Berhasil menambahkan data", sizeof($data), $data);
            }
        }catch(Exception $err){
            return JsonFormatter::JsonFormat(400, "Gagal menambahkan data");
        }
    }

    // update a produk
    public function updateProduk(Request $request, $produk_id){
        try{
            $request->validate([
                'nama' => 'required',
                'tahun_keluar' => 'required',
                'harga' => 'required',
                'rating' => 'required',
                'suka' => 'required'
            ]);

            $produk = Produk::where('id', $produk_id)->update([
                'nama' => $request->nama,
                'tahun_keluar' => $request->tahun_keluar,
                'harga' => $request->harga,
                'rating' => $request->rating,
                'suka' => $request->suka
            ]);

            $data = Produk::where('id', $produk_id)->get();
            if($produk){
                return JsonFormatter::JsonFormat(200, "Berhasil update data", sizeof($data), $data);
            }

        }catch(Exception $err){
            return JsonFormatter::JsonFormat(400, "Gagal Update data");
        }
    }

    // delete a produk
    public function deleteProduk($produk_id){
        try{
            $data = Produk::where('id', $produk_id)->get();
            $produk = Produk::where('id', $produk_id)->delete();

            if($produk){
                return JsonFormatter::JsonFormat(200, "berhasil delete data", sizeof($data), $data);
            }
        }catch(Exception $err){
            return JsonFormatter::JsonFormat(400, "Gagal menghapus data");
        }
    }
}
