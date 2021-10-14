<?php


namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Services\Items\ItemsService;

class ItemsController extends Controller
{
    private $itemsService;

    public function __construct(ItemsService $itemsService) {
        $this->itemsService = $itemsService;
    }

    public function index() {
        if(request()->ajax())
        {
            return datatables()->of(Item::all())
//                ->addColumn('edit', function($data){
//                    return  '<button
//                         class=" btn btn-primary btn-sm btn-block "
//                          data-id="'.$data->id.'"
//                          onclick="editUser(event.target)"><i class="fas fa-edit" data-id="'.$data->id.'"></i> Изменить</button>';
//                })
//                ->addColumn('more', function ($data){
//                    return '<a class="text-decoration-none"  href="/cars/'.$data->id.'"><button class="btn btn-primary btn-sm btn-block">Подробнее</button></a>';
//                })
//                ->rawColumns(['more', 'edit'])
                ->make(true);
        }
        return view('admin.items.index');


        $items = $this->itemsService->all();

        return view('test', compact('items'));
    }
}
