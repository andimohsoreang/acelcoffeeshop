<?php

namespace Database\Seeders;

use App\Models\BankAccount;
use Illuminate\Database\Seeder;

class BankAccountSeeder extends Seeder
{
    public function run(): void
    {
        $banks = [
            ['bank_name' => 'BCA', 'account_number' => '1234567890', 'account_name' => 'Coffee Shop'],
            ['bank_name' => 'Mandiri', 'account_number' => '0987654321', 'account_name' => 'Coffee Shop'],
            ['bank_name' => 'BRI', 'account_number' => '1122334455', 'account_name' => 'Coffee Shop'],
        ];

        foreach ($banks as $bank) {
            BankAccount::create(array_merge($bank, ['is_active' => true]));
        }
    }
}