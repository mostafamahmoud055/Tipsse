<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contract;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contracts = [
            [
                'name' => 'Service Agreement',
                'condition' => 'The parties agree to enter into a merchant services relationship whereby the Service Provider agrees to provide payment processing services to the Merchant in accordance with the terms and condition set forth in this agreement.',
            ],
            [
                'name' => 'Payment Processing',
                'condition' => 'The Service Provider shall process all transactions submitted by the Merchant in accordance with applicable payment network rules and regulations. The Merchant is responsible for ensuring compliance with all applicable laws and regulations.',
            ],
            [
                'name' => 'Fees and Charges',
                'condition' => 'The Merchant agrees to pay all applicable fees and charges as outlined in the fee schedule. Fees may include but are not limited to processing fees, monthly minimums, gateway fees, and chargeback fees.',
            ],
            [
                'name' => 'Term and Termination',
                'condition' => 'This agreement shall commence on the date of execution and shall continue for a period of one (1) year, unless earlier terminated. Either party may terminate this agreement upon thirty (30) days written notice to the other party.',
            ],
            [
                'name' => 'Limitation of Liability',
                'condition' => 'In no event shall either party be liable for any indirect, incidental, special, consequential, or punitive damages, regardless of the cause of action or the theory of liability.',
            ],
            [
                'name' => 'Confidentiality',
                'condition' => 'Both parties agree to maintain the confidentiality of all proprietary and sensitive information shared in the course of this business relationship.',
            ],
        ];

        foreach ($contracts as $contract) {
            Contract::create([
                'name' => $contract['name'],
                'condition' => $contract['condition'],
            ]);
        }
    }
}
