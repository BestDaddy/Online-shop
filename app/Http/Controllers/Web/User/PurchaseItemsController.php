<?php


namespace App\Http\Controllers\Web\User;


use App\Http\Controllers\Controller;
use App\Models\PurchaseItem;
use App\Services\Purchases\PurchaseItemsService;
use App\Services\Purchases\PurchasesService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PurchaseItemsController extends Controller
{
    private $purchasesService;
    private $purchaseItemsService;

    public function __construct(PurchasesService $purchasesService, PurchaseItemsService $purchaseItemsService) {
        $this->purchasesService     = $purchasesService;
        $this->purchaseItemsService = $purchaseItemsService;
    }

    public function index()
    {
        $purchase = $this->purchasesService->initPurchase();

        if(request()->ajax()) {
            return datatables()->of(
                PurchaseItem::query()
                    ->with(['item' => function($q) {
                        $q->select('id', 'name', 'price');
                    }])
                    ->where('purchase_id', $purchase->id))
                ->editColumn('created_at', function ($data) {
                    return Carbon::parse($data->created_at)->format('d.m.Y H:i');
                })
                ->addColumn('edit', function($data){
                    return  '<button
                        class=" btn btn-primary btn-sm btn-block "
                        data-id="'.$data->id.'"
                        onclick="editModel(event.target)">
                        <i class="fas fa-edit" data-id="'.$data->id.'"></i> Изменить</button>';
                })
                ->rawColumns(['edit'])
                ->make(true);
        }

        return view('user.purchases.index',);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $error = Validator::make($request->all(), array(
            'item_id' => ['required'],
        ));

        if($error->fails())
            return response()->json(['errors' => $error->errors()->all()]);

        $purchase = $this->purchasesService->initPurchase();
        $result = $this->purchasesService->addItem($purchase, $request);

        return response()->json([
            'code'      => 200,
            'message'   => 'Model saved successfully',
            'data'      => $result
        ], 200
        );
    }

    public function edit($id): \Illuminate\Http\JsonResponse
    {
        return $this->purchaseItemsService->findWithJson($id, ['item']);
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $item = $this->purchaseItemsService->delete($id);
        return response()->json([
            'code'      => 200,
            'message'   =>'Model deleted successfully',
            'data'      => $item], 200
        );
    }

    public function totalPrice(): \Illuminate\Http\JsonResponse
    {
        $purchase = $this->purchasesService->initPurchase();
        return response()->json($this->purchaseItemsService->purchaseTotalPrice($purchase->id), 200);
    }
}
