<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//kategori
Route::get('/kategori', [App\Http\Controllers\kategoriController::class, 'index'])->name('kategori');
Route::get('/pdfkategori', [App\Http\Controllers\kategoriController::class, 'pdf'])->name('pdfkategori');
Route::get('/excelkategori', [App\Http\Controllers\kategoriController::class, 'excel'])->name('excelkategori');


Route::get('/addkategori', [App\Http\Controllers\kategoriController::class, 'add'])->name('addkategori');
Route::get('/editkategori/{id}', [App\Http\Controllers\kategoriController::class, 'edit'])->name('editkategori');
Route::post('/storekategori', [App\Http\Controllers\kategoriController::class, 'store'])->name('storekategori');
Route::get('/hapuskategori/{id}', [App\Http\Controllers\kategoriController::class, 'hapus'])->name('hapuskategori');
Route::post('/updatekategori', [App\Http\Controllers\kategoriController::class, 'update'])->name('updatekategori');

//user
Route::get('/user', [App\Http\Controllers\userController::class, 'index'])->name('user');
Route::get('/profile', [App\Http\Controllers\userController::class, 'profile'])->name('profile');
Route::post('/editProfile', [App\Http\Controllers\userController::class, 'editProfile'])->name('editProfile');

Route::get('/member', [App\Http\Controllers\userController::class, 'member'])->name('member');
Route::post('/storeMember', [App\Http\Controllers\userController::class, 'storeMember'])->name('storeMember');
Route::get('/adduser', [App\Http\Controllers\userController::class, 'add'])->name('adduser');
Route::post('/storeuser', [App\Http\Controllers\userController::class, 'store'])->name('storeuser');
Route::get('/hapususer/{id}', [App\Http\Controllers\userController::class, 'hapus'])->name('hapususer');
Route::get('/edituser/{id}', [App\Http\Controllers\userController::class, 'edit'])->name('edituser');
Route::post('/updateuser', [App\Http\Controllers\userController::class, 'update'])->name('updateuser');
Route::get('/pdfuser', [App\Http\Controllers\userController::class, 'pdf'])->name('pdfuser');
Route::get('/exceluser', [App\Http\Controllers\userController::class, 'excel'])->name('exceluser');

Route::post('/importuser', [App\Http\Controllers\userController::class, 'import'])->name('importuser');

Route::get('/adduser2', [App\Http\Controllers\userController::class, 'add2'])->name('adduser2');
Route::post('/storeuser2', [App\Http\Controllers\userController::class, 'store2'])->name('storeuser2');





//buku
Route::get('/buku', [App\Http\Controllers\bukuController::class, 'index'])->name('buku');
Route::get('/log', [App\Http\Controllers\bukuController::class, 'log'])->name('log');
Route::get('/aksiLog/{id}', [App\Http\Controllers\bukuController::class, 'aksiLog'])->name('aksiLog');

Route::get('/pdfbuku', [App\Http\Controllers\bukuController::class, 'pdf'])->name('pdfbuku');
Route::get('/excelbuku', [App\Http\Controllers\bukuController::class, 'excel'])->name('excelbuku');


Route::get('/addbuku', [App\Http\Controllers\bukuController::class, 'add'])->name('addbuku');
Route::post('/storebuku', [App\Http\Controllers\bukuController::class, 'store'])->name('storebuku');
Route::get('/hapusbuku/{id}', [App\Http\Controllers\bukuController::class, 'hapus'])->name('hapusbuku');
Route::get('/editbuku/{id}', [App\Http\Controllers\bukuController::class, 'edit'])->name('editbuku');
Route::post('/updatebuku', [App\Http\Controllers\bukuController::class, 'update'])->name('updatebuku');

//daftarBuku
Route::get('/daftarBuku', [App\Http\Controllers\bukuController::class, 'daftarBuku'])->name('daftarBuku');
Route::get('/detailBuku/{id}', [App\Http\Controllers\bukuController::class, 'detail'])->name('detailBuku');
Route::get('/bacaBuku/{id}', [App\Http\Controllers\bukuController::class, 'bacaBuku'])->name('bacaBuku');
Route::get('/bacaBukuMember/{id}', [App\Http\Controllers\bukuController::class, 'bacaBukuMember'])->name('bacaBukuMember');

Route::post('/komentar', [App\Http\Controllers\bukuController::class, 'komentar'])->name('komentar');
Route::post('/updatekomentar', [App\Http\Controllers\bukuController::class, 'updatekomentar'])->name('updatekomentar');

Route::get('/favorit', [App\Http\Controllers\bukuController::class, 'indexFavorit'])->name('favorit');
Route::post('/TambahFavorit', [App\Http\Controllers\bukuController::class, 'TambahFavorit'])->name('TambahFavorit');
Route::post('/HapusFavorit', [App\Http\Controllers\bukuController::class, 'HapusFavorit'])->name('HapusFavorit');






















