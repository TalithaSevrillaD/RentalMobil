<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use JWTAuth;
use Auth;
use App\DataModel;

class Datacontroller extends Controller
{
    public function store(Request $req)
    {
        if(Auth::user()->status=="admin"){
            $validator = Validator::make($req->all(),
            [
                'id_jenis'=>'required',
                'nama_mobil'=>'required',
                'plat'=>'required',
                'merk'=>'required',
                'keterangan'=>'required'
            ]);
            if($validator->fails()){
                return Response()->json($validator->errors());
            } else {
                $simpan = DataModel::create([
                    'id_jenis'=>$req->id_jenis,
                    'nama_mobil'=>$req->nama_mobil,
                    'plat'=>$req->plat,
                    'merk'=>$req->merk,
                    'keterangan'=>$req->keterangan
                ]);
                if($simpan)
                {
                    $status="1";
                    $message="Data Mobil berhasil ditambahkan.";
                } else {
                    $status="0";
                    $message="Data Mobil tidak berhasil ditambahkan!";
                }
                return Response()->json(compact('status','message'));
            }
        } else {
            echo "Maaf! Data mobil hanya dapat diakses oleh admin.";
        }
    }

    public function update($id, Request $req)
    {
        if(Auth::user()->status=="admin"){
            $validator = Validator::make($req->all(), [
                'id_jenis'=>'required',
                'nama_mobil'=>'required',
                'plat'=>'required',
                'merk'=>'required',
                'keterangan'=>'required'
            ]);
            if($validator->fails()){
                return Response()->json($validator->errors());
            }

            $ubah=DataModel::where('id',$id)->update([
                'id_jenis'=>$req->id_jenis,
                'nama_mobil'=>$req->nama_mobil,
                'plat'=>$req->plat,
                'merk'=>$req->merk,
                'keterangan'=>$req->keterangan
            ]);
            if($ubah){
                $status="1";
                $message="Data mobil berhasil diubah.";
            } else{
                $status="0";
                $message="Data mobil tidak berhasil diubah!";
            }
            return Response()->json(compact('status', 'message'));
        } else {
            echo "Maaf! Data mobil hanya dapat diakses oleh admin.";
        }
    }

    public function destroy($id)
    {
        if(Auth::user()->status=="admin"){
            $hapus=DataModel::where('id', $id)->delete();
            if($hapus){
                $status="1";
                $message="Data mobil berhasil dihapus.";
            } else{
                $status="0";
                $message="Data mobil tidak berhasil dihapus!";
            }
            return Response()->json(compact('status', 'message'));
        } else {
            echo "Maaf! Data mobil hanya dapat diakses oleh admin.";
        }
    }

    public function show()
    {
        if(Auth::user()->status=="admin"){
            $Data=DataModel::all();
            $status="1";

            return Response()->json(compact('Data', 'status'));
        } else {
            echo "Maaf! Data mobil hanya dapat diakses oleh admin.";
        }
    }
}
