<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApprovalStageRequest;
use App\Http\Requests\UpdateApprovalStageRequest;
use App\Models\ApprovalStage;
use App\Repositories\ApprovalStage\ApprovalStageRepositoryInterface;

class ApprovalStageController extends Controller
{
    protected ApprovalStageRepositoryInterface $approvalStageRepository;

    public function __construct(ApprovalStageRepositoryInterface $approvalStageRepository)
    {
        $this->approvalStageRepository = $approvalStageRepository;
    }

    public function storeApprovalStage(ApprovalStageRequest $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validated();
        $approvalStage = $this->approvalStageRepository->createApprovalStage($validatedData);
        return response()->json($approvalStage, 201);
    }

    public function updateApprovalStage(UpdateApprovalStageRequest $request, $id): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validated();
        $approvalStage = $this->approvalStageRepository->updateApprovalStage($id, $validatedData);
        return response()->json($approvalStage, 200);
    }
}
