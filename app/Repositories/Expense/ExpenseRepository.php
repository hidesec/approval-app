<?php

namespace App\Repositories\Expense;

use App\Models\Approval;
use App\Models\ApprovalStage;
use App\Models\Approver;
use App\Models\Expense;

class ExpenseRepository implements ExpenseRepositoryInterface
{
    public function createExpense(array $data)
    {
        return Expense::create($data);
    }

    public function approveExpense(int $id, int $approverId): bool
    {
        $expense = Expense::find($id);
        $approver = Approver::find($approverId);

        if (!$expense || !$approver) {
            return false;
        }

        return $this->canApprove($expense, $approver);
    }

    private function canApprove(Expense $expense, Approver $approver): bool
    {
        $approvalStages = ApprovalStage::get();
        $approvals = Approval::where('expense_id', $expense->id)->get();
        $approvalIds = $approvals->pluck('approver_id')->toArray();

        if ($approvals->isEmpty() && $approvalStages->first()->approver_id === $approver->id) {
            Approval::create([
                'expense_id' => $expense->id,
                'approver_id' => $approver->id,
                'status_id' => 2,
            ]);
            return true;
        }

        if ($approvals->isNotEmpty()) {
            foreach ($approvalStages as $index => $stage) {
                if ($stage->approver_id === $approver->id && !in_array($approver->id, $approvalIds)) {
                    $previousStage = $approvalStages->get($index - 1);
                    if ($previousStage && !in_array($previousStage->approver_id, $approvalIds)) {
                        return false;
                    }

                    Approval::create([
                        'expense_id' => $expense->id,
                        'approver_id' => $approver->id,
                        'status_id' => 2,
                    ]);

                    if ($approvalStages->last()->approver_id == $approver->id) {
                        $expense->status_id = 2;
                        $expense->save();
                        return true;
                    }
                }
            }
        }

        return true;
    }

    public function getExpenseById(int $id)
    {
        $expense = Expense::with(['approvals.approver', 'status'])->find($id);

        if (!$expense) {
            return null;
        }

        return [
            'id' => $expense->id,
            'amount' => $expense->amount,
            'status' => [
                'id' => $expense->status->id,
                'name' => $expense->status->name,
            ],
            'approval' => $expense->approvals->map(function ($approval) {
                return [
                    'id' => $approval->id,
                    'approver' => [
                        'id' => $approval->approver->id,
                        'name' => $approval->approver->name,
                    ],
                    'status' => [
                        'id' => $approval->status->id,
                        'name' => $approval->status->name,
                    ],
                ];
            })->toArray(),
        ];
    }
}
