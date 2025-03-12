<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApproverController;
use App\Http\Controllers\ApprovalStageController;
use App\Http\Controllers\ExpenseController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//middleware('auth:sanctum')
Route::controller(ApproverController::class)->prefix('/approvers')
    ->group(function () {
        Route::post("/", 'store');
    });

Route::controller(ApprovalStageController::class)->prefix('/approval-stages')
    ->group(function () {
        Route::post("/", 'store');
        Route::put("/{approvalStage}", 'update');
    });

Route::controller(ExpenseController::class)->prefix('/expense')
    ->group(function () {
        Route::get("/{id}", 'getExpenseById');
        Route::post("/", 'store');
        Route::patch("/{expense}/approve", 'approveExpense');
    });
