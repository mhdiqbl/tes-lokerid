<?php

namespace App\Services\Expense;

use App\Helpers\ResponseFormatter;
use App\Models\ApprovalStage;
use App\Models\Expense;
use App\Models\Status;
use App\Repositories\Approval\ApprovalRepository;
use App\Repositories\ApprovalStage\ApprovalStageRepository;
use App\Repositories\Expense\ExpenseRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class ExpenseServiceimp implements ExpenseService
{
    public function __construct(
        public ExpenseRepository $expenseRepository,
        public ApprovalRepository $approvalRepository,
        public ApprovalStageRepository $approvalStageRepository,
    )
    {
    }

    public function createExpense(array $request)
    {
        try {
            DB::beginTransaction();
            $request['status_id'] = Status::orderBy('id','asc')->first()->id;
            $expense = $this->expenseRepository->insert($request);
            $approvalStage = $this->approvalStageRepository->getApprovalStages();
            $approvalStage->map(function ($apstg) use($expense){
                $this->approvalRepository->insert([
                    'expense_id' => $expense->id,
                    'approver_id' => $apstg->approver_id,
                    'status_id' => 1
                ]);
            });
            DB::commit();
            return ResponseFormatter::success([
                'expense' => $expense,
            ], 'Success create expense', 201);
        }catch (Exception $error) {
            report($error);
            DB::rollBack();
            return ResponseFormatter::error(null, $error->getMessage(), 500);
        }
    }

    public function approveExpense(array $request, Expense $expense)
    {
        try{
            DB::beginTransaction();
            $expenseId = $expense->id;
            $expense = $expense->load('approval');
//            return $expense;
            $approverId = $request['approver_id'];

            // Cari approval milik approver ini
            $approval = $expense->approval()
                ->where('approver_id', $approverId)
                ->first();
//            return $approval;

            if (!$approval) {
                return response()->json(['message' => 'Anda tidak memiliki izin untuk approve.'], 403);
            }

            // Cari urutan approval saat ini
            $currentStage = ApprovalStage::where('approver_id', $approverId)->first();
            if (!$currentStage) {
                return ResponseFormatter::error(null, 'Approver tidak ditemukan dalam tahap approval.', 403);
//                return response()->json(['message' => 'Approver tidak ditemukan dalam tahap approval.'], 403);
            }

            // Cek apakah tahapan sebelumnya sudah disetujui
            $previousStages = ApprovalStage::where('id', '<', $currentStage->id)->pluck('approver_id');
            $pendingApprovals = $expense->approval()
                ->whereIn('approver_id', $previousStages)
                ->where('status_id', '!=', 2) // 2 = Approved
                ->exists();

            if ($pendingApprovals) {
                return ResponseFormatter::error(null, 'Approval belum bisa dilakukan sebelum tahap sebelumnya selesai.', 403);
//                return response()->json(['message' => 'Approval belum bisa dilakukan sebelum tahap sebelumnya selesai.'], 403);
            }

            // Update status approval menjadi "approved"
            $approval->update(['status_id' => 2]); // 2 = Approved

            // Cek apakah semua approver sudah menyetujui
            $remainingApproval = $expense->approval()
                ->where('status_id', '!=', 2) // Belum approved
                ->exists();

            if (!$remainingApproval) {
                // Semua approver sudah approve, ubah status expense menjadi "disetujui"
                $expense->update(['status_id' => 2]);
            }
            DB::commit();
            return ResponseFormatter::success($expense, 'Approval expense berhasil.', 200);
        }catch (Exception $error) {
            report($error);
            DB::rollBack();
            return ResponseFormatter::error(null, $error->getMessage(), 500);
        }
    }

    public function getExpenseById(int $expenseId)
    {
        try{
            $expense = $this->expenseRepository->findById($expenseId);
            return ResponseFormatter::success([
                'id' => $expense->id,
                'amount' => $expense->amount,
                'status' => [
                    'id' => $expense->status->id,
                    'name' => $expense->status->name,
                ],
                'approval' => $expense->approval->map(function ($approval){
                    return [
                        'id' => $approval->id,
                        'approver' => $approval->approver,
                        'status' => $approval->status,
                    ];
                }),
            ], 'Berhasil ambil data expense', 200);
        }catch (Exception $error) {
            report($error);
            DB::rollBack();
            return ResponseFormatter::error(null, $error->getMessage(), 500);
        }
    }


}
