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
        $validator = Validator::make($request->all(), [
            'nomor_hp' => 'required|string|min:10|unique:akun,nomor_hp|regex:/^[0-9]+$/',
            'password' => 'required|min:8',
            'confirmPassword' => 'required|same:password',
            'nama' => 'required|string|regex:/^[a-zA-Z\s]+$/|max:255',
            'username' => 'required|string|unique:akun,username',
            'provinsi' => 'required|string',
            'kabupatenKota' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'detailAlamat' => 'required|string',
        ], [
            'nomor_hp.required' => 'Nomor HP wajib diisi.',
            'nomor_hp.unique' => 'Nomor HP sudah terdaftar.',
            'nomor_hp.min' => 'Nomor HP minimal 10 digit.',
            'nomor_hp.regex' => 'Format Nomor HP tidak valid (hanya angka).',

            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',

            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',

            'confirmPassword.required' => 'Konfirmasi password wajib diisi.',
            'confirmPassword.same' => 'Konfirmasi password tidak cocok dengan password.',

            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama maksimal 255 karakter.',
            'nama.regex' => 'Nama hanya berisi huruf',

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
            $idPelanggan = \App\Models\Role::where('nama_role', 'pelanggan')->value('id');

            $user = new Akun();
            $user->nomor_hp = $request->nomor_hp;
            $user->password = Hash::make($request->password);
            $user->nama = $request->nama;
            $user->username = $request->username;
            $user->provinsi = $request->provinsi;
            $user->kabupaten_kota = $request->kabupatenKota;
            $user->kecamatan = $request->kecamatan;
            $user->kelurahan = $request->kelurahan;
            $user->detail_alamat = $request->detailAlamat;
            $user->id_role = $idPelanggan;

            if ($user->save()) {
                return redirect()->back()->with('success_swal', 'Selamat Akun berhasil dibuat.');
            } else {
                return redirect()->back()->with('error');
            }

        } catch (\Exception $e) {
            \Log::error('Registrasi Gagal: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat registrasi. Silakan coba lagi.')->withInput();
        }
    }
}
