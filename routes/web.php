<?php

use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Kelas
    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
    Route::get('/kelas/getall', [KelasController::class, 'getall'])->name('kelas.getall');
    Route::post('/kelas/store', [KelasController::class, 'store'])->name('kelas.store');
    Route::post('/kelas/update', [KelasController::class, 'update'])->name('kelas.update');
    Route::delete('/kelas/delete/{id}', [KelasController::class, 'destroy'])->name('kelas.delete');
    Route::get('/kelas/count', [KelasController::class, 'count'])->name('kelas.count');
    Route::get('/kelas/getSiswa/{id}', [KelasController::class, 'getSiswa'])->name('kelas.getSiswa');
    Route::get('/kelas/getGuru/{id}', [KelasController::class, 'getGuru'])->name('kelas.getGuru');
    Route::get('/kelas/getDetail/{id}', [KelasController::class, 'getDetail'])->name('kelas.getDetail');


    // Guru
    Route::get('/guru', [GuruController::class, 'index'])->name('guru.index');
    Route::get('/guru/getall', [GuruController::class, 'getall'])->name('guru.getall');
    Route::post('/guru/store', [GuruController::class, 'store'])->name('guru.store');
    Route::post('/guru/update', [GuruController::class, 'update'])->name('guru.update');
    Route::get('/guru/count', [GuruController::class, 'count'])->name('guru.count');
    Route::delete('/guru/delete/{id}', [GuruController::class, 'destroy'])->name('guru.delete');

    // Siswa
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('/siswa/getall', [SiswaController::class, 'getall'])->name('siswa.getall');
    Route::post('/siswa/store', [SiswaController::class, 'store'])->name('siswa.store');
    Route::post('/siswa/update', [SiswaController::class, 'update'])->name('siswa.update');
    Route::get('/siswa/count', [SiswaController::class, 'count'])->name('siswa.count');
    Route::delete('/siswa/delete/{id}', [SiswaController::class, 'destroy'])->name('siswa.delete');

});



require __DIR__.'/auth.php';
