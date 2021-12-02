@extends('layouts.admin')

@section('content')

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
