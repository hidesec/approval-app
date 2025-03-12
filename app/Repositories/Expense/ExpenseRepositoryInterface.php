<?php

namespace App\Repositories\Expense;

interface ExpenseRepositoryInterface
{
    public function createExpense(array $data);
    public function approveExpense(int $id, int $approverId): bool;
}
