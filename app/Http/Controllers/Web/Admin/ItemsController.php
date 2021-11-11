<?php


namespace App\Http\Controllers\Web\Admin;


use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Services\Items\CategoriesService;
use App\Services\Items\ItemsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemsController extends Controller
{
    private $itemsService;
    private $categoriesService;

    public function __construct(ItemsService $itemsService, CategoriesService $categoriesService) {
        $this->itemsService = $itemsService;
        $this->categoriesService = $categoriesService;
    }

    public function index()
    {
        if(request()->ajax())
            return $this->itemsService->baseDataTables();

        $categories = $this->categoriesService->allWith(['subcategories']);

        return view('admin.items.index', compact('categories'));
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
