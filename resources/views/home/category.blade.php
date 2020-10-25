@extends('layouts.home')

@section('content')
<div class="container">
    <div class="row">
    @if (count($services) > 0)
        @foreach ($services as $service)
        <div class="col-md-3 w3ls_w3l_banner_left">
            <div class="hover14 column">
                <div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid">
                    <div class="agile_top_brand_left_grid_pos"> 
                        <figure>
                            <div class="snipcart-item block">
                                <div class="snipcart-thumb">
                                    <a href="/catalog/{{$service->category}}}/{{$service->service}}}">
                                        @if ($service->img)
                                        <img class="img-responsive" src="/images/{{$service->img}}" alt="{{$service->title}}"> 
                                        @else
                                        <img class="img-responsive" src="/images/no_image.png" alt="{{$service->title}}"> 
                                        @endif                                        </a>
                                    <p>{{$service->title}}</p>
                                    <h4>
                                        <i class="fas fa-ruble-sign" style="font-size: 16px;"></i> {{$service->price}}</h4>                                                                                           </>
                                </div>
                                <div class="snipcart-details">
                                <a class="btn btn-danger btn-block add-to-cart" 
                                    href="#"
                                    data-id="{{$service->id}}">Добавить в корзину</a>                                        </div>
                            </div>
                        </figure>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        
    @else
        <p>В данной категории нет услуг</p>
    @endif
    </div>
    {{ $services->links() }}
</div>
@endsection
