<?php

namespace App\Http\Controllers\Api;

use App\Helpers\JsonFormatter;
use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use Exception;
use Illuminate\Http\Request;
use PHPUnit\Util\Json;

class PembelianController extends Controller
{
    // pengamblian data pembelian
    public function pembelian(){
        $data = Pembelian::all();
        if($data){
            return JsonFormatter::JsonFormat(200, "Berhasil ambil data pembelian", sizeof($data), $data);
        }else{
            return JsonFormatter::JsonFormat(400, "Gagal ambil data pembelian");

        }
    }

    // store new data pembelian
    public function storePembelian(Request $request){
        try{
            $request->validate(
                [
                    // "user_id" => 'required',
                    "produk_id" => 'required',
                    "kota_tujuan" => 'required',
                    "kurir" => 'required',
                    "harga_pengiriman" => 'required',
                    "harga_total" => 'required',
                    "status" => 'required',
                ]
                );

            $pembelian = Pembelian::create([
                'user_id' => $request->user_id,
                'produk_id' => $request->produk_id,
                'kota_tujuan' => $request->kota_tujuan,
                'kurir' => $request->kurir,
                'harga_pengiriman' => $request->harga_pengiriman,
                'harga_total' => $request->harga_total,
                'status' => $request->status,
            ]);

            $data = Pembelian::where('id', $pembelian->id)->get();
            if($data){
                return JsonFormatter::JsonFormat(200, "Berhasil store data pembelian baru", sizeof($data), $data);
            }
        }catch(Exception $err){
            return JsonFormatter::JsonFormat(400, "Gagal store data pembelian baru");
        }
    }

    // update data pembelian
    public function updatePembelian(Request $request, $pembelian_id){
        try{
            $request->validate([
                // "user_id" => 'required',
                    "produk_id" => 'required',
                    "kota_tujuan" => 'required',
                    "kurir" => 'required',
                    "harga_pengiriman" => 'required',
                    "harga_total" => 'required',
                    "status" => 'required'
            ]);

            $pembelian = Pembelian::where('id', $pembelian_id)->update([
                'user_id' => $request->user_id,
                'produk_id' => $request->produk_id,
                'kota_tujuan' => $request->kota_tujuan,
                'kurir' => $request->kurir,
                'harga_pengiriman' => $request->harga_pengiriman,
                'harga_total' => $request->harga_total,
                'status' => $request->status,
            ]);

            $data = Pembelian::where('id', $pembelian_id)->get();

            if($pembelian){
                return JsonFormatter::JsonFormat(200, "Berhasil update data pembelian", sizeof($data), $data);
            }
        }catch(Exception $err){
            return JsonFormatter::JsonFormat(400, "Gagal update data pembelian");
        }
    }

    // delete pembelian
    public function deletePembelian(Request $request){
        try{
            $request->validate([
                'pembelian_id' => 'required'
            ]);

            $pembelian = Pembelian::where('id', $request->pembelian_id)->delete();
            if($pembelian){
                return JsonFormatter::JsonFormat(200, "Berhasil delete data pembelian");
            }
        }catch(Exception $err){
            return JsonFormatter::JsonFormat(400, "Gagal delete data Pembelian");
        }
    }

    // provinsi
    public function provinsi(){
        $data = file_get_contents("https://api.rajaongkir.com/starter/province?key=26b77b5ca89c2dbd2b5de7c1b57acd33");

        $provinsi = json_decode($data, true);
        $provinsi = $provinsi["rajaongkir"]["results"];
        return JsonFormatter::JsonFormat(200, "Berhasil mendapatkan data provinsi", sizeof($provinsi), $provinsi);
    }

    // kota
    public function kota($provinsi_id){
        $data = file_get_contents("https://api.rajaongkir.com/starter/city?key=26b77b5ca89c2dbd2b5de7c1b57acd33&province=".$provinsi_id);

        $kota = json_decode($data, true);
        $kota = $kota["rajaongkir"]["results"];
        return JsonFormatter::JsonFormat(200, "Berhasil mendapatkan data kota", sizeof($kota), $kota);

    }
    // 278
    // harga
    public function harga($tujuan, $berat, $kurir){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "origin=501&destination=114&weight=1700&courier=jne",
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded",
            "key: 26b77b5ca89c2dbd2b5de7c1b57acd33"
        ),
        ));

        $data = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $cost = json_decode($data, true);
        $cost = $cost["rajaongkir"]["results"];

        return JsonFormatter::JsonFormat(200, "berhasil mendapatkan harga", sizeof($cost), $cost);
    }


}
