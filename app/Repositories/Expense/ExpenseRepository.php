<?php

namespace App\Repositories\Expense;

interface ExpenseRepository
{
    public function insert(array $request);
    public function findById(int $expenseId);
}
