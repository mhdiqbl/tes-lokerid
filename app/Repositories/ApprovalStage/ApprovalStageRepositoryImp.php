<?php

namespace App\Repositories\ApprovalStage;

use App\Models\ApprovalStage;

class ApprovalStageRepositoryImp implements ApprovalStageRepository
{
    public function __construct(
        public ApprovalStage $approvalStage
    )
    {
    }

    public function insert(array $request)
    {
        return $this->approvalStage->create($request);
    }

    public function update(array $request, ApprovalStage $approvalStage)
    {
        return $approvalStage->update($request);
    }

    public function getApprovalStages()
    {
        return $this->approvalStage->newQuery()
            ->orderBy('id', 'asc')->get();
    }

}
