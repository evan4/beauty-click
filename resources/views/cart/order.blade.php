@extends('layouts.home')

@section('content')
<div class="order">
    @php
    $cart = session('cart');
    @endphp
    @if(isset($cart) && !empty($cart['services']))
    <div class="row">
      <div class="col-sm">
          <h4>Оформление заказа</h4>
          <div class="cart-table">
              <div class="overlay">
                <i class="fas fa-spinner fa-spin" style="font-size: 48px;"></i>
              </div>
              <div class="table-responsive">
                <table class="table total-list">
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
                <tr data-id="{{$item['id']}}">
                    <td class="invert-image">
                        <a href="/category/{{$item['category']}}/{{$item['slug']}}">
                            <img src="/images/{{$item['img'] ?? 'no_image.png' }}" 
                            alt="{{$item['title']}}" height="50">
                        </a>
                    </td>
                    <td>{{$item['title']}}</td>
                    <td>
                        <div class="quantity">
                            <div class="btn-group quantity-select" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-light entry value-minus">
                                    <i class="fas fa-minus" style="font-size: 20px;"></i>
                                </button>
                                <button type="button" class="btn btn-light entry value"><span>{{$item['quantity']}}</span></button>
                                <button type="button" class="btn btn-light entry value-plus active">
                                    <i class="fas fa-plus" style="font-size: 20px;"></i>
                                </button>
                            </div>
                        </div>
                    </td>
                    <td class="item-price">{{$item['price']}}</td>
                    <td>
                        <a href="#" data-id="{{$item['id']}}" class="removeItem">
                            <i class="fas fa-trash-alt text-danger"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
          </div>
      </div>
    </div>
    <form action="{{ route('cart.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <h4>Выберите способ доставки</h4>
                    @foreach ($shippings as $key => $shipping)
                    <div class="form-check">
                        @if ($loop->first)
                        <input class="form-check-input" type="radio" name="shipping" 
                            id="shipping-{{$shipping->id}}" value="{{$shipping->id}}" checked>
                        @else
                        <input class="form-check-input" type="radio" name="shipping" 
                        id="shipping-{{$shipping->id}}" value="{{$shipping->id}}">
                        @endif
                        <label class="form-check-label" for="shipping-{{$shipping->id}}">{{$shipping->title}}</label>
                    </div>
                    
                    @endforeach
                </div>
                <div class="form-group">
                    <h4>Выберите способ оплаты</h4>
                    @foreach ($payments as $payment)
                    <div class="form-check">
                        @if ($loop->first)
                        <input class="form-check-input" type="radio" name="payment" 
                            id="payment-{{$payment->id}}" value="{{$payment->id}}" checked>
                        @else
                        <input class="form-check-input" type="radio" name="payment" 
                            id="payment-{{$payment->id}}" value="{{$payment->id}}">
                        @endif
                        <label class="form-check-label" for="payment-{{$payment->id}}">{{$payment->title}}</label>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-6">
                <h4>Укажите детали доставки</h4>
                <div class="form-group">
                    <label for="address">Адрес</label>
                    <input type="text" class="form-control" id="address" name="address">
                    @error('address')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone">Телефон</label>
                    <input type="tel" class="form-control" id="phone" name="phone">
                    @error('phone')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="note">Примечание</label>
                    <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                </div>
            </div>
        </div>
        <div class="row justify-content-end">
            <div class="col-6">
                <table class="table">
                    <tr>
                        <td colspan="4">Итого: </td>
                        <td id="cart-quantity">{{$cart['quantity']}}</td>
                    </tr>
                    <tr>
                        <td colspan="4">На сумму: </td>
                        <td id="cart-total">{{$cart['total']}}</td>
                    </tr>
                </table>
               
                <button type="submit" class="btn btn-primary">Офромить заказ</button>
            </div>
        </div>
        </form>
      
      
    </div>
    @else
        <h3>Корзина пуста</h3>
    @endif
</div>
@endsection
