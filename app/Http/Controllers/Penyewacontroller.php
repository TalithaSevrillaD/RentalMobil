<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use JWTAuth;
use Auth;
use App\PenyewaModel;

class Penyewacontroller extends Controller
{
    public function store(Request $req)
    {
        if(Auth::user()->status=="admin"){
            $validator = Validator::make($req->all(),
            [
                'nama'=>'required',
                'alamat'=>'required',
                'nohp'=>'required',
                'no_ktp'=>'required',
                'foto'=>'required'
            ]);
            if($validator->fails()){
                return Response()->json($validator->errors());
            } else {
                $simpan = PenyewaModel::create([
                    'nama'=>$req->nama,
                    'alamat'=>$req->alamat,
                    'nohp'=>$req->nohp,
                    'no_ktp'=>$req->no_ktp,
                    'foto'=>$req->foto
                ]);
                if($simpan)
                {
                    $status="1";
                    $message="Data Penyewa berhasil ditambahkan.";
                } else {
                    $status="0";
                    $message="Data Penyewa tidak berhasil ditambahkan!";
                }
                return Response()->json(compact('status','message'));
            }
        } else {
            echo "Maaf! Data Penyewa hanya dapat diakses oleh admin.";
        }
    }

    public function update($id, Request $req)
    {
        if(Auth::user()->status=="admin"){
            $validator = Validator::make($req->all(), [
                'nama'=>'required',
                'alamat'=>'required',
                'nohp'=>'required',
                'no_ktp'=>'required',
                'foto'=>'required'
            ]);
            if($validator->fails()){
                return Response()->json($validator->errors());
            }

            $ubah=PenyewaModel::where('id',$id)->update([
                'nama'=>$req->nama,
                'alamat'=>$req->alamat,
                'nohp'=>$req->nohp,
                'no_ktp'=>$req->no_ktp,
                'foto'=>$req->foto
            ]);
            if($ubah){
                $status="1";
                $message="Data Penyewa berhasil diubah.";
            } else{
                $status="0";
                $message="Data Penyewa tidak berhasil diubah!";
            }
            return Response()->json(compact('status', 'message'));
        } else {
            echo "Maaf! Data Penyewa hanya dapat diakses oleh admin.";
        }
    }

    public function destroy($id)
    {
        if(Auth::user()->status=="admin"){
            $hapus=PenyewaModel::where('id', $id)->delete();
            if($hapus){
                $status="1";
                $message="Data Penyewa berhasil dihapus.";
            } else{
                $status="0";
                $message="Data Penyewa tidak berhasil dihapus!";
            }
            return Response()->json(compact('status', 'message'));
        } else {
            echo "Maaf! Data Penyewa hanya dapat diakses oleh admin.";
        }
    }

    public function show()
    {
        if(Auth::user()->status=="admin"){
            $penyewa=PenyewaModel::all();
            $status="1";

            return Response()->json(compact('penyewa', 'status'));
        } else {
            echo "Maaf! Data Penyewa hanya dapat diakses oleh admin.";
        }
    }
}
