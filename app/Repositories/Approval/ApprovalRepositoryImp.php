<?php

namespace App\Repositories\Approval;

use App\Models\Approval;

class ApprovalRepositoryImp implements ApprovalRepository
{
    public function __construct(
        public Approval $approval
    )
    {
    }

    public function insert(array $request)
    {
        return $this->approval->create($request);
    }


}
