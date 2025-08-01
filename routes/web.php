<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Users\UsersController;
use App\Http\Controllers\Employees\EmployeesController;
use App\Http\Controllers\Roles\RolesController;
use App\Http\Controllers\Clients\ClientsController;
use App\Http\Controllers\ServiceRequests\ServiceRequestController;
use App\Http\Controllers\ClientCompany\ClientCompanyController;
use App\Http\Controllers\WorkOrder\WorkOrderController;
use App\Http\Controllers\WorkOrderProfile\WorkOrderProfileController;
use App\Http\Controllers\PushNotificationController;

use App\Http\Controllers\Billboard\BillboardController;
use App\Http\Controllers\Billboard\BillboardBookingController;
use App\Http\Controllers\Location\LocationController;
use Illuminate\Support\Facades\Storage;

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

Auth::routes();

// Login
Route::get('/', function () {
    return redirect('/login');
});


Route::group(['middleware' => ['auth']], function () {
    Route::resource('/home', HomeController::class)->only(['index']);

    // Location
    Route::get('/location/all-districts', [LocationController::class, 'getAllDistricts'])->name('location.getAllDistricts');
    Route::post('/get-districts', [LocationController::class, 'getDistrictsByState'])->name('location.getDistricts');
    Route::post('/get-locations', [LocationController::class, 'getLocationsByDistrict'])->name('location.getLocations');


    // Billboard
    Route::get('/billboard', [BillboardController::class, 'index'])->name('billboard.index');
    Route::post('/billboard/list', [BillboardController::class, 'list'])->name('billboard.list');
    Route::post('/billboard/create', [BillboardController::class, 'create'])->name('billboard.create');
    Route::post('/billboard/delete', [BillboardController::class, 'delete'])->name('billboard.delete');
    Route::post('/billboard/edit', [WorkOrderController::class, 'edit'])->name('billboard.edit');
    Route::post('/billboard/updateStatus', [WorkOrderController::class, 'update'])->name('billboard.update');
    Route::get('/notification', [PushNotificationController::class, 'notificationHistory']);
    Route::get('/billboards/export/pdf', [BillboardController::class, 'exportListPdf'])->name('billboards.export.pdf');


    // Billboard Detail
    Route::get('/billboardDetail/{id}', [BillboardController::class, 'redirectNewTab'])->name('billboard.detail');
    Route::post('/workOrderProfile/addActivity', [WorkOrderProfileController::class, 'create'])->name('workOrderProfile.create');
    Route::post('/workOrderProfile/deleteComment', [WorkOrderProfileController::class, 'deleteComment'])->name('workOrderProfile.deleteComment');
    Route::post('/workOrderProfile/store', [WorkOrderProfileController::class, 'store'])->name('workOrderProfile.store');
    Route::post('/workOrderProfile/temp-upload', [WorkOrderProfileController::class, 'tempUpload'])->name('tempUpload');
    Route::get('/billboard/{id}/download', [BillboardController::class, 'downloadPdf'])->name('billboard.download');

    // Billboard Booking
    Route::get('/billboardBooking', [BillboardBookingController::class, 'index'])->name('billboard.booking.index');
    Route::post('/billboardBooking/list', [BillboardBookingController::class, 'list'])->name('billboard.booking.list');
    Route::post('/booking/calendar', [BillboardBookingController::class, 'getCalendarBookings'])->name('billboard.booking.calendar');











    // Billboard Booking
    Route::get('/serviceRequest', [ServiceRequestController::class, 'Index'])->name('serviceRequest.index');
    Route::post('/serviceRequest/list', [ServiceRequestController::class, 'serviceRequestList'])->name('serviceRequest.list.index');
    // Route::get('/service-request/pre-create', [ServiceRequestController::class, 'serviceRequestPreCreate']);
    Route::get('/get-subcategories/{sr_category_id}', [ServiceRequestController::class, 'getSubcategories']);
    Route::post('/serviceRequest/create', [ServiceRequestController::class, 'create'])->name('serviceRequest.create');
    Route::post('/serviceRequest/store', [ServiceRequestController::class, 'store'])->name('serviceRequest.store');
    Route::post('/serviceRequest/edit', [ServiceRequestController::class, 'edit'])->name('serviceRequest.edit');
    Route::put('/serviceRequest/update/{id}', [ServiceRequestController::class, 'Update'])->name('serviceRequest.update');
    Route::post('/serviceRequest/delete', [ServiceRequestController::class, 'delete'])->name('serviceRequest.delete');
    Route::post('/serviceRequest/reject', [ServiceRequestController::class, 'reject'])->name('serviceRequest.reject');

    // Clients
    Route::get('/clients', [ClientsController::class, 'index'])->name('clients.index');
    Route::post('/clients/list', [ClientsController::class, 'list'])->name('clients.list');
    Route::post('/clients/create', [ClientsController::class, 'create'])->name('clients.create');
    Route::post('/clients/edit', [ClientsController::class, 'edit'])->name('clients.edit');
    Route::post('/clients/delete', [ClientsController::class, 'delete'])->name('clients.delete');

    // Client Company
    Route::get('/client-company', [ClientCompanyController::class, 'index'])->name('client-company.index');
    Route::post('/client-company/list', [ClientCompanyController::class, 'list'])->name('client-company.list');
    Route::post('/client-company/create', [ClientCompanyController::class, 'create'])->name('client-company.create');
    Route::post('/client-company/edit', [ClientCompanyController::class, 'edit'])->name('client-company.edit');
    Route::post('/client-company/delete', [ClientCompanyController::class, 'delete'])->name('client-company.delete');

















    // Users Employee
    Route::get('/users', [UsersController::class, 'index'])->name('users');
    Route::post('/users/list/employee', [UsersController::class, 'listEmployee'])->name('users.list.employee');
    Route::post('/users/create/employee', [UsersController::class, 'createEmployee'])->name('users.create.employee');
    Route::get('/users/create/employee/get-employees', [UsersController::class, 'createGetEmployees'])->name('users.create.employee.get.employees');
    Route::post('/users/edit/employee', [UsersController::class, 'editEmployee'])->name('users.edit.employee');
    Route::post('/users/delete/employee', [UsersController::class, 'deleteEmployee'])->name('users.delete.employee');
    
    // Users Client
    Route::post('/users/list/client', [UsersController::class, 'listClient'])->name('users.list.client');
    Route::post('/users/create/client', [UsersController::class, 'createClient'])->name('users.create.client');
    Route::get('/users/create/client/get-clients', [UsersController::class, 'createGetClients'])->name('users.create.client.get.clients');
    Route::post('/users/edit/client', [UsersController::class, 'editClient'])->name('users.edit.client');
    Route::post('/users/delete/client', [UsersController::class, 'deleteClient'])->name('users.delete.client');
    
    // Employees
    Route::get('/employees', [EmployeesController::class, 'index'])->name('employees.index');
    Route::post('/employees/create', [EmployeesController::class, 'create'])->name('employees.create');
    Route::post('/employees/list', [EmployeesController::class, 'list'])->name('employees.list');
    Route::post('/employees/edit', [EmployeesController::class, 'edit'])->name('employees.edit');
    Route::delete('/employees/delete/{id}', [EmployeesController::class, 'Destroy'])->name('employees.destroy');

    

    

    // Roles
    Route::get('/roles', [RolesController::class, 'Index'])->name('roles.index');
    Route::get('/roles/create', [RolesController::class, 'Create'])->name('roles.create');
    Route::post('/roles/store', [RolesController::class, 'Store'])->name('roles.store');
    Route::get('/roles/edit/{id}', [RolesController::class, 'Edit'])->name('roles.edit');
    Route::put('/roles/update/{id}', [RolesController::class, 'Update'])->name('roles.update');
    Route::delete('/roles/delete/{id}', [RolesController::class, 'Destroy'])->name('roles.destroy');
    
    // Service Request Category
    Route::get('/serviceRequestCategory', [ServiceRequestController::class, 'serviceCategory'])->name('serviceRequest.category');
    Route::post('/serviceRequestCategory/list', [ServiceRequestController::class, 'serviceCategoryList'])->name('serviceRequest.category.get');
    Route::post('/serviceRequestCategory/store', [ServiceRequestController::class, 'serviceCategoryStore'])->name('serviceRequest.category.store');
    Route::post('/serviceRequestCategory/update', [ServiceRequestController::class, 'serviceCategoryUpdate'])->name('serviceRequest.category.update');
    Route::post('/serviceRequestCategory/delete', [ServiceRequestController::class, 'serviceCategoryDestroy'])->name('serviceRequest.category.destroy');

    // Billboard Booking
    Route::get('/serviceRequest', [ServiceRequestController::class, 'Index'])->name('serviceRequest.index');
    Route::post('/serviceRequest/list', [ServiceRequestController::class, 'serviceRequestList'])->name('serviceRequest.list.index');
    // Route::get('/service-request/pre-create', [ServiceRequestController::class, 'serviceRequestPreCreate']);
    Route::get('/get-subcategories/{sr_category_id}', [ServiceRequestController::class, 'getSubcategories']);
    Route::post('/serviceRequest/create', [ServiceRequestController::class, 'create'])->name('serviceRequest.create');
    Route::post('/serviceRequest/store', [ServiceRequestController::class, 'store'])->name('serviceRequest.store');
    Route::post('/serviceRequest/edit', [ServiceRequestController::class, 'edit'])->name('serviceRequest.edit');
    Route::put('/serviceRequest/update/{id}', [ServiceRequestController::class, 'Update'])->name('serviceRequest.update');
    Route::post('/serviceRequest/delete', [ServiceRequestController::class, 'delete'])->name('serviceRequest.delete');
    Route::post('/serviceRequest/reject', [ServiceRequestController::class, 'reject'])->name('serviceRequest.reject');

    

    // Work Order Profile
    // Route::get('/workOrderProfile/{id}', [WorkOrderProfileController::class, 'redirectNewTab'])->name('workOrderProfile.index');
    Route::post('/workOrderProfile/addActivity', [WorkOrderProfileController::class, 'create'])->name('workOrderProfile.create');
    Route::post('/workOrderProfile/deleteComment', [WorkOrderProfileController::class, 'deleteComment'])->name('workOrderProfile.deleteComment');
    Route::post('/workOrderProfile/store', [WorkOrderProfileController::class, 'store'])->name('workOrderProfile.store');
    Route::post('/workOrderProfile/temp-upload', [WorkOrderProfileController::class, 'tempUpload'])->name('tempUpload');

    
    // Notification Controllers
    Route::post('/send-push-notification', [PushNotificationController::class, 'sendPushNotification']); 

    // notification 2
    Route::post('send',[HomeController::class,"sendnotification"]);
});
