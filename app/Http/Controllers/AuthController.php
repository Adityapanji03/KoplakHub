<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Models\Akun;
use App\Models\Produk;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function home() {
        $products = Produk::take(4)->get();
        $reviews = Review::all();
        return view('index', ['products' => $products, 'reviews' => $reviews]);
    }
    public function showLogin() {
        return view('login');
    }

    public function login(Request $request)
    {
    $credentials = $request->only('username', 'password');

    $validator = Validator::make($request->all(), [
        'username' => 'required',
        'password' => 'required|min:8',
    ], [
        'username.required' => 'Username wajib diisi.',
        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal terdiri dari 8 karakter.',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput($request->except('password'));
    } elseif (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        // Ambil data user yang berhasil login
        $user = Auth::user();
        $nama = $user->nama;
        $role = $user->id_role; // Ambil id_role pengguna

        // Simpan nama ke session flash data
        $request->session()->flash('nama_login', $nama);
        $request->session()->flash('alert_tampil', true);

        // Periksa id_role dan arahkan ke route yang sesuai
        if ($role === 1) {
            return redirect()->intended('admin/dashboard');
        } elseif ($role === 2) {
            $products = Produk::take(4)->get();
            $reviews = Review::all();
            return redirect(route('home'))->with([
                'products' => $products,
                'reviews' => $reviews
            ]);
        } else {
            return redirect()->intended('index')->with('warning', 'Peran pengguna tidak dikenali.');
        }
    } else {
        return redirect()->back()->with('error', 'Username atau password tidak terdaftar.');
    }
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}

