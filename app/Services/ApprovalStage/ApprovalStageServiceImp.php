<?php

namespace App\Services\ApprovalStage;

use App\Helpers\ResponseFormatter;
use App\Models\ApprovalStage;
use App\Repositories\ApprovalStage\ApprovalStageRepository;
use Exception;

class ApprovalStageServiceImp implements ApprovalStageService
{
    public function __construct(
        public ApprovalStageRepository $approvalStageRepository
    )
    {
    }

    public function createApprovalStage(array $request)
    {
        try {
            $approvalStage = $this->approvalStageRepository->insert($request);
            return ResponseFormatter::success([
                'approval_stage' => $approvalStage,
            ], 'Success create approval stage', 201);
        }catch (Exception $error) {
            report($error);
            return ResponseFormatter::error(null, $error->getMessage(), 500);
        }
    }

    public function updateApprovalStage(array $request, ApprovalStage $approvalStage)
    {
        try {
//            return $request;
            $approvalStage = $this->approvalStageRepository->update($request, $approvalStage);
//            return $approvalStage;
            return ResponseFormatter::success([
                'approval_stage' => $approvalStage,
            ], 'Success update approval stage', 200);
        }catch (Exception $error) {
            report($error);
            return ResponseFormatter::error(null, $error->getMessage(), 500);
        }
    }
}
