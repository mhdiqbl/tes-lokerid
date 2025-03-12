<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApproverRequest;
use App\Services\Approver\ApproverService;

/**
 * @OA\Tag(
 *     name="Approvers",
 *     description="API untuk mengelola approvers"
 * )
 */
class ApproverController extends Controller
{
    public function __construct(
        public ApproverService $approverService,
    )
    {
    }

    /**
     * @OA\Post(
     *     path="/api/approvers",
     *     summary="Membuat approver baru",
     *     tags={"Approvers"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="John Doe")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Success create approver",
     *         @OA\JsonContent(
     *                  type="object",
     *                  @OA\Property(property="meta", type="object",
     *                      @OA\Property(property="code", type="integer", example=200),
     *                      @OA\Property(property="status", type="string", example="success"),
     *                      @OA\Property(property="message", type="string", example="Berhasil ambil data expense")
     *              ),
     *                  @OA\Property(property="data", type="object",
     *                      @OA\Property(property="name", type="string", example="John Doe"),
     *                      @OA\Property(property="id", type="integer", example=1)
     *              ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The name field is required."),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function store(ApproverRequest $request)
    {
        $validateRequest = $request->validated();
        return $this->approverService->createApprover($validateRequest);
    }
}
