<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Services\Items\CategoriesService;
use App\Services\Items\SubcategoriesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    private $categoriesService;
    private $subcategoriesService;

    public function __construct(CategoriesService $categoriesService, SubcategoriesService $subcategoriesService) {
        $this->categoriesService = $categoriesService;
        $this->subcategoriesService = $subcategoriesService;
    }

    public function index()
    {
        return $this->categoriesService->baseDataTables();
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $error = Validator::make($request->all(), array(
            'name' => ['required'],
            'order'=> ['required'],
        ));

        if($error->fails())
            return response()->json(['errors' => $error->errors()->all()]);

        $category = $this->categoriesService->updateOrCreate(['id' => $request->input('id')], $request->toArray());

        return response()->json(['code'=>200, 'message'=>'Model saved successfully', 'data' => $category], 200);
    }

    public function edit($id): \Illuminate\Http\JsonResponse
    {
        return $this->categoriesService->findJson($id);
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $category = $this->categoriesService->delete($id);
        return response()->json(['code'=>200, 'message'=>'Model deleted successfully', 'data' => $category], 200);
    }

    public function show($id)
    {
        return $this->subcategoriesService->baseDataTables(['category_id' => $id]);
    }

    public function categoriesWithSubcategories()
    {
        return $this->categoriesService->allWith([
            'subcategories' => function ($q) {
                $q->select('id', 'name', 'category_id');
            },
        ]);
    }
}
