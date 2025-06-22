<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\RajaOngkirController;

Route::get('/storage-link', function () {
    $targetFolder = storage_path('app/public');
    $linkFolder = public_path('storage');

    try {
        if (File::exists($linkFolder)) {
            File::delete($linkFolder);
        }

        if (!File::exists($targetFolder)) {
            File::makeDirectory($targetFolder, 0755, true);
        }

        // Buat symlink
        File::link($targetFolder, $linkFolder);

        return 'Symlink ke storage berhasil dibuat! Akses: ' . url('/storage');
    } catch (\Exception $e) {
        return 'Gagal membuat symlink storage: ' . $e->getMessage();
    }
});

Route::post('/midtrans/callback', [MidtransController::class, 'callback']);
// route menu
// Route::get('/', function () {
//     return view('index');
// });
Route::get('/', [AuthController::class, 'home']);


Route::middleware(['guest'])->group(function () {

    Route::get('/regis', function () {
        return view('regis');
    })->name('regis');

    Route::post('/register', [RegisterController::class, 'submit'])->name('register.submit');
    Route::get('/login', [AuthController::class, 'ShowLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

// logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/home', [AuthController::class, 'home'])->name('home');
// Profile routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profileAdmin', [App\Http\Controllers\ProfileController::class, 'showAdmin'])->name('profileAdmin.show');
    Route::get('/profileAdmin/edit', [App\Http\Controllers\ProfileController::class, 'editAdmin'])->name('profileAdmin.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profileAdmin', [App\Http\Controllers\ProfileController::class, 'updateAdmin'])->name('profileAdmin.update');
    Route::get('/profile/password', [App\Http\Controllers\ProfileController::class, 'editPassword'])->name('profile.password.edit');
    Route::put('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

// route admin
Route::middleware(['auth'])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/admin/transaksi', [TransaksiController::class, 'home'])->name('admin.transaksi.index');
    Route::get('/admin/transaksi/{id}', [TransaksiController::class, 'show'])->name('admin.transaksi.show');
    Route::put('/admin/transaksi/{id}', [TransaksiController::class, 'update'])->name('admin.transaksi.update');
    Route::get('/admin/index', function () {
        return view('index');
    })->name('index');
    Route::get('/admin/reviews', [ReviewController::class, 'indexAdmin'])->name('admin.reviews.index');
    Route::get('/admin/reviews/{id}', [ReviewController::class, 'show'])->name('admin.reviews.show');
    Route::post('/admin/reviews/{id}/reply', [ReviewController::class, 'reply'])->name('admin.reviews.reply');
    // Route::get('/dashboard/export', [AdminController::class, 'exportExcel'])->name('dashboard.export');
    Route::get('/dashboard/export', [AdminController::class, 'exportPdf'])->name('dashboard.export');

});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // ... existing routes

    // Keuangan routes
    Route::get('/keuangan', [KeuanganController::class, 'index'])->name('keuangan.index');
    Route::post('/keuangan/modal', [KeuanganController::class, 'storeModal'])->name('keuangan.store-modal');
    Route::put('/keuangan/modal/{modal}', [KeuanganController::class, 'updateModal'])->name('keuangan.update-modal');
    Route::delete('/keuangan/modal/{modal}', [KeuanganController::class, 'destroyModal'])->name('keuangan.destroy-modal');
    Route::get('/keuangan/report', [KeuanganController::class, 'report'])->name('keuangan.report');
});

// dashboard
Route::get('/productsAdmin', [ProdukController::class, 'index'])->name('productsAdmin.index');
Route::get('/productsAdmin/create', [ProdukController::class, 'create'])->name('productsAdmin.create');
Route::post('/productsAdmin', [ProdukController::class, 'store'])->name('productsAdmin.store');
Route::get('/productsAdmin/{produk}', [ProdukController::class, 'show'])->name('productsAdmin.showProduk');
Route::get('/productsAdmin/{produk}/editProduk', [ProdukController::class, 'edit'])->name('productsAdmin.editProduk');
Route::put('/productsAdmin/{produk}', [ProdukController::class, 'update'])->name('productsAdmin.update');
Route::patch('/productsAdmin/{produk}/restore', [ProdukController::class, 'restore'])->name('productsAdmin.restore');
Route::delete('/productsAdmin/{produk}', [ProdukController::class, 'destroy'])->name('productsAdmin.destroy');
Route::patch('/productsAdmin/{produk}/deactivate', [ProdukController::class, 'deactivate'])->name('productsAdmin.deactivate');

//produk
Route::get('/products', [ProdukController::class, 'customer'])->name('products');
Route::get('/products/{id}/detail', [ProdukController::class, 'detail'])->name('products.detail');

// Routes for Product Detail
Route::get('/products/{id}/detail', [App\Http\Controllers\ProdukController::class, 'detail'])->name('products.detail');
Route::post('/products/add-to-keranjang', [App\Http\Controllers\ProdukController::class, 'addToKeranjang'])->name('products.addToKeranjang');
Route::post('/products', [App\Http\Controllers\ProdukController::class, 'DetailaddToKeranjang'])->name('products.DetailaddToKeranjang');


Route::get('/api/products', [ProdukController::class, 'getProducts'])->name('api.products');

// Routes for Keranjang
Route::get('/keranjang', [App\Http\Controllers\KeranjangController::class, 'index'])->name('keranjang.index');
Route::put('/keranjang/{id}', [App\Http\Controllers\KeranjangController::class, 'update'])->name('keranjang.update');
Route::delete('/keranjang/{id}', [App\Http\Controllers\KeranjangController::class, 'destroy'])->name('keranjang.destroy');
Route::delete('/keranjang/{id}', [App\Http\Controllers\KeranjangController::class, 'destroyBig'])->name('keranjang.destroyBig');
Route::delete('/keranjang', [KeranjangController::class, 'removeByProduct']);
Route::put('/keranjang/{id}/increase', [KeranjangController::class, 'increaseQuantity']);
Route::put('/keranjang/{id}/decrease', [KeranjangController::class, 'decreaseQuantity']);
Route::get('/keranjang/get', [KeranjangController::class, 'getKeranjang'])->name('keranjang.get');

// Placeholder for checkout route
Route::group(['middleware' => ['auth']], function() {
    Route::get('/checkout', [TransaksiController::class, 'checkout'])->name('checkout');
    Route::get('/transaksi', [TransaksiController::class, 'payment'])
    ->name('transaksi.payment');
    Route::get('/transaksi/histori', [TransaksiController::class, 'histori'])
    ->name('transaksi.histori');
    Route::post('/', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::post('/transaksi/{id}/selesaikan', [TransaksiController::class, 'selesaikan'])->name('transaksi.selesaikan');

    Route::get('/reviews', [ReviewController::class, 'index'])->name('customer.reviews.index');
    Route::get('/reviews/create/{transactionId}', [ReviewController::class, 'create'])->name('customer.reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('customer.reviews.store');


});
// Payment routes
Route::post('transaksi/notification', [TransaksiController::class, 'notificationHandler']);
Route::get('transaksi/{transaksi}/check-status', [TransaksiController::class, 'checkStatus'])->name('transaksi.check-status');

Route::get('/provinces', [RajaOngkirController::class, 'getProvinces']);
Route::get('/cities', [RajaOngkirController::class, 'getCities']);
Route::post('/shipping-cost', [RajaOngkirController::class, 'getShippingCost']);
