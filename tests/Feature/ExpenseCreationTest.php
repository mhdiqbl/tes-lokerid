<?php

namespace Tests\Feature;

use App\Models\ApprovalStage;
use App\Models\Approver;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpenseCreationTest extends TestCase
{
    use RefreshDatabase;

    protected $statuses;
    protected $approvers;

    protected function setUp(): void
    {
        parent::setUp();

        $this->statuses = [
            Status::create(['name' => 'Menunggu Persetujuan']),
            Status::create(['name' => 'Disetujui']),
        ];
    }

    /** @test */
    public function create_expense_successfully()
    {
        $response = $this->post("api/expense/", [
            'amount' => 10000
        ]);
        $response->assertStatus(201);
    }
}
