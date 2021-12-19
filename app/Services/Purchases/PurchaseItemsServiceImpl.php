<?php


namespace App\Services\Purchases;


use App\Models\PurchaseItem;
use App\Services\BaseServiceImpl;

class PurchaseItemsServiceImpl extends BaseServiceImpl implements PurchaseItemsService
{
    public function __construct(PurchaseItem $model)
    {
        parent::__construct($model);
    }

    public function purchaseTotalPrice($purchase_id)
    {
        $items = PurchaseItem::with([])
            ->join('items', 'items.id', '=', 'purchase_item.item_id')
            ->select('items.price', 'purchase_item.count')
            ->where('purchase_id', $purchase_id)
            ->get();

        return $items->map(function ($item) {
            return $item->price * $item->count;
        })->sum();
    }
}
