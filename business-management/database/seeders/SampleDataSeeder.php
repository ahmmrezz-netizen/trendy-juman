<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Client;
use App\Models\Purchase;
use App\Models\User;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        // Create sample products
        $products = [
            ['name' => 'Classic T-Shirt', 'size' => 'M', 'color' => 'Black', 'available_qty' => 50],
            ['name' => 'Classic T-Shirt', 'size' => 'L', 'color' => 'Black', 'available_qty' => 45],
            ['name' => 'Classic T-Shirt', 'size' => 'XL', 'color' => 'Black', 'available_qty' => 30],
            ['name' => 'Classic T-Shirt', 'size' => 'M', 'color' => 'White', 'available_qty' => 40],
            ['name' => 'Classic T-Shirt', 'size' => 'L', 'color' => 'White', 'available_qty' => 35],
            ['name' => 'Classic T-Shirt', 'size' => 'XL', 'color' => 'White', 'available_qty' => 25],
            ['name' => 'Denim Jeans', 'size' => '30', 'color' => 'Blue', 'available_qty' => 20],
            ['name' => 'Denim Jeans', 'size' => '32', 'color' => 'Blue', 'available_qty' => 25],
            ['name' => 'Denim Jeans', 'size' => '34', 'color' => 'Blue', 'available_qty' => 20],
            ['name' => 'Denim Jeans', 'size' => '36', 'color' => 'Blue', 'available_qty' => 15],
            ['name' => 'Hoodie', 'size' => 'S', 'color' => 'Gray', 'available_qty' => 30],
            ['name' => 'Hoodie', 'size' => 'M', 'color' => 'Gray', 'available_qty' => 35],
            ['name' => 'Hoodie', 'size' => 'L', 'color' => 'Gray', 'available_qty' => 30],
            ['name' => 'Hoodie', 'size' => 'XL', 'color' => 'Gray', 'available_qty' => 25],
            ['name' => 'Sneakers', 'size' => '7', 'color' => 'White', 'available_qty' => 15],
            ['name' => 'Sneakers', 'size' => '8', 'color' => 'White', 'available_qty' => 20],
            ['name' => 'Sneakers', 'size' => '9', 'color' => 'White', 'available_qty' => 18],
            ['name' => 'Sneakers', 'size' => '10', 'color' => 'White', 'available_qty' => 12],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        // Create sample clients
        $clients = [
            ['name' => 'John Doe', 'email' => 'john@example.com', 'phone' => '+1234567890'],
            ['name' => 'Jane Smith', 'email' => 'jane@example.com', 'phone' => '+1234567891'],
            ['name' => 'Mike Johnson', 'email' => 'mike@example.com', 'phone' => '+1234567892'],
            ['name' => 'Sarah Wilson', 'email' => 'sarah@example.com', 'phone' => '+1234567893'],
            ['name' => 'David Brown', 'email' => 'david@example.com', 'phone' => '+1234567894'],
            ['name' => 'Lisa Davis', 'email' => 'lisa@example.com', 'phone' => '+1234567895'],
            ['name' => 'Tom Miller', 'email' => 'tom@example.com', 'phone' => '+1234567896'],
            ['name' => 'Emily Taylor', 'email' => 'emily@example.com', 'phone' => '+1234567897'],
        ];

        foreach ($clients as $clientData) {
            Client::create($clientData);
        }

        // Create sample purchases
        $purchases = [
            ['client_id' => 1, 'product_id' => 1, 'qty' => 2, 'purchase_date' => '2025-08-20'],
            ['client_id' => 1, 'product_id' => 4, 'qty' => 1, 'purchase_date' => '2025-08-20'],
            ['client_id' => 2, 'product_id' => 2, 'qty' => 1, 'purchase_date' => '2025-08-21'],
            ['client_id' => 2, 'product_id' => 7, 'qty' => 1, 'purchase_date' => '2025-08-21'],
            ['client_id' => 3, 'product_id' => 11, 'qty' => 1, 'purchase_date' => '2025-08-22'],
            ['client_id' => 4, 'product_id' => 15, 'qty' => 1, 'purchase_date' => '2025-08-22'],
            ['client_id' => 5, 'product_id' => 3, 'qty' => 2, 'purchase_date' => '2025-08-23'],
            ['client_id' => 6, 'product_id' => 8, 'qty' => 1, 'purchase_date' => '2025-08-23'],
            ['client_id' => 7, 'product_id' => 12, 'qty' => 1, 'purchase_date' => '2025-08-24'],
            ['client_id' => 8, 'product_id' => 16, 'qty' => 1, 'purchase_date' => '2025-08-24'],
        ];

        foreach ($purchases as $purchaseData) {
            Purchase::create($purchaseData);
        }

        // Update product stock after purchases
        foreach ($purchases as $purchaseData) {
            $product = Product::find($purchaseData['product_id']);
            $product->decrement('available_qty', $purchaseData['qty']);
        }
    }
}
