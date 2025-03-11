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

    public function store(ApproverRequest $request)
    {
        $validatedData = $request->validated();

        $approver = $this->approverRepository->create($validatedData);

        return response()->json($approver, 201);
    }
}
