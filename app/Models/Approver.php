<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Approver",
 *     required={"id", "name"},
 *     description="Schema Approver yang mewakili data penyetuju dalam sistem.",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="ID unik dari approver."
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Nama dari approver."
 *     )
 * )
 */
class Approver extends Model
{
    protected $table = 'approvers';
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at'];

    public function approvalStage()
    {
        return $this->hasMany(ApprovalStage::class, 'approver_id', 'id');
    }

    public function approval()
    {
        return $this->hasMany(Approval::class, 'expense_id', 'id');
    }
}
