<?php


namespace App\Http\Controllers\Web\User;


use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Services\Purchases\PurchaseItemsService;
use App\Services\Purchases\PurchasesService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PurchasesController extends Controller
{
    private $purchasesService;
    private $purchaseItemsService;

    public function __construct(PurchasesService $purchasesService, PurchaseItemsService $purchaseItemsService) {
        $this->purchasesService     = $purchasesService;
        $this->purchaseItemsService = $purchaseItemsService;
    }

    public function index()
    {

    }

}
