<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ExpenseTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Route::middlewareGroup('jwt.auth', []);
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
    }

    public function test_expense_approval_scenarios()
    {
        // 1. Buat Approver
        $approverNames = ['Ana', 'Ani', 'Ina'];
        $approverIds = [];

        foreach ($approverNames as $name) {
            $response = $this->postJson('/api/approvers', ['name' => $name])
                ->dump()
                ->assertStatus(201);
            error_log($name);
            $approverIds[] = $response['id'];
            error_log($response['id']);
        }
        error_log($approverIds);

        $this->assertCount(3, $approverIds);

        // 2. Buat Approval Stages
        foreach ($approverIds as $id) {
            $this->postJson('/approval-stages', ['approver_id' => $id])
                ->assertStatus(201);
        }

        // 3. Buat Pengeluaran
        $expenseAmounts = [100, 200, 300, 400];
        $expenseIds = [];

        foreach ($expenseAmounts as $amount) {
            $response = $this->postJson('/expense', ['amount' => $amount])
                ->assertStatus(201);
            $expenseIds[] = $response['id'];
        }

        $this->assertCount(4, $expenseIds);

        // 4. Setujui Pengeluaran Sesuai Skenario
        // Pengeluaran 1: Disetujui semua
        foreach ($approverIds as $approverId) {
            $this->patchJson("/expense/{$expenseIds[0]}/approve", ['approver_id' => $approverId])
                ->assertStatus(200);
        }

        // Pengeluaran 2: Disetujui oleh 2 approver
        foreach (array_slice($approverIds, 0, 2) as $approverId) {
            $this->patchJson("/expense/{$expenseIds[1]}/approve", ['approver_id' => $approverId])
                ->assertStatus(200);
        }

        // Pengeluaran 3: Disetujui oleh 1 approver
        $this->patchJson("/expense/{$expenseIds[2]}/approve", ['approver_id' => $approverIds[0]])
            ->assertStatus(200);

        // 5. Pastikan Status Pengeluaran
        $this->getJson("/expense/{$expenseIds[0]}")
            ->assertJson(['status' => 'approved']);

        $this->getJson("/expense/{$expenseIds[1]}")
            ->assertJson(['status' => 'pending']);

        $this->getJson("/expense/{$expenseIds[2]}")
            ->assertJson(['status' => 'pending']);

        $this->getJson("/expense/{$expenseIds[3]}")
            ->assertJson(['status' => 'pending']);
    }
}
