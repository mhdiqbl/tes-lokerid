<?php

namespace App\Services\Expense;

use App\Models\Expense;

interface ExpenseService
{
    public function getExpenseById(int $expenseId);
    public function createExpense(array $request);
    public function approveExpense(array $request, Expense $expense);
}
