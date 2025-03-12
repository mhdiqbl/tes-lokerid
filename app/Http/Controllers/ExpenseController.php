<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApprovalExpenseRequest;
use App\Http\Requests\ExpenseRequest;
use App\Models\Expense;
use App\Services\Expense\ExpenseService;


/**
 * @OA\Tag(
 *     name="Expense",
 *     description="API untuk mengelola expense"
 * )
 */
class ExpenseController extends Controller
{
    public function __construct(
        public ExpenseService $expenseService
    )
    {
    }

    /**
     * @OA\Get(
     *     path="/api/expense/{expenseId}",
     *     summary="Get expense by ID",
     *     tags={"Expense"},
     *     description="Mengambil detail expense berdasarkan ID, termasuk status dan approval stages.",
     *     @OA\Parameter(
     *         name="expenseId",
     *         in="path",
     *         required=true,
     *         description="ID dari expense yang ingin diambil",
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data expense",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="meta", type="object",
     *                 @OA\Property(property="code", type="integer", example=200),
     *                 @OA\Property(property="status", type="string", example="success"),
     *                 @OA\Property(property="message", type="string", example="Berhasil ambil data expense")
     *             ),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=9),
     *                 @OA\Property(property="amount", type="string", format="decimal", example="10.00"),
     *                 @OA\Property(property="status", type="object",
     *                     @OA\Property(property="id", type="integer", example=2),
     *                     @OA\Property(property="name", type="string", example="disetujui")
     *                 ),
     *                 @OA\Property(property="approval", type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="approver", type="object",
     *                             @OA\Property(property="id", type="integer", example=3),
     *                             @OA\Property(property="name", type="string", example="xavier")
     *                         ),
     *                         @OA\Property(property="status", type="object",
     *                             @OA\Property(property="id", type="integer", example=2),
     *                             @OA\Property(property="name", type="string", example="disetujui")
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Expense tidak ditemukan",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="meta", type="object",
     *                 @OA\Property(property="code", type="integer", example=404),
     *                 @OA\Property(property="status", type="string", example="error"),
     *                 @OA\Property(property="message", type="string", example="No query results for model [App\\Models\\Expense] 9")
     *             ),
     *             @OA\Property(property="data", type="string", example=null),
     *         )
     *     )
     * )
     */
    public function getExpenseById(int $expenseId)
    {
        return $this->expenseService->getExpenseById($expenseId);
    }

    /**
     * @OA\Post(
     *     path="/api/expense",
     *     summary="Membuat expense baru",
     *     tags={"Expense"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"amount"},
     *             @OA\Property(property="amount", type="number", format="float", example=1000.00),
     *             @OA\Property(property="status_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Expense berhasil dibuat",
     *         @OA\JsonContent(
     *             @OA\Property(property="meta", type="object",
     *                  @OA\Property(property="code", type="integer", example=201),
     *                  @OA\Property(property="status", type="string", example="success"),
     *                  @OA\Property(property="message", type="string", example="Expense created successfully")
     *             ),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="amount", type="number", format="float", example=10.00),
 *                     @OA\Property(property="status_id", type="integer", example=2),
     *                 @OA\Property(property="id", type="integer", example=9)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal",
     *         @OA\JsonContent(
     *             @OA\Property(property="meta", type="object",
     *                  @OA\Property(property="code", type="integer", example=422),
     *                  @OA\Property(property="status", type="string", example="error"),
     *                  @OA\Property(property="message", type="string", example="Validation failed")
     *             ),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function store(ExpenseRequest $request)
    {
        $validateRequest = $request->validated();
        return $this->expenseService->createExpense($validateRequest);
    }

    /**
     * @OA\Post(
     *     path="/api/expense/{expense}/approve",
     *     summary="Meng-approve expense",
     *     tags={"Expense"},
     *     @OA\Parameter(
     *         name="expense",
     *         in="path",
     *         description="ID expense yang akan di-approve",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"approver_id"},
     *             @OA\Property(property="approver_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Approval expense berhasil",
     *         @OA\JsonContent(
     *             @OA\Property(property="meta", type="object",
     *                  @OA\Property(property="code", type="integer", example=200),
     *                  @OA\Property(property="status", type="string", example="success"),
     *                  @OA\Property(property="message", type="string", example="Approval expense berhasil")
     *             ),
     *                  @OA\Property(property="data", type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="amount", type="decimal", example=1),
     *                      @OA\Property(property="status_id", type="integer", example=1),
     *                      @OA\Property(property="approval", type="array",
     *                        @OA\Items(
     *                              type="object",
     *                              @OA\Property(property="id", type="integer", example=1),
     *                              @OA\Property(property="expense_id", type="integer", example=1),
     *                              @OA\Property(property="approver_id", type="integer", example=1),
     *                              @OA\Property(property="status_id", type="integer", example=1),
     *                       )
     *                  )
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Expense tidak ditemukan"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal"
     *     )
     * )
     */
    public function approveExpense(ApprovalExpenseRequest $request, Expense $expense)
    {
        $validateRequest = $request->validated();
        return $this->expenseService->approveExpense($validateRequest, $expense);
    }
}
