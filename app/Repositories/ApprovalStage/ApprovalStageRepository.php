<?php

namespace App\Repositories\ApprovalStage;

use App\Models\ApprovalStage;

class ApprovalStageRepository implements ApprovalStageRepositoryInterface
{
    public function createApprovalStage(array $data)
    {
        return ApprovalStage::create($data);
    }

    public function updateApprovalStage(int $id, array $data)
    {
        $approvalStage = ApprovalStage::findOrFail($id);
        $approvalStage->update($data);
        return $approvalStage;
    }
}
