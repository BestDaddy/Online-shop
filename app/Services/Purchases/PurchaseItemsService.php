<?php


namespace App\Services\Purchases;


interface PurchaseItemsService
{
    public function purchaseTotalPrice($purchase_id);
}
