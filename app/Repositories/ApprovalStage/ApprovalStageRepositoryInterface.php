<?php

namespace App\Repositories\ApprovalStage;

interface ApprovalStageRepositoryInterface
{
    public function createApprovalStage(array $data);
    public function updateApprovalStage(int $id, array $data);
}
