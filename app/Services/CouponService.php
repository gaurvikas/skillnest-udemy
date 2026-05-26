<?php

namespace App\Services;

use App\Models\Coupon;
use Exception;

class CouponService
{
    /**
     * Create a new class instance.
     */
    public function create($data)
    {
        try {
            $user = Coupon::create($data);

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
