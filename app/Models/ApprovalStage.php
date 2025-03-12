<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="ApprovalStage",
 *     required={"id", "approver_id"},
 *     description="Schema ApprovalStage mewakili tahap approval pada sistem.",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="ID unik untuk ApprovalStage."
 *     ),
 *     @OA\Property(
 *         property="approver_id",
 *         type="integer",
 *         description="ID dari approver yang terkait dengan tahap approval ini."
 *     )
 * )
 */
class ApprovalStage extends Model
{
    protected $table = 'approval_stages';
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at'];

    public function approver()
    {
        return $this->belongsTo(Approver::class, 'approver_id', 'id');
    }
}
