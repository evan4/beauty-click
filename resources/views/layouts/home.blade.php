<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <script src="/js/jquery-2.2.2.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/home.js"></script>
    @livewireStyles
</head>

<body>
    @php
    $cart = session('cart');
    @endphp
    <!-- header -->
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
        <form class="form-inline">
            <div class="form-group mb-2">
              <input type="search" readonly class="form-control-plaintext" id="search">
            </div>
        </form>
        <div class="product_list_header">
            <button type="button" class="btn btn-outline-primary" data-toggle="modal" 
            data-target="#cart"><span class="cart-sum">{{$cart['total'] ? $cart['total'] : '0'}}</span></button>
        </div>
    </div>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
        
        <h5 class="my-0 mr-md-auto font-weight-normal"> <a href="/">Beauty click</a></h5>
        <nav class="my-2 my-md-0 mr-md-3">
            <a class="p-2 text-dark" href="/features">Features</a>
            <a class="p-2 text-dark" href="#">Enterprise</a>
            <a class="p-2 text-dark" href="#">Support</a>
            <a class="p-2 text-dark" href="#">Pricing</a>
        </nav>
        @if (Route::has('login'))
        @auth
        <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 underline">Dashboard</a>
        @else
        <a href="{{ route('login') }}" class="btn btn-outline-primary">Login</a>

        @if (Route::has('register'))
        <a href="{{ route('register') }}" class="btn btn-outline-primary">Register</a>
        @endif
        @endif
        @endif
    </div>
    <div class="container">
        @yield('content')
    </div>
    <!-- Modal -->
    <div class="modal fade" id="cart" tabindex="-1" role="dialog" 
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Корзина</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                @if(isset($cart) && !empty($cart['services']))
                
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>Фото</th>
                            <th>Наименование</th>
                            <th>Кол-во</th>
                            <th>Цена</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($cart['services'] as $id => $item)
                        <tr>
                            <td>
                                <img src="/images/{{$item['img'] ?? 'no_image.png' }}" 
                                alt="{{$item['title']}}" height="50">
                            </td>
                            <td>{{$item['title']}}</td>
                            <td>{{$item['quantity']}}</td>
                            <td>{{$item['price']}}</td>
                            <td>
                                <a href="#" data-id="{{$item['id']}}" class="del-item">
                                    <i class="fas fa-trash-alt text-danger"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="4">Итого: </td>
                        <td id="cart-qty">{{$cart['quantity']}}</td>
                        </tr>
                        <tr>
                            <td colspan="4">На сумму: </td>
                            <td id="cart-sum">{{$cart['total']}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                @else
                <p>Корзина пуста</p>
                @endif
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Продолжить покупки</button>
            <a href="/cart/order" role="button" class="btn btn-success">ОФормить заказ</a>
            <button type="button" id="clearCart" class="btn btn-danger">Очистить корзину</button>
            </div>
        </div>
        </div>
    </div>
</body>

</html>