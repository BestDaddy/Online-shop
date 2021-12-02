<?php


namespace App\Http\Controllers\Web\User;


use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Services\Purchases\PurchasesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchasesController extends Controller
{
    private $purchasesService;

    public function __construct(PurchasesService $purchasesService) {
        $this->purchasesService = $purchasesService;
    }

    public function index()
    {
        $user = Auth::user();
        if(request()->ajax()) {
            return $this->purchasesService->baseDataTables(['user_id' => $user->id]);
        }

        return view('user.purchases.index');
    }

    public function initPurchase(Request $request)
    {
        $purchase = $this->purchasesService->initPurchase();

    }

    public function addItem(Request $request): \Illuminate\Http\JsonResponse
    {
        $purchase = $this->purchasesService->initPurchase();
        $result = $this->purchasesService->addItem($purchase, $request);

        return response()->json([
            'code'      => 200,
            'message'   => 'Model saved successfully',
            'data'      => $result
        ], 200
        );
    }
}
