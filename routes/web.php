<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MyTaskController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ClinicsController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {

    // Ticket routes
    Route::prefix('ticket')->as('ticket.')->group(function () {


        // fetch all data 
        Route::get('/dashboard', [DashboardController::class, 'TicketingDashboard'])->middleware(['auth', 'verified'])->name('TicketingDashboard');


        //viewing of template for ticketing XX
        Route::get('/ticket-form/gaoc-form-ticket', [TicketController::class, 'createGAOC'])->name('gaoc');
        Route::get('/ticket-form/novo-form-ticket', [TicketController::class, 'createNOVO'])->name('novo');

        Route::get('/ticket-form/gss-form-ticket', [TicketController::class, 'createGSS'])->name('gss');
        Route::get('/ticket-form/ggc-form-ticket', [TicketController::class, 'createGCC'])->name('gcc');

        Route::get('/index-clinics', [TicketController::class, 'index_clinics'])->name('index_clinics');

        Route::get('/index-offices', [TicketController::class, 'index_offices'])->name('index_offices');

        Route::get('/fetchClinicalTicketData', [TicketController::class, 'fetchClinicalTicketData'])->name('fetchClinicalTicketData');

        Route::get('/fetchOfficeTicketData', [TicketController::class, 'fetchOfficeTicketData'])->name('fetchOfficeTicketData');



        // ticket assigning 
        Route::post('/ticket/task-assign', [TicketController::class, 'taskAssign'])->name('task_assign');

        //Ticket form routes
        
        Route::get('/edit/edit-ticket-gaoc{id}', [TicketController::class, 'editGAOC'])->name('editTicketGaoc');

        Route::post('/store', [TicketController::class, 'store'])->name('store');
        
        Route::put('/update', [TicketController::class, 'update'])->name('update');
        Route::delete('/delete-ticket/{id}', [TicketController::class, 'destroy'])->name('ticket-destroy');

        Route::put('/change_status_ticket/{id}', [TicketController::class, 'updateStatus'])->name('update-ticket-status');

    });
        // my task  routes
        Route::prefix('myTask')->as('myTask.')->group(function () {
            Route::get('/fetchMyTaskTickets', [MyTaskController::class, 'fetchMyTaskTickets'])->name('fetchMyTaskTickets');
            Route::get('/index', [MyTaskController::class, 'index'])->name('index');
            Route::get('/create', [MyTaskController::class, 'create'])->name('create');
            Route::post('/store', [MyTaskController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [MyTaskController::class, 'edit'])->name('edit');
            Route::put('/update', [MyTaskController::class, 'update'])->name('update');
            Route::delete('/delete-clinic/{id}', [MyTaskController::class, 'destroy'])->name('destroy');
        });


        // Clinic routes
    Route::prefix('clinic')->as('clinic.')->group(function () {
        // /admin/clinic && admin.clinic
        
        Route::get('/fetchClinicData', [ClinicsController::class, 'fetchClinicData'])->name('fetchClinicData');

        Route::get('/index', [ClinicsController::class, 'index'])->name('index');
        Route::get('/create', [ClinicsController::class, 'create'])->name('create');
        Route::post('/store', [ClinicsController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ClinicsController::class, 'edit'])->name('edit');
        Route::put('/update', [ClinicsController::class, 'update'])->name('update');
        Route::delete('/delete-clinic/{id}', [ClinicsController::class, 'destroy'])->name('destroy');
    });
        // Department routes
    Route::prefix('department')->as('department.')->group(function () {
        
        Route::get('/fetchDepartmentData', [DepartmentController::class, 'fetchDepartmentData'])->name('fetchDepartmentData');

        Route::get('/index', [DepartmentController::class, 'index'])->name('index');
        Route::get('/create', [DepartmentController::class, 'create'])->name('create');
        Route::post('/store', [DepartmentController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [DepartmentController::class, 'edit'])->name('edit');
        Route::put('/update', [DepartmentController::class, 'update'])->name('update');
        Route::delete('/delete-clinic/{id}', [DepartmentController::class, 'destroy'])->name('destroy');
    });


            // Users routes
    Route::prefix('user')->as('users.')->group(function () {
        
        Route::get('/fetchUserData', [UserController::class, 'fetchUserData'])->name('fetchUserData');

        Route::get('/index', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::put('/update', [UserController::class, 'update'])->name('update');
        Route::delete('/delete-clinic/{id}', [UserController::class, 'destroy'])->name('destroy');

        
    });


});
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

require __DIR__.'/auth.php';
