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

    /**
     * @OA\PathItem(
     *     path="/api/expense"
     * )
     * @OA\Post(
     *     path="/api/expense",
     *     summary="Create Expense",
     *     security={{"jwt_auth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="amount", type="number")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Expense created"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function storeExpense(StoreExpenseRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $expense = $this->expenseRepository->createExpense($validatedData);
        return response()->json($expense, 201);
    }

    /**
     * @OA\PathItem(
     *     path="/api/expense/{id}/approve"
     * )
     * @OA\Patch(
     *     path="/api/expense/{id}/approve",
     *     summary="Approve Expense",
     *     security={{"jwt_auth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="approver_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Expense approved"),
     *     @OA\Response(response=400, description="Expense approval failed"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function approve(ApproveExpenseRequest $request, int $id): JsonResponse
    {
        $approverId = $request->input('approver_id');
        $approved = $this->expenseRepository->approveExpense($id, $approverId);

        if ($approved) {
            return response()->json(['message' => 'Expense approved successfully.'], 200);
        }

        return response()->json(['message' => 'Expense approval failed.'], 400);
    }

    /**
     * @OA\PathItem(
     *     path="/api/expense/{id}"
     * )
     * @OA\Get(
     *     path="/api/expense/{id}",
     *     summary="Get Expense by ID",
     *     security={{"jwt_auth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Successful response"),
     *     @OA\Response(response=404, description="Expense not found"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function show($id)
    {
        $expense = $this->expenseRepository->getExpenseById($id);

        if (!$expense) {
            return response()->json(['message' => 'Expense not found'], 404);
        }

        return response()->json($expense);
    }
}
