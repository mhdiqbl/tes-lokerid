<?php

namespace App\Repositories\Expense;

use App\Models\Expense;

class ExpenseRepositoryImp implements ExpenseRepository
{
    public function __construct(
        public Expense $expense,
    )
    {
    }

    public function insert(array $request)
    {
        return $this->expense->create($request);
    }

    public function findById(int $expenseId)
    {
        return $this->expense
            ->with(['status:id,name', 'approval' => function ($approval) {
                $approval->with(['approver', 'status']);
            }])
            ->findOrFail($expenseId);
    }


}
