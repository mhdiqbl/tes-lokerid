<?php

namespace App\Services\ApprovalStage;

use App\Models\ApprovalStage;

interface ApprovalStageService
{
    public function createApprovalStage(array $request);
    public function updateApprovalStage(array $request, ApprovalStage $approvalStage);
}
