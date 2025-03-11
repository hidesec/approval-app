<?php

namespace App\Providers;

use App\Repositories\ApprovalStage\ApprovalStageRepository;
use App\Repositories\ApprovalStage\ApprovalStageRepositoryInterface;
use App\Repositories\Approver\ApproverRepository;
use App\Repositories\Approver\ApproverRepositoryInterface;
use App\Repositories\Auth\AuthRepository;
use App\Repositories\Auth\AuthRepositoryInterface;
use App\Repositories\Expense\ExpenseRepository;
use App\Repositories\Expense\ExpenseRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(ApproverRepositoryInterface::class, ApproverRepository::class);
        $this->app->bind(ApprovalStageRepositoryInterface::class, ApprovalStageRepository::class);
        $this->app->bind(ExpenseRepositoryInterface::class, ExpenseRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
