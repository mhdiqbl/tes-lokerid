<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Status",
 *     required={"id", "name"},
 *     description="Schema Status yang merepresentasikan status dari sebuah expense atau approval.",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="ID unik dari status."
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Nama status (misalnya: 'Menunggu Persetujuan', 'Disetujui', dll)."
 *     ),
 * )
 */
class Status extends Model
{
    protected $table = 'statuses';
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at'];

    public function expense()
    {
        return $this->hasMany(Expense::class, 'status_id', 'id');
    }

    public function approval()
    {
        return $this->hasMany(Approval::class, 'status_id', 'id');
    }
}
