
<?php

use App\Http\Controllers\ApprovalStageController;
use App\Http\Controllers\ApproverController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExpenseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('jwt.auth')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login']);
Route::middleware('jwt.auth')->post('/approvers', [ApproverController::class, 'store']);
Route::middleware('jwt.auth')->post('/approval-stages', [ApprovalStageController::class, 'storeApprovalStage']);
Route::middleware('jwt.auth')->put('/approval-stages/{id}', [ApprovalStageController::class, 'updateApprovalStage']);
Route::middleware('jwt.auth')->post('/expense', [ExpenseController::class, 'storeExpense']);
Route::middleware('jwt.auth')->patch('expense/{id}/approve', [ExpenseController::class, 'approve']);
Route::middleware('jwt.auth')->get('/expense/{id}', [ExpenseController::class, 'show']);
