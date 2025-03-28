<?php

namespace Database\Seeders;

use App\Models\Discount;
use Illuminate\Database\Seeder;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Discount::create([
            'name' => '10% over 1000 TL',
            'strategy_class' => \App\Services\Discount\Strategies\TotalAmountDiscount::class,
            'parameters' => ['threshold' => 1000, 'percentage' => 10],
            'priority' => 3,
        ]);

        Discount::create([
            'name' => 'Buy 5 Get 1 Free (Category 2)',
            'strategy_class' => \App\Services\Discount\Strategies\CategoryQuantityDiscount::class,
            'parameters' => ['categoryId' => 2, 'buyQuantity' => 6, 'freeQuantity' => 1],
            'priority' => 2,
        ]);

        Discount::create([
            'name' => '20% Cheapest Item (Category 1)',
            'strategy_class' => \App\Services\Discount\Strategies\CheapestItemDiscount::class,
            'parameters' => ['categoryId' => 1, 'minQuantity' => 2, 'discountPercentage' => 20],
            'priority' => 1,
        ]);
    }
}
