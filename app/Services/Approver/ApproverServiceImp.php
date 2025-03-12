<?php

namespace App\Services\Approver;

use App\Helpers\ResponseFormatter;
use App\Repositories\Approver\ApproverRepository;
use Exception;

class ApproverServiceImp implements ApproverService
{
    public function __construct(
        public ApproverRepository $approverRepository,
    )
    {
    }

    public function createApprover(array $request)
    {
        try {
            $approver = $this->approverRepository->insert($request);

            return ResponseFormatter::success([
                'approver' => $approver,
            ], 'Success create approver', 201);
        }catch (Exception $error) {
            report($error);
            return ResponseFormatter::error(null, $error->getMessage(), 500);
        }
    }


}
