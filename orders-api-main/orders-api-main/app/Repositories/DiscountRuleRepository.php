<?php

namespace App\Repositories;

use App\Models\Discount;
class DiscountRuleRepository
{
    public function getActiveRules()
    {
        return Discount::active()->ordered()->get();
    }
}
