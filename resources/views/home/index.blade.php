@extends('layouts.home')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <ul class="list-group">
                @foreach ($categories as $category)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="/category/{{$category->slug}}">{{$category->title}}</a>
                    <span class="badge badge-primary badge-pill">{{$category->services->count()}}</span>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
