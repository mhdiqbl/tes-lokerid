<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApproverTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function create_approver_successfully()
    {
        $approvers = [
            "Ana","Ani","Ina"
        ];
        foreach ($approvers as $approver){
            $response = $this->post("api/approvers/", [
                'name' => $approver
            ]);
            $response->assertStatus(201);
        }
    }
}
