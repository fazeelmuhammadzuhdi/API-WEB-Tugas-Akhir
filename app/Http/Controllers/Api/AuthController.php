<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $validasi = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|min:3'
        ]);

        if ($validasi->fails()) {
            return $this->error($validasi->errors()->first());
        }

        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (password_verify($request->password, $user->password)) {
                return $this->success($user);
            } else {

                return $this->error("Password Salah");
            }
        }
        return $this->error("User Tidak Di Ada");
    }

    public function register(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'required|min:3'
        ]);

        if ($validasi->fails()) {
            return $this->error($validasi->errors()->first());
        }

        $user = User::create(array_merge($request->all(), [
            'password' => bcrypt($request->password)
        ]));

        if ($user) {
            return $this->success($user, 'Selamat Datang ' . $user->name);
        } else {
            return $this->error('Terjadi Kesalahan');
        }
    }

    public function success($data, $message = "success")
    {
        return response()->json([
            'code' => 200,
            'message' => $message,
            'data' => $data
        ]);
    }

    public function error($message)
    {
        return response()->json([
            'code' => 400,
            'message' => $message
        ], 400);
    }


    // public function logiin(Request $request)
    // {

    //     $validasi = Validator::make($request->all(), [
    //         'email' => 'required',
    //         'password' => 'required|min:3'
    //     ]);

    //     if ($validasi->fails()) {
    //         return $this->error($validasi->errors()->first());
    //     }

    //     $user = User::where('email', $request->email)->first();

    //     if ($user) {
    //         if (password_verify($request->password, $user->password)) {
    //             return $this->sukses($user);
    //         } else {
    //             return $this->error("Password Salah");
    //         }
    //     }

    //     return response()->json([
    //         'code' => '400',
    //         'message' => 'user Tidak Ada'
    //     ]);
    // }

    // public function registerr(Request $request)
    // {
    //     $validasi = Validator::make($request->all(), [

    //         'name' => 'required',
    //         'email' => 'required|unique:users',
    //         'phone' => 'required|unique:users',
    //         'password' => 'required|min:3'
    //     ]);
    //     if ($validasi->fails()) {
    //         return response()->json([
    //             'code' => '400',
    //             'message' => $validasi->errors()->first()
    //         ]);
    //     }

    //     $user = User::create(array_merge($request->all(), [
    //         'password' => bcrypt($request->password)
    //     ]));


    //     if ($user) {
    //         return response()->json([
    //             'code' => '200',
    //             'message' => 'Selamat Datang' . $user->name
    //         ]);
    //     } else {
    //         return response()->json([
    //             'code' => '400',
    //             'message' => 'Terjadi Kesalahan'
    //         ]);
    //     }
    // }

    // public function error($pesan)
    // {
    //     return response()->json([
    //         'code' => '400',
    //         'message' => $pesan
    //     ]);
    // }
    // public function sukses($pesan)
    // {
    //     return response()->json([
    //         'code' => '200',
    //         'message' => $pesan
    //     ]);
    // }
}
