<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApproveExpenseRequest;
use App\Http\Requests\StoreExpenseRequest;
use App\Repositories\Expense\ExpenseRepositoryInterface;
use Illuminate\Http\JsonResponse;

class ExpenseController extends Controller
{
    protected ExpenseRepositoryInterface $expenseRepository;

    public function __construct(ExpenseRepositoryInterface $expenseRepository)
    {
        $this->expenseRepository = $expenseRepository;
    }

    public function storeExpense(StoreExpenseRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $expense = $this->expenseRepository->createExpense($validatedData);
        return response()->json($expense, 201);
    }

    public function approve(ApproveExpenseRequest $request, int $id): JsonResponse
    {
        $approverId = $request->input('approver_id');
        $approved = $this->expenseRepository->approveExpense($id, $approverId);

        if ($approved) {
            return response()->json(['message' => 'Expense approved successfully.'], 200);
        }

        return response()->json(['message' => 'Expense approval failed.'], 400);
    }

    public function show($id)
    {
        $expense = $this->expenseRepository->getExpenseById($id);

        if (!$expense) {
            return response()->json(['message' => 'Expense not found'], 404);
        }

        return response()->json($expense);
    }
}
