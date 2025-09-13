<?php

use App\Http\Controllers\Assessment\AssessmentController;
use App\Http\Controllers\Assessment\AssignmentController;
use App\Http\Controllers\Assessment\HolisticController;
use App\Http\Controllers\Index\DashboardController;
use App\Http\Controllers\Index\LoginController;
use App\Http\Controllers\Master\JadwalPengampuController;
use App\Http\Controllers\Master\KegiatanController;
use App\Http\Controllers\Master\PelanggaranController;
use App\Http\Controllers\Master\PermissionController;
use App\Http\Controllers\Master\RoleController;
use App\Http\Controllers\Master\UserController;
use App\Http\Controllers\Pdf\HistoryPinaltyController;
use App\Http\Controllers\Pdf\SPController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //Permission Routes
    Route::get('/permission', [PermissionController::class, 'index'])->name('permission.index');
    Route::get('/permission/{id}', [PermissionController::class, 'getbyId'])->name('permission.id');
    Route::post('/permission/store', [PermissionController::class, 'store'])->name('permission.store');
    Route::delete('/permission/delete/{id}', [PermissionController::class, 'destroy'])->name('permission.destroy');
    Route::put('/permission/update/{id}', [PermissionController::class, 'update'])->name('permission.update');

    //Role Routes
    Route::get('/role', [RoleController::class, 'index'])->name('role.index');
    Route::get('/role/{id}', [RoleController::class, 'getbyId'])->name('role.id');
    Route::post('/role/store', [RoleController::class, 'store'])->name('role.store');
    Route::put('/role/update/{id}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('/role/delete/{id}', [RoleController::class, 'destroy'])->name('role.destroy');

    //User Routes
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/{id}', [UserController::class, 'getbyId'])->name('user.id');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::delete('/user/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');

    //kegiatan Routes
    Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan.index');
    Route::get('/kegiatan/{id}', [KegiatanController::class, 'getbyId'])->name('kegiatan.id');
    Route::post('/kegiatan/store', [KegiatanController::class, 'store'])->name('kegiatan.store');
    Route::delete('/kegiatan/delete/{id}', [KegiatanController::class, 'destroy'])->name('kegiatan.destroy');
    Route::put('/kegiatan/update/{id}', [KegiatanController::class, 'update'])->name('kegiatan.update');

    // Jadwal Pengampu Routes
    Route::get('/jadwal', [JadwalPengampuController::class, 'index'])->name('jadwal.index');
    Route::get('/jadwal/{id}', [JadwalPengampuController::class, 'getbyId'])->name('jadwal.id');
    Route::post('/jadwal/store', [JadwalPengampuController::class, 'store'])->name('jadwal.store');
    Route::delete('/jadwal/delete/{id}', [JadwalPengampuController::class, 'destroy'])->name('jadwal.destroy');
    Route::put('/jadwal/update/{id}', [JadwalPengampuController::class, 'update'])->name('jadwal.update');

    //Master Pelanggaran Routes
    Route::get('/pelanggaran', [PelanggaranController::class, 'index'])->name('pelanggaran.index');
    Route::post('/pelanggaran/store', [PelanggaranController::class, 'store'])->name('pelanggaran.store');
    Route::delete('/pelanggaran/delete/{id}', [PelanggaranController::class, 'destroy'])->name('pelanggaran.destroy');
    Route::get('/pelanggaran/{id}', [PelanggaranController::class, 'getbyId'])->name('pelanggaran.id');
    Route::put('/pelanggaran/update/{id}', [PelanggaranController::class, 'update'])->name('pelanggaran.update');

    // Assignment Routes
    Route::get('/assignment', [AssignmentController::class, 'index'])->name('assignment.index');
    Route::post('/assignment/assign', [AssignmentController::class, 'assignments'])->name('assignment.assign');
    Route::delete('/assignment/delete/{id}', [AssignmentController::class, 'destroy'])->name('assignment.destroy');

    // Assessment Routes
    Route::get('/assessment', [AssessmentController::class, 'index'])->name('assessment.index');
    Route::get('/assessment/detail/{id}', [AssessmentController::class, 'detail'])->name('assessment.detail');
    Route::delete('/assessment/member/delete/{id}', [AssessmentController::class, 'destroy_member'])->name('member.destroy');
    Route::post('/assessment/store_quantity', [AssessmentController::class, 'store_quantity'])->name('assessment.store_quantity');
    Route::post('/assessment/store_kehadiran', [AssessmentController::class, 'store_kehadiran'])->name('assessment.store_kehadiran');

    // Holistic Assessment Routes
    Route::get('/assessment/holistic', [HolisticController::class, 'index'])->name('assessment.holistic');
    Route::get('/assessment/holistic/data', [HolisticController::class, 'getData'])->name('assessment.holistic.data');
    Route::get('/assessment/holistic/detail/{id}', [HolisticController::class, 'getDetail'])->name('assessment.holistic.detail');
    Route::post('/assessment/holistic/store', [HolisticController::class, 'store'])->name('assessment.holistic.store');
    Route::delete('/assessment/holistic/delete/{id}', [HolisticController::class, 'destroy'])->name('assessment.holistic.destroy');
    Route::post('/assessment/riwayatsp', [HolisticController::class, 'store_spmhs'])->name('assessment.holistic.history.store');

    //Pdf
    Route::get('/pdf/history/{id}', [HistoryPinaltyController::class, 'history'])->name('pdf.history');
    Route::post('/pdf/sp1/{id}', [SPController::class, 'sp1'])->name('pdf.sp1');
    Route::get('/spmhs/pdf/{id}', [SPController::class, 'download'])->name('spmhs.download');
    Route::get('/raport/download', [DashboardController::class, 'download_raport'])->name('raport.download');

    //json
    Route::get('/dashboard/json/{id}', [DashboardController::class, 'json'])->name('dashboard.json');
});