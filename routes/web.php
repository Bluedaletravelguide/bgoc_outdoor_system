<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Users\UsersController;
use App\Http\Controllers\Employees\EmployeesController;
use App\Http\Controllers\Roles\RolesController;
use App\Http\Controllers\Clients\ClientsController;
use App\Http\Controllers\ServiceRequests\ServiceRequestController;
use App\Http\Controllers\Projects\ProjectsController;
use App\Http\Controllers\Vendors\VendorsController;
use App\Http\Controllers\ClientCompany\ClientCompanyController;
use App\Http\Controllers\WorkOrder\WorkOrderController;
use App\Http\Controllers\WorkOrderProfile\WorkOrderProfileController;
use App\Http\Controllers\PushNotificationController;
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

    // Roles
    Route::get('/roles', [RolesController::class, 'Index'])->name('roles.index');
    Route::get('/roles/create', [RolesController::class, 'Create'])->name('roles.create');
    Route::post('/roles/store', [RolesController::class, 'Store'])->name('roles.store');
    Route::get('/roles/edit/{id}', [RolesController::class, 'Edit'])->name('roles.edit');
    Route::put('/roles/update/{id}', [RolesController::class, 'Update'])->name('roles.update');
    Route::delete('/roles/delete/{id}', [RolesController::class, 'Destroy'])->name('roles.destroy');

    // Work Order Activity
    // Route::get('/workOrderActivity', [WorkOrderProfileController::class, 'index'])->name('vendors.index');
    Route::post('/vendors/list', [VendorsController::class, 'list'])->name('vendors.list');
    Route::post('/vendors/create', [VendorsController::class, 'create'])->name('vendors.create');
    Route::post('/vendors/edit', [VendorsController::class, 'edit'])->name('vendors.edit');
    Route::post('/vendors/delete', [VendorsController::class, 'delete'])->name('vendors.delete');
    
    // Service Request Category
    Route::get('/serviceRequestCategory', [ServiceRequestController::class, 'serviceCategory'])->name('serviceRequest.category');
    Route::post('/serviceRequestCategory/list', [ServiceRequestController::class, 'serviceCategoryList'])->name('serviceRequest.category.get');
    Route::post('/serviceRequestCategory/store', [ServiceRequestController::class, 'serviceCategoryStore'])->name('serviceRequest.category.store');
    Route::post('/serviceRequestCategory/update', [ServiceRequestController::class, 'serviceCategoryUpdate'])->name('serviceRequest.category.update');
    Route::post('/serviceRequestCategory/delete', [ServiceRequestController::class, 'serviceCategoryDestroy'])->name('serviceRequest.category.destroy');

    // Service Request
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
    
    // Projects
    Route::get('/projects', [ProjectsController::class, 'index'])->name('projects.index');
    Route::post('/projects/list', [ProjectsController::class, 'list'])->name('projects.list');
    Route::post('/projects/create', [ProjectsController::class, 'create'])->name('projects.create');
    Route::post('/projects/edit', [ProjectsController::class, 'edit'])->name('projects.edit');
    Route::post('/projects/delete', [ProjectsController::class, 'delete'])->name('projects.delete');

    // Work Order
    Route::get('/workOrder', [WorkOrderController::class, 'index'])->name('workOrder.index');
    Route::post('/workOrder/onGoingWorkOder/list', [WorkOrderController::class, 'list'])->name('workOrder.list');
    Route::post('/workOrder/edit', [WorkOrderController::class, 'edit'])->name('workOrder.edit');
    Route::post('/workOrder/updateStatus', [WorkOrderController::class, 'update'])->name('workOrder.update');
    Route::get('/notification', [PushNotificationController::class, 'notificationHistory']);

    // Work Order Profile
    Route::get('/workOrderProfile/{id}', [WorkOrderProfileController::class, 'redirectNewTab'])->name('workOrderProfile.index');
    Route::post('/workOrderProfile/addActivity', [WorkOrderProfileController::class, 'create'])->name('workOrderProfile.create');
    Route::post('/workOrderProfile/deleteComment', [WorkOrderProfileController::class, 'deleteComment'])->name('workOrderProfile.deleteComment');
    Route::post('/workOrderProfile/store', [WorkOrderProfileController::class, 'store'])->name('workOrderProfile.store');
    Route::post('/workOrderProfile/temp-upload', [WorkOrderProfileController::class, 'tempUpload'])->name('tempUpload');

    
    // Notification Controllers
    Route::post('/send-push-notification', [PushNotificationController::class, 'sendPushNotification']); 

    // notification 2
    Route::post('send',[HomeController::class,"sendnotification"]);
});
