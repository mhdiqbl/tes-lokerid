<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Expense",
 *     required={"id", "amount", "status"},
 *     description="Schema Expense yang merepresentasikan data pengeluaran.",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="ID unik dari expense."
 *     ),
 *     @OA\Property(
 *         property="amount",
 *         type="number",
 *         format="float",
 *         description="Jumlah uang dalam expense."
 *     ),
 *     @OA\Property(
 *         property="status_id",
 *         type="number",
 *         format="integer",
 *         description="ID Status."
 *     ),
 * )
 */
class Expense extends Model
{
    protected $table = 'expenses';
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at'];

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function approval()
    {
        return $this->hasMany(Approval::class, 'expense_id', 'id');
    }
}
