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

        $categories = $this->categoriesService->allWith([
            'subcategories' => function ($q) {
                $q->select('id', 'name', 'category_id');
            }
        ]);

        return view('admin.items.index', compact('categories'));
    }

    public function show($id)
    {

    }

    public function store(Request $request)
    {
        $error = Validator::make($request->all(), array(
            'name'          => ['required'],
            'order'         => ['numeric', 'required'],
            'description'   => ['required'],
        ));

        if($error->fails())
            return response()->json(['errors' => $error->errors()->all()]);

        return response()->json([
            'code'=>200,
            'message'=>'Model saved successfully',
            'data' => $this->itemsService->updateOrCreate(['id' => $request->input('id')], $request->toArray())], 200
        );
    }

    public function edit($id): \Illuminate\Http\JsonResponse
    {
        return $this->itemsService->findWithJson($id, ['subcategory']);
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $item = $this->itemsService->delete($id);
        return response()->json([
            'code'      => 200,
            'message'   =>'Model deleted successfully',
            'data'      => $item], 200
        );
    }
}
