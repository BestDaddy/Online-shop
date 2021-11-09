<?php


namespace App\Http\Controllers\Web\Admin;


use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Services\Items\ItemsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemsController extends Controller
{
    private $itemsService;

    public function __construct(ItemsService $itemsService) {
        $this->itemsService = $itemsService;
    }

    public function index()
    {
        return $this->itemsService->datatables(Item::TABLE_NAME);
    }

    public function show($id)
    {

    }

    public function store(Request $request)
    {
        $error = Validator::make($request->all(), array(
//            'first_name'=> ['required'],
//            'phone'     => ['numeric', 'unique:users', 'required'],
//            'email'     => ['nullable','email', 'unique:users',],
//            'nickname'  => ['nullable|unique:users,nickname'],
//            'role_id'   => ['required'],
        ));

        if($error->fails())
            return response()->json(['errors' => $error->errors()->all()]);

        return  $this->itemsService->updateOrCreate(['id' => $request->input('id')], $request->toArray());
    }

    public function edit($id): \Illuminate\Http\JsonResponse
    {
        return $this->itemsService->findJson($id);
    }
}
