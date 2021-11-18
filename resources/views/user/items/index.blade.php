@extends('layouts.admin')

@section('content')

    <div class="card-columns">
        @foreach($items as $item)
            <div class="card     bg-light">
                <div class="card-body">
                    <h5 class="card-title">{{$item->name}}</h5>
                    <p class="card-text">{{$item->description}}</p>
                    <a href="{{route('user.items.show', $item->id)}}" class="btn btn-primary">Show</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
