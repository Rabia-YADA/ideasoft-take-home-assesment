<?php

namespace App\Http\Controllers;
use App\Repositories\DiscountRuleRepository;
use App\Services\Discount\DiscountCalculator;
use App\Models\Order;
use Illuminate\Http\JsonResponse;

class DiscountController extends Controller
{

    public function __construct(
        private DiscountCalculator $discountCalculator,
        private DiscountRuleRepository $discountRuleRepo
    ) {
    }

    public function calculateDiscounts(int $orderId): JsonResponse
    {
        $order = Order::with(['items', 'items.product'])
            ->findOrFail($orderId);

        return response()->json(
            $this->discountCalculator->calculate($order)
        );
    }
}
