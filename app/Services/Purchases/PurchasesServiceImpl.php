<?php


namespace App\Services\Purchases;


use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Services\BaseServiceImpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchasesServiceImpl extends BaseServiceImpl implements PurchasesService
{
    public function __construct(Purchase $model)
    {
        parent::__construct($model);
    }

    public function initPurchase()
    {
        $user = Auth::user();
        return Purchase::where('user_id', $user->id)
            ->where('status', Purchase::STATUS_INIT)
            ->firstOrCreate([
                'user_id' => $user->id,
            ]);
    }

    public function addItem(Purchase $purchase, Request $request)
    {
        return PurchaseItem::updateOrCreate([
            'purchase_id' => $purchase->id,
            'item_id' => $request->input('item_id')
        ],
            $request->toArray()
        );
    }
}
