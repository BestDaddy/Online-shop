<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Services\Items\SubcategoriesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubcategoriesController extends Controller
{
    private $subcategoriesService;

    public function __construct(SubcategoriesService $subcategoriesService) {
        $this->subcategoriesService = $subcategoriesService;
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $error = Validator::make($request->all(), array(
            'name' => ['required'],
            'order'=> ['required'],
            'category_id' => ['required'],
        ));

        if($error->fails())
            return response()->json(['errors' => $error->errors()->all()]);

        $category = $this->subcategoriesService->updateOrCreate(['id' => $request->input('id')], $request->toArray());

        return response()->json(['code'=>200, 'message'=>'Model saved successfully', 'data' => $category], 200);
    }

    public function edit($id): \Illuminate\Http\JsonResponse
    {
        return $this->subcategoriesService->findJson($id);
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $subcategory = $this->subcategoriesService->delete($id);
        return response()->json(['code'=>200, 'message'=>'Model deleted successfully', 'data' => $subcategory], 200);
    }

    public function show($id): \Illuminate\Http\RedirectResponse
    {
        return redirect()->back();
    }

}
