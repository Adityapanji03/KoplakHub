<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Akun;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function submit(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:akuns,email',
            'password' => 'required|min:8',
            'confirmPassword' => 'required|same:password',
            'nama' => 'required|string|max:255',
            'username' => 'required|string|unique:akuns,username',
            'provinsi' => 'required|string',
            'kabupatenKota' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'detailAlamat' => 'required|string',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',

            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',

            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',

            'confirmPassword.required' => 'Konfirmasi password wajib diisi.',
            'confirmPassword.same' => 'Konfirmasi password tidak cocok dengan password.',

            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama maksimal 255 karakter.',

            'provinsi.required' => 'Provinsi wajib dipilih.',
            'kabupatenKota.required' => 'Kabupaten/Kota wajib dipilih.',
            'kecamatan.required' => 'Kecamatan wajib dipilih.',
            'kelurahan.required' => 'Kelurahan wajib dipilih.',
            'detailAlamat.required' => 'Detail alamat wajib diisi.',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $user = new Akun();
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->nama = $request->nama;
            $user->username = $request->username;
            $user->provinsi = $request->provinsi;
            $user->kabupaten_kota = $request->kabupatenKota;
            $user->kecamatan = $request->kecamatan;
            $user->kelurahan = $request->kelurahan;
            $user->detail_alamat = $request->detailAlamat;

            if ($user->save()) {
                return redirect()->route('login')->with('success', 'Registrasi berhasil!');
            } else {
                return redirect()->back()->with('error', 'Data gagal disimpan.')->withInput();
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

}

}
