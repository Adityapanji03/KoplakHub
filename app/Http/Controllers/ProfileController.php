<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Transaksi;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert; // Import SweetAlert

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }
    public function showAdmin()
    {
        $user = Auth::user();
        $totalProducts = Produk::count();
        $totalTransaksi = Transaksi::where('status_pembayaran', 'success')->count();
        return view('profileAdmin.show', compact('user','totalTransaksi', 'totalProducts'));
    }

    public function editAdmin()
    {
        $user = Auth::user();
        return view('profileAdmin.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $passwordChanged = false;

        // Validasi profil
        $validator = \Validator::make($request->all(), [
            'nama' => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('akun')->ignore($user->id)],
            'nomor_hp' => ['required', 'string', 'regex:/^[0-9]+$/', 'min:10', 'max:20', Rule::unique('akun')->ignore($user->id)],
            'provinsi' => ['nullable', 'string', 'max:255'],
            'kabupaten_kota' => ['nullable', 'string', 'max:255'],
            'kecamatan' => ['nullable', 'string', 'max:255'],
            'kelurahan' => ['nullable', 'string', 'max:255'],
            'detail_alamat' => ['nullable', 'string'],
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
            'nama.regex' => 'Nama hanya boleh berisi huruf.',

            'provinsi.required' => 'Provinsi wajib dipilih.',
            'kabupatenKota.required' => 'Kabupaten/Kota wajib dipilih.',
            'kecamatan.required' => 'Kecamatan wajib dipilih.',
            'kelurahan.required' => 'Kelurahan wajib dipilih.',
            'detailAlamat.required' => 'Detail alamat wajib diisi.',
        ]);


        if ($validator->fails()) {
            $errorMessages = implode('<br>', $validator->errors()->all());
            session()->flash('error_swal', $errorMessages);
            return redirect()->back()->withErrors($validator)->withInput();

        }

        // Update profil
        $user->update($request->only([
            'nama', 'username', 'nomor_hp', 'provinsi',
            'kabupaten_kota', 'kecamatan', 'kelurahan', 'detail_alamat',
        ]));

        // Kalau ada input password
        if ($request->filled('current_password') || $request->filled('password')) {
            $request->validate([
                'current_password' => ['required', 'string'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            // Cek password lama cocok
            if (!Hash::check($request->current_password, $user->password)) {
                session()->flash('error_swal', 'Password saat ini tidak cocok.');
                return back()->withErrors(['current_password' => 'Password saat ini tidak cocok.'])->withInput();
            }

            // Update password
            $user->update([
                'password' => Hash::make($request->password),
            ]);

            $passwordChanged = true;
        }

        $message = $passwordChanged ? 'Data dan password berhasil diperbarui!' : 'Data akun anda berhasil diperbarui!';
        return redirect()->back()->with('success_once', $message);

    }
    public function updateAdmin(Request $request)
    {
        $user = Auth::user();
        $passwordChanged = false;

        // Validasi profil
        $validator = \Validator::make($request->all(), [
            'nama' => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('akun')->ignore($user->id)],
            'nomor_hp' => ['required', 'string', 'regex:/^[0-9]+$/', 'min:10', 'max:20', Rule::unique('akun')->ignore($user->id)],
            'provinsi' => ['nullable', 'string', 'max:255'],
            'kabupaten_kota' => ['nullable', 'string', 'max:255'],
            'kecamatan' => ['nullable', 'string', 'max:255'],
            'kelurahan' => ['nullable', 'string', 'max:255'],
            'detail_alamat' => ['nullable', 'string'],
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
            'nama.regex' => 'Nama hanya boleh berisi huruf.',

            'provinsi.required' => 'Provinsi wajib dipilih.',
            'kabupatenKota.required' => 'Kabupaten/Kota wajib dipilih.',
            'kecamatan.required' => 'Kecamatan wajib dipilih.',
            'kelurahan.required' => 'Kelurahan wajib dipilih.',
            'detailAlamat.required' => 'Detail alamat wajib diisi.',
        ]);


        if ($validator->fails()) {
            $errorMessages = implode('<br>', $validator->errors()->all());
            session()->flash('error_swal', $errorMessages);
            return redirect()->back()->withErrors($validator)->withInput();

        }

        // Update profil
        $user->update($request->only([
            'nama', 'username', 'nomor_hp', 'provinsi',
            'kabupaten_kota', 'kecamatan', 'kelurahan', 'detail_alamat',
        ]));

        // Kalau ada input password
        if ($request->filled('current_password') || $request->filled('password')) {
            $request->validate([
                'current_password' => ['required', 'string'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            // Cek password lama cocok
            if (!Hash::check($request->current_password, $user->password)) {
                session()->flash('error_swal', 'Password saat ini tidak cocok.');
                return back()->withErrors(['current_password' => 'Password saat ini tidak cocok.'])->withInput();
            }

            // Update password
            $user->update([
                'password' => Hash::make($request->password),
            ]);

            $passwordChanged = true;
        }

        $message = $passwordChanged ? 'Data dan password berhasil diperbarui!' : 'Data akun anda berhasil diperbarui!';
        return redirect()->back()->with('success_once', $message);
    }
}

