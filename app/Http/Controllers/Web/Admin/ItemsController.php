<?php


namespace App\Http\Controllers\Web\Admin;


use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Services\Items\ItemsService;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    private $itemsService;

    public function __construct(ItemsService $itemsService) {
        $this->itemsService = $itemsService;
    }

    public function index() {
        if(request()->ajax())
        {
            return datatables()->of(Item::query())
                ->addColumn('edit', function($data){
                    return  '<button
                         class=" btn btn-primary btn-sm btn-block "
                         data-id="'.$data->id.'"
                         onclick="editModel(event.target)">
                         <i class="fas fa-edit" data-id="'.$data->id.'"></i> Изменить</button>';
                })
                ->addColumn('more', function ($data){
                    return '<a
                        class="text-decoration-none"
                        href="'.route('admin.items.show', $data->id).'">
                        <button class="btn btn-primary btn-sm btn-block">Подробнее</button></a>';
                })
                ->rawColumns(['more', 'edit'])
                ->make(true);
        }
        return view('admin.items.index');
    }

    public function show($id) {

    }

    public function store(Request $request) {

    }

    public function edit($id): \Illuminate\Http\JsonResponse
    {
        return $this->itemsService->findJson($id);
    }
}
