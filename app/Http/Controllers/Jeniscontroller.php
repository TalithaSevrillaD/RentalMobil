<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use JWTauth;
use App\JenisModel;

class Jeniscontroller extends Controller
{
    public function store(Request $req)
    {
        if(Auth::user()->status=="admin"){
            $validator = Validator::make($req->all(),[
                'jenis'=>'required',
                'harga_sewa'=>'required'
            ]);
            if($validator->fails()){
                return Response()->json($validator->errors());
            } else{
                $simpan = JenisModel::create([
                    'jenis'=>$req->jenis,
                    'harga_sewa'=>$req->harga_sewa
                ]);
                if($simpan)
                {
                    $status="1";
                    $message="Data Jenis Mobil berhasil ditambahkan.";
                } else {
                    $status="0";
                    $message="Data Jenis Mobil tidak berhasil ditambahkan!";
                }
                return Response()->json(compact('status', 'message'));
            }
        } else {
            echo "Maaf! Data jenis mobil hanya dapat diakses oleh admin.";
        }
    }

    public function update($id, Request $req)
    {
        if(Auth::user()->status=="admin"){
            $validator=Validator::make($req->all(), [
                'jenis'=>'required',
                'harga_sewa'=>'required'
            ]);
            if($validator->fails()){
                return Response()->json($validator->errors());
            }

            $ubah=JenisModel::where('id', $id)->update([
                'jenis'=>$req->jenis,
                'harga_sewa'=>$req->harga_sewa
            ]);
            if($ubah){
                $status="1";
                $message="Data jenis mobil berhasil diubah.";
            } else {
                $sttaus="0";
                $message="Data jenis mobil tidak berhasil diubah!";
            }
            return Response()->json(compact('status', 'message'));
        } else {
            echo "Maaf! Data jenis mobil hanya dapat diakses oleh admin.";
        }
    }

    public function destroy($id)
    {
        if(Auth::user()->status=="admin"){
            $hapus=JenisModel::where('id', $id)->delete();
            if($hapus){
                $status="1";
                $message="Data jenis mobil berhasil di hapus.";
            } else {
                $status="0";
                $message="Data jenis mobil tidak berhasil dihapus!";
            }

            return Response()->json(compact('status', 'message'));
        } else {
            echo "Maaf! Data jenis mobil hanya dapat diakses oleh admin.";
        }
    }

    public function show()
    {
        if(Auth::user()->status=="admin"){
            $jenis=JenisModel::all();
            $status="1";

            return Response()->json(compact('jenis', 'status'));
        } else {
            echo "Maaf! Data jenis mobil hanya dapat diakses oleh admin.";
        }
    }
}
