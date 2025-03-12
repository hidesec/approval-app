<?php

namespace App\Repositories\Approver;

use App\Models\Approver;

class ApproverRepository implements ApproverRepositoryInterface
{
    public function create(array $data)
    {
        return Approver::create($data);
    }
}
