<?php

namespace App\Repositories\ApprovalStage;

use App\Models\ApprovalStage;

interface ApprovalStageRepository
{
    public function insert(array $request);
    public function update(array $request, ApprovalStage $approvalStage);

    public function getApprovalStages();
}
