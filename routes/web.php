<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DispensingController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\MedCategoryController;
use App\Http\Controllers\MedicalHistoryController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\MedTypeController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TemporaryStockController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PDFController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        // 'canRegister' => Route::has('register'),
        // 'laravelVersion' => Application::VERSION,
        // 'phpVersion' => PHP_VERSION,
    ]);
    // return Inertia::render('Auth.Login');
})->middleware('checkUserStatus');

// Route::post('/', [LoginController::class, 'login']);

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['checkUserStatus', 'auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/category', [MedCategoryController::class, 'index'])->name('category.index');
    Route::put('/category/{medcategory}',[MedCategoryController::class, 'update']);
    Route::post('/category',[MedCategoryController::class, 'store']);
    Route::delete('/category/{medcategory}', [MedCategoryController::class, 'destroy']);

    Route::get('/type', [MedTypeController::class, 'index'])->name('type.index');
    Route::put('/type/{medtype}',[MedTypeController::class, 'update']);
    Route::post('/type',[MedTypeController::class, 'store']);
    Route::delete('/type/{medtype}', [MedTypeController::class, 'destroy']);

    Route::get('/medicine', [MedicineController::class, 'index'])->name('medicine.index');
    Route::put('/medicine/{medicine}',[MedicineController::class, 'update']);
    Route::post('/medicine',[MedicineController::class, 'store']);
    Route::delete('/medicine/{medicine}', [MedicineController::class, 'destroy']);

    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');

    Route::get('/stock/create', [StockController::class, 'create'])->name('inventory.create');

    Route::get('/stock',[StockController::class , 'index'])->name('stock.index');
    Route::post('/stock',[StockController::class, 'store'])->name('stock.create');
    Route::get('/stock/edit/{stock}', [StockController::class, 'edit']);
    Route::put('/stock/{stock}',[StockController::class, 'update']);
    Route::delete('/stock/{stock}', [StockController::class, 'destroy']);

    Route::get('/doctor/create', [DoctorController::class, 'create'])->name('doctor.create');
    Route::get('/doctor',[DoctorController::class, 'index'])->name('doctor.index');
    Route::post('/doctor',[DoctorController::class, 'store']);
    Route::get('/doctor/edit/{doctor}', [DoctorController::class, 'edit']);
    Route::put('/doctor/{doctor}',[DoctorController::class, 'update']);
    Route::delete('/doctor/{doctor}', [DoctorController::class, 'destroy']);
    Route::get('/doctor/show/{doctor}', [DoctorController::class, 'show']);
    Route::post('/doctor/{doctor}/activate', [DoctorController::class, 'activate'])->name('doctor.activate');
    Route::post('/doctor/{doctor}/deactivate', [DoctorController::class, 'deactivate'])->name('doctor.deactivate');

    Route::get('/service/create', [ServiceController::class, 'create'])->name('service.create');
    Route::get('/service',[ServiceController::class, 'index'])->name('service.index');
    Route::post('/service',[ServiceController::class, 'store']);
    Route::get('/service/edit/{service}', [ServiceController::class, 'edit']);
    Route::put('/service/{service}',[ServiceController::class, 'update']);
    Route::delete('/service/{service}', [ServiceController::class, 'destroy']);

    Route::get('/dispense', [DispensingController::class, 'index'])->name('dispense.index');
    Route::put('/dispense/{dispense}',[DispensingController::class, 'update']);
    Route::post('/dispense',[DispensingController::class, 'store']);
    Route::delete('/dispense/{dispense}', [DispensingController::class, 'destroy']);

    Route::get('/appointment',[AppointmentController::class, 'index'])->name('appointment.index');
    Route::get('/appointment/create', [AppointmentController::class, 'create'])->name('appointment.create');
    Route::post('/appointment',[AppointmentController::class, 'store'])->name('appointment.store');
    Route::get('/appointment/edit/{appointment}', [AppointmentController::class, 'edit']);
    Route::put('/appointment/{appointment}',[AppointmentController::class, 'update']);
    Route::delete('/appointment/{appointment}', [AppointmentController::class, 'destroy']);
    Route::get('/appointment/show/{appointment}', [AppointmentController::class, 'show']);
    Route::post('/appointment/accept/{appointment}', [AppointmentController::class, 'accept']);
    Route::post('/appointment/cancel/{appointment}', [AppointmentController::class, 'cancel']);

    Route::get('/users',[UserController::class, 'index'])->name('user.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/users',[UserController::class, 'store'])->name('user.store');
    Route::get('/users/edit/{user}', [UserController::class, 'edit']);
    Route::put('/users/{user}',[UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);

    Route::get('/patient',[PatientController::class, 'index'])->name('patient.index');
    Route::get('/patient/create', [PatientController::class, 'create'])->name('patient.create');
    Route::post('/patient',[PatientController::class, 'store'])->name('patient.store');
    Route::get('/patient/edit/{patient}', [PatientController::class, 'edit']);
    Route::put('/patient/{patient}',[PatientController::class, 'update']);
    Route::delete('/patient/{patient}', [PatientController::class, 'destroy']);
    Route::get('/patient/show/{patient}', [PatientController::class, 'show']);

    Route::get('/form',[MedicalHistoryController::class, 'index']);
    Route::post('/form',[MedicalHistoryController::class, 'store']);

    Route::get('/healthForm/create/{patient}', [FormController::class, 'create']);
    Route::post('/healthForm',[FormController::class, 'store']);

    Route::get('/generate-pdf', [PDFController::class, 'generatePDF']);
});

require __DIR__.'/auth.php';
