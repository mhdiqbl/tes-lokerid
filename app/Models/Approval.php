<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Approval",
 *     required={"id", "expense_id", "approver_id", "status_id"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="ID user"
 *     ),
 *     @OA\Property(
 *         property="expense_id",
 *         type="integer",
 *         format="int64",
 *         description="ID expense"
 *     ),
 *     @OA\Property(
 *         property="approver_id",
 *         type="integer",
 *         format="int64",
 *         description="ID approver"
 *     ),
 *     @OA\Property(
 *         property="status_id",
 *         type="integer",
 *         format="int64",
 *         description="ID status"
 *     )
 * )
 */
class Approval extends Model
{
    protected $table = 'approvals';
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at'];

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function approver()
    {
        return $this->belongsTo(Approver::class, 'approver_id', 'id');
    }

    public function expense()
    {
        return $this->hasMany(Expense::class, 'expense_id', 'id');
    }
}
