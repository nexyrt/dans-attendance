<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Payroll;
use App\Models\PayrollBatch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PayrollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing admin users
        $adminUsers = User::where('role', 'admin')->get();
        if ($adminUsers->isEmpty()) {
            throw new \Exception('No admin users found. Please ensure admin users exist before running this seeder.');
        }

        // Get existing staff users
        $staffUsers = User::whereIn('role', ['staff', 'manager'])->get();
        if ($staffUsers->isEmpty()) {
            throw new \Exception('No staff/manager users found. Please ensure staff users exist before running this seeder.');
        }

        // Create payroll batches for the last 6 months
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $status = $this->determineStatusBasedOnDate($i);

            $batch = PayrollBatch::factory()->create([
                'run_reference' => 'PR-' . $date->format('Ym'),
                'period_start' => $date->copy()->startOfMonth(),
                'period_end' => $date->copy()->endOfMonth(),
                'status' => $status,
                'created_by' => $adminUsers->random()->id,
                'approved_by' => $this->getApprover($status, $adminUsers),
                'processed_at' => $this->getProcessedAt($status),
                'paid_at' => $this->getPaidAt($status),
            ]);

            // Create payrolls for each staff member in this batch
            foreach ($staffUsers as $staff) {
                Payroll::factory()->create([
                    'user_id' => $staff->id,
                    'payroll_batches_id' => $batch->id,
                    'run_reference' => $batch->run_reference,
                    'status' => $this->mapBatchStatusToPayrollStatus($status),
                    'approved_by' => $this->getApprover($status, $adminUsers),
                    'processed_at' => $this->getProcessedAt($status),
                    'paid_at' => $this->getPaidAt($status),
                ]);
            }
        }
    }

     /**
     * Determine batch status based on how recent the month is
     */
    private function determineStatusBasedOnDate(int $monthsAgo): string
    {
        return match(true) {
            $monthsAgo >= 4 => 'paid',
            $monthsAgo === 3 => 'completed',
            $monthsAgo === 2 => 'processing',
            default => 'draft'
        };
    }

    /**
     * Map batch status to payroll status
     */
    private function mapBatchStatusToPayrollStatus(string $batchStatus): string
    {
        return match($batchStatus) {
            'paid' => 'paid',
            'completed', 'processing' => 'processing',
            default => 'draft'
        };
    }

    /**
     * Get approver based on status
     */
    private function getApprover($status, $adminUsers)
    {
        if (in_array($status, ['completed', 'paid'])) {
            return $adminUsers->random()->id;
        }
        return null;
    }

    /**
     * Get processed timestamp based on status
     */
    private function getProcessedAt($status)
    {
        if (in_array($status, ['completed', 'paid', 'processing'])) {
            return now()->subDays(rand(1, 5));
        }
        return null;
    }

    /**
     * Get paid timestamp based on status
     */
    private function getPaidAt($status)
    {
        if ($status === 'paid') {
            return now()->subDays(rand(1, 3));
        }
        return null;
    }
}
