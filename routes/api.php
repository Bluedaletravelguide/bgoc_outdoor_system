<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Clients\ServiceRequestController;
use App\Http\Controllers\Api\Technicians\WorkOrderController;
use App\Http\Controllers\PushNotificationController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// Public Routes
Route::post('/login', [LoginController::class, 'login']);
Route::post('/storeDeviceToken', [PushNotificationController::class, 'storeDeviceToken']);

// Protected Routes
Route::group(['middleware' => ['auth:api']], function () {
    // Client Routes
    Route::prefix('client')->group(function () {
        Route::get('/dashboard', [ServiceRequestController::class, 'index']);
        Route::get('/list/service-request/in-progress', [ServiceRequestController::class, 'serviceRequestInProgress']);
        Route::get('/list/service-request/completed', [ServiceRequestController::class, 'serviceRequestCompleted']);
        Route::get('/list/service-request/in-progress/detail/{srId}', [ServiceRequestController::class, 'serviceRequestDetail']);
        Route::get('/list/service-request/in-progress/detail/servicerequestphoto/{srId}', [ServiceRequestController::class, 'fetchImage']);
        Route::get('/service-request/pre-create', [ServiceRequestController::class, 'serviceRequestPreCreate']);
        Route::post('/service-request/create', [ServiceRequestController::class, 'create']);
        Route::get('/notification', [PushNotificationController::class, 'notificationHistory']);
    });

    // Technician Routes
    Route::prefix('technician')->group(function () {
        Route::get('/dashboard', [WorkOrderController::class, 'index']);
        Route::get('/list/work-order/in-progress', [WorkOrderController::class, 'workOrderInProgress']);
        Route::get('/list/work-order/completed', [WorkOrderController::class, 'workOrderCompleted']);
        Route::get('/list/work-order/in-progress/details/{woId}', [WorkOrderController::class, 'woInProgressDetail']);
        Route::post('/list/work-order/in-progress/detail/acceptJob', [WorkOrderController::class, 'acceptJob']);
        Route::post('/list/work-order/in-progress/detail/rejectJob', [WorkOrderController::class, 'rejectJob']);
        Route::post('/list/work-order/in-progress/detail/beforeObs', [WorkOrderController::class, 'storeImage']);
        Route::get('/list/work-order/in-progress/detail/workOrderObservation/{type}/{woId}', [WorkOrderController::class, 'fetchImage']);
        Route::get('/notification', [PushNotificationController::class, 'notificationHistory']);
    });

    // Supervisor Routes
    Route::prefix('supervisor')->group(function () {
        Route::get('/dashboard', [WorkOrderController::class, 'index']);
        Route::get('/list/work-order/in-progress', [WorkOrderController::class, 'workOrderInProgress']);
        Route::get('/list/service-request/completed', [WorkOrderController::class, 'workOrderCompleted']);
        Route::get('/list/work-order/in-progress/details/{woId}', [WorkOrderController::class, 'woInProgressDetail']);
        Route::post('/list/work-order/in-progress/detail/beforeObs', [WorkOrderController::class, 'storeImage']);
        Route::get('/list/work-order/in-progress/detail/workOrderObservation/{type}/{woId}', [WorkOrderController::class, 'fetchImage']);
    });
});
