<?php

namespace Tests\Feature;

use App\Models\Approval;
use App\Models\ApprovalStage;
use App\Models\Approver;
use App\Models\Expense;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExpenseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->statuses = [
            Status::create(['name' => 'menunggu persetujuan']),
            Status::create(['name' => 'disetujui']),
        ];

        $this->approvers = [
            'ana' => Approver::create(['name' => 'Ana']),
            'ani' => Approver::create(['name' => 'Ani']),
            'ina' => Approver::create(['name' => 'Ina']),
        ];

        foreach ($this->approvers as $approver) {
            ApprovalStage::create(['approver_id' => $approver->id]);
        }

        for ($i = 0; $i < 4; $i++) {
            Expense::create([
                'amount' => 1000 * ($i + 1),
                'status_id' => $this->statuses[1]->id,
            ]);
        }
    }

    /** @test */
    public function it_approves_expenses_correctly()
    {
        $expenses = Expense::all();

        foreach ($this->approvers as $approver) {
            Approval::create([
                'expense_id' => $expenses[0]->id,
                'approver_id' => $approver->id,
                'status_id' => $this->statuses[0]->id,
            ]);
        }
        $expenses[0]->update(['status_id' => $this->statuses[0]->id]);

        Approval::create([
            'expense_id' => $expenses[1]->id,
            'approver_id' => $this->approvers['ana']->id,
            'status_id' => $this->statuses[0]->id,
        ]);
        Approval::create([
            'expense_id' => $expenses[1]->id,
            'approver_id' => $this->approvers['ani']->id,
            'status_id' => $this->statuses[0]->id,
        ]);

        Approval::create([
            'expense_id' => $expenses[2]->id,
            'approver_id' => $this->approvers['ana']->id,
            'status_id' => $this->statuses[0]->id,
        ]);

        $this->assertEquals($this->statuses[0]->id, $expenses[0]->refresh()->status_id); // Pengeluaran pertama disetujui
        $this->assertEquals($this->statuses[1]->id, $expenses[1]->refresh()->status_id); // Pengeluaran kedua masih pending
        $this->assertEquals($this->statuses[1]->id, $expenses[2]->refresh()->status_id); // Pengeluaran ketiga masih pending
        $this->assertEquals($this->statuses[1]->id, $expenses[3]->refresh()->status_id); // Pengeluaran keempat masih pending
    }

    /** @test */
    public function get_expense_successfully()
    {
        $expense = Expense::create([
            'amount' => 10000,
            'status_id' => $this->statuses[0]['id'],
        ]);

        $response = $this->get("api/expense/$expense->id", [
            'Accept' => 'application/json'
        ]);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'meta' => [
                    'code',
                    'status',
                    'message',
                ],
                'data' => [
                    'id',
                    'amount',
                    'status' => [
                        'id',
                        'name',
                    ],
                    'approval' => [
                        '*' => [
                            'id',
                            'approver' => [
                                'id',
                                'name',
                            ],
                            'status' => [
                                'id',
                                'name',
                            ],
                        ],
                    ],
                ],
            ]);
    }
}
