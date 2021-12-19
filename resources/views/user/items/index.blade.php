@extends('layouts.admin')

@section('content')
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
{{--            <a class="navbar-brand" href="#">Navbar</a>--}}
{{--            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">--}}
{{--                <span class="navbar-toggler-icon"></span>--}}
{{--            </button>--}}
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{route('user.items.index')}}">Все товары</a>
                    </li>
                    @foreach($categories as $category)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">{{$category->name}}<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                @foreach($category->subcategories as $subcategory)
                                    <li><a href="{{route('user.items.subcategory', $subcategory->id)}}">{{$subcategory->name . ' ' . $subcategory->items_count}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>

    <div class="card-columns">
        @foreach($items as $item)
            <div class="card bg-light" style="width:400px">
                <div class="card-header">
                    <p class="card-text">{{$item->created_at->diffForHumans()}}</p>
                </div>
                <div class="card-body">
                    <img class="card-img-top img-fluid" src="{{$item->image ?? 'https://aseshop.kz/uploads/default/no-image.jpg'}}" alt="Card image">
                    <h5 class="card-title">{{$item->name}}</h5>
                    <p class="card-text">{{substr($item->description, 0, 100)}}</p>
                    <div class="row">
                        <div class="col">
                            <a href="{{route('user.items.show', $item->id)}}" class="btn btn-primary">Show</a>
                        </div>
                        <div class="col">
                            <label>{{$item->price}} KZT</label>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
