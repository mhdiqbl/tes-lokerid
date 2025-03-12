<?php

namespace Tests\Feature;

use App\Models\ApprovalStage;
use App\Models\Approver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApprovalStageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->approvers = [
            Approver::create(['name' => 'Ana']),
            Approver::create(['name' => 'Ani']),
            Approver::create(['name' => 'Ina']),
        ];
    }

    /** @test */
    public function create_approval_stages_successfully()
    {
        foreach ($this->approvers as $approver){
            $response = $this->post("api/approval-stages/", [
                'approver_id' => $approver['id'],
            ]);
            $response->assertStatus(201);
        }
    }

    /** @test */
    public function create_approval_stages_is_already()
    {
        $approvalStage = ApprovalStage::create(['approver_id' => $this->approvers[0]['id']]);
        $response = $this->post("api/approval-stages/", [
            'approver_id' => $approvalStage->id,
        ]);
        $response->assertStatus(422)->assertJson([
            'message' => 'The approver id has already been taken.'
        ]);
    }

    /** @test */
    public function edit_approval_stages_successfully()
    {
        $approvalStage = ApprovalStage::create(['approver_id' => $this->approvers[0]['id']]);

        $responseEdit = $this->put("api/approval-stages/$approvalStage->id", [
            'approver_id' => $this->approvers[1]['id'],
        ]);

        $responseEdit->assertStatus(200);
    }

    /** @test */
    public function it_fails_edit_approval_stages_is_already()
    {
        $approvalStage = ApprovalStage::create(['approver_id' => $this->approvers[0]['id']]);

        $responseEdit = $this->put("api/approval-stages/$approvalStage->id", [
            'approver_id' => $this->approvers[0]['id'],
        ]);

        $responseEdit->assertStatus(422)->assertJson([
            'message' => 'The approver id has already been taken.'
        ]);
    }
}
