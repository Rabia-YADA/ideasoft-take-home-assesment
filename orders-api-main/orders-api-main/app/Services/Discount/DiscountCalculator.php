<?php

namespace App\Services\Discount;

use App\Models\Order;
use App\Repositories\DiscountRuleRepository;

class DiscountCalculator
{
    public function __construct(
        private DiscountRuleRepository $discountRuleRepo
    ) {}

    public function calculate(Order $order): array
    {
        $discounts = [];
        $subtotal = $order->total;
        $totalDiscount = 0;

        foreach ($this->getStrategies() as $strategy) {
            $result = $strategy->apply($order, $subtotal);

            if (!empty($result['discountAmount'])) {
                $discounts[] = $result;
                $totalDiscount += $result['discountAmount'];
                $subtotal -= $result['discountAmount'];
            }
        }

        return [
            'orderId' => $order->id,
            'discounts' => $discounts,
            'totalDiscount' => number_format($totalDiscount, 2, '.', ''),
            'discountedTotal' => number_format($subtotal, 2, '.', '')
        ];
    }

    private function getStrategies(): array
    {
        return $this->discountRuleRepo->getActiveRules()
            ->map(function ($rule) {
                return new $rule->strategy_class(...array_values($rule->parameters));
            })
            ->toArray();
    }
}
