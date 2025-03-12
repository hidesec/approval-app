<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApproverRequest;
use App\Repositories\Approver\ApproverRepositoryInterface;

class ApproverController extends Controller
{
    protected ApproverRepositoryInterface $approverRepository;

    public function __construct(ApproverRepositoryInterface $approverRepository)
    {
        $this->approverRepository = $approverRepository;
    }

    /**
     * @OA\PathItem(
     *     path="/api/approvers"
     * )
     * @OA\Post(
     *     path="/api/approvers",
     *     summary="Create Approver",
     *     security={{"jwt_auth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Approver created"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function store(ApproverRequest $request)
    {
        $validatedData = $request->validated();

        $approver = $this->approverRepository->create($validatedData);

        return response()->json($approver, 201);
    }
}
