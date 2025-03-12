<?php

namespace App\Providers;

use App\Repositories\Approval\ApprovalRepository;
use App\Repositories\Approval\ApprovalRepositoryImp;
use App\Repositories\ApprovalStage\ApprovalStageRepository;
use App\Repositories\ApprovalStage\ApprovalStageRepositoryImp;
use App\Repositories\Approver\ApproverRepository;
use App\Repositories\Approver\ApproverRepositoryImp;
use App\Repositories\Expense\ExpenseRepository;
use App\Repositories\Expense\ExpenseRepositoryImp;
use App\Repositories\Status\StatusRepository;
use App\Repositories\Status\StatusRepositoryImp;
use App\Services\Approval\ApprovalService;
use App\Services\ApprovalStage\ApprovalStageService;
use App\Services\ApprovalStage\ApprovalStageServiceImp;
use App\Services\Approver\ApproverService;
use App\Services\Approver\ApproverServiceImp;
use App\Services\Expense\ExpenseService;
use App\Services\Expense\ExpenseServiceimp;
use App\Services\Status\StatusService;
use App\Services\Status\StatusServiceImp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\LazyLoadingViolationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ApproverService::class, ApproverServiceImp::class);
        $this->app->singleton(ApproverRepository::class, ApproverRepositoryImp::class);
        $this->app->singleton(StatusService::class, StatusServiceImp::class);
        $this->app->singleton(StatusRepository::class, StatusRepositoryImp::class);
        $this->app->singleton(ApprovalStageService::class, ApprovalStageServiceImp::class);
        $this->app->singleton(ApprovalStageRepository::class, ApprovalStageRepositoryImp::class);
        $this->app->singleton(ExpenseService::class, ExpenseServiceimp::class);
        $this->app->singleton(ExpenseRepository::class, ExpenseRepositoryImp::class);
        $this->app->singleton(ApprovalRepository::class, ApprovalRepositoryImp::class);
    }

    public function provides()
    {
        return [
            ApproverService::class,
            ApproverRepository::class,
        ];
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::handleLazyLoadingViolationUsing(function ($model, $relation) {
            $class = $model->$relation()->getRelated();

            if (Str::startsWith(get_class($class), 'App')) {
                throw new LazyLoadingViolationException($model, $relation);
            }
        });

        DB::listen(function (QueryExecuted $query) {
            Log::info($query->sql);
        });
    }
}
