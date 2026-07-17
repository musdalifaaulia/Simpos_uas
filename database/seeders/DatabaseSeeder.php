<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Branches
        \App\Models\Branch::factory(3)->create();
        
        // 2. Users (Admin, Superadmin, Cashier)
        \App\Models\User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'role' => 'Superadmin',
            'branch_id' => null,
        ]);
        \App\Models\User::factory(2)->create([
            'role' => 'Admin',
            'branch_id' => 1
        ]);
        \App\Models\User::factory(5)->create([
            'role' => 'Cashier',
            'branch_id' => 1
        ]);

        // 3. Suppliers
        \App\Models\Supplier::factory(5)->create();
        
        // 4. Customers
        \App\Models\Customer::factory(10)->create();
        
        // 5. Categories
        \App\Models\Category::factory(5)->create();
        
        // 6. Products
        \App\Models\Product::factory(20)->create([
            'category_id' => 1,
            'supplier_id' => 1,
        ]);
        
        // 7. Inventories
        \App\Models\Inventory::factory(10)->create([
            'branch_id' => 1,
            'product_id' => 1,
        ]);
        
        // 8. Transactions & Details
        \App\Models\Transaction::factory(10)->create([
            'branch_id' => 1,
            'user_id' => 2, // Admin or cashier
            'customer_id' => 1,
        ])->each(function ($transaction) {
            \App\Models\TransactionDetail::factory(3)->create([
                'transaction_id' => $transaction->id,
                'product_id' => 1,
            ]);
        });
        
        // 9. Stock Transfers
        \App\Models\StockTransfer::factory(5)->create([
            'from_branch_id' => 1,
            'to_branch_id' => 2,
            'product_id' => 1,
        ]);
        
        // 10. Expenses
        \App\Models\Expense::factory(5)->create([
            'branch_id' => 1,
        ]);
        $this->call([
            UserSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
