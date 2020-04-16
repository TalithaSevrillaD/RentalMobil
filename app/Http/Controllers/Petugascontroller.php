<?php

namespace App\Http\Controllers;

use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Auth;
use App\User;
use DB;

class Petugascontroller extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_petugas' => 'required|string|max:255',
            'username'=>'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'status' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'nama_petugas' => $request->get('nama_petugas'),
            'username'=>$request->get('username'),
            'password' => Hash::make($request->get('password')),
            'status'=>$request->get('status')
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user','token'),201);
    }

    public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        return response()->json(compact('user'));
    }

    public function update($id, Request $req)
    {
        if(Auth::user()->status=="admin"){
            $validator = Validator::make($req->all(), [
                'nama_petugas'=>'required',
                'username'=>'required',
                'password'=>'required',
                'status'=>'required'
            ]);

            if($validator->fails()){
                return Response()->json($validator->errors());
            }

            $ubah = User::where('id', $id)->update([
                'nama_petugas' => $req->get('nama_petugas'),
                'username'=>$req->get('username'),
                'password' =>Hash::make($req->get('password')),
                'status'=>$req->get('status')
            ]);
            if($ubah){
                $status = "1";
                $message = "Data Petugas berhasil diubah.";
            } else {
                $status = "0";
                $message = "Data Petugas tidak berhasil diubah!";
            }
            return Response()->json(compact('status', 'message'));
        } else {
            echo "Maaf! Data Petugas hanya dapat diakses oleh admin.";
        }
    }

    public function destroy($id)
    {
        if(Auth::user()->status=="admin") {
            $hapus = User::where('id', $id)->delete();
            if($hapus){
                $status = "1";
                $message = "Data Petugas berhasil dihapus.";
            } else {
                $status = "0";
                $message = "Data Petugas tidak berhasil dihapus!";
            }
            return Response()->json(compact('status', 'message'));
        } else {
            echo "Maaf! Data Petugas hanya dapat diakses oleh admin.";
        }
    }

    public function show()
    {
        if(Auth::user()->status=="admin"){
            $petugas = User::all();
            $status="1";

            return Response()->json(compact('status', 'petugas'));
        } else {
            echo "Maaf! Data Petugas hanya dapat diakses oleh admin.";
        }
    }
}
