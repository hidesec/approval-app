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

    /**
     * @OA\PathItem(
     *     path="/api/approval-stages"
     * )
     * @OA\Post(
     *     path="/api/approval-stages",
     *     summary="Create Approval Stage",
     *     security={{"jwt_auth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Approval stage created"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function storeApprovalStage(ApprovalStageRequest $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validated();
        $approvalStage = $this->approvalStageRepository->createApprovalStage($validatedData);
        return response()->json($approvalStage, 201);
    }

    /**
     * @OA\PathItem(
     *     path="/api/approval-stages/{id}"
     * )
     * @OA\Put(
     *     path="/api/approval-stages/{id}",
     *     summary="Update Approval Stage",
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
     *             @OA\Property(property="name", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Approval stage updated"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function updateApprovalStage(UpdateApprovalStageRequest $request, $id): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validated();
        $approvalStage = $this->approvalStageRepository->updateApprovalStage($id, $validatedData);
        return response()->json($approvalStage, 200);
    }
}
