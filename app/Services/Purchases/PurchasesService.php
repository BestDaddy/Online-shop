<?php


namespace App\Services\Purchases;


use App\Models\Purchase;
use Illuminate\Http\Request;

interface PurchasesService
{
    public function initPurchase();

    public function addItem(Purchase $purchase, Request $request);
}
