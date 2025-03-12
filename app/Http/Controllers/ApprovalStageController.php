<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApprovalStageRequest;
use App\Models\ApprovalStage;
use App\Services\ApprovalStage\ApprovalStageService;

/**
 * @OA\Tag(
 *     name="Approval Stages",
 *     description="API untuk mengelola approval stages"
 * )
 */

class ApprovalStageController extends Controller
{
    public function __construct(
        public ApprovalStageService $approvalStageService,
    )
    {
    }

    /**
     * @OA\Post(
     *     path="/api/approval-stages",
     *     summary="Menambahkan approval stage baru",
     *     tags={"Approval Stages"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"approver_id"},
     *             @OA\Property(property="approver_id", type="integer", example=1, description="ID approver yang bertanggung jawab")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Success create approval stage",
     *         @OA\JsonContent(
     *             type="object",
     *            @OA\Property(property="meta", type="object",
     *                @OA\Property(property="code", type="integer", example=200),
     *                @OA\Property(property="status", type="string", example="success"),
     *                @OA\Property(property="message", type="string", example="Success create approval stage")
     *             ),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="approver_id", type="integer", example=1),
     *                 @OA\Property(property="id", type="integer", example=1)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal"
     *     )
     * )
     */
    public function store(ApprovalStageRequest $request)
    {
        $validateRequest = $request->validated();
        return $this->approvalStageService->createApprovalStage($validateRequest);
    }

    /**
     * @OA\Put(
     *     path="/api/approval-stages/{id}",
     *     summary="Memperbarui approval stage yang ada",
     *     tags={"Approval Stages"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID approval stage yang ingin diperbarui",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"approver_id"},
     *             @OA\Property(property="approver_id", type="integer", example=2, description="ID approver yang diperbarui")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Approval stage berhasil diperbarui",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="meta", type="object",
     *                 @OA\Property(property="code", type="integer", example=200),
     *                 @OA\Property(property="status", type="string", example="success"),
     *                 @OA\Property(property="message", type="string", example="Success update approval stage")
     *             ),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="approval_stage", type="boolean", example=true)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal"
     *     )
     * )
     */

    public function update(ApprovalStageRequest $request, ApprovalStage $approvalStage)
    {
        $validateRequest = $request->validated();
        return $this->approvalStageService->updateApprovalStage($validateRequest, $approvalStage);
    }
}
