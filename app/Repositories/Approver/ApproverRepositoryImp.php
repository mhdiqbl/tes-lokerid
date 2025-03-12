<?php

namespace App\Repositories\Approver;

use App\Models\Approver;

class ApproverRepositoryImp implements ApproverRepository
{
    public function __construct(
        public Approver $approver,
    )
    {
    }

    public function insert(array $request)
    {
        return $this->approver->create($request);
    }


}
