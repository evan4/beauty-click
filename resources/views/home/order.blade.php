@extends('layouts.home')

@section('content')
<div class="container">
    <div class="row">
      @php
      $cart = session('cart');
      @endphp
      @if(isset($cart))
      <div class="checkout-right">
          <h4>Your shopping cart contains: <span>{{$cart['quantity']}} Product(s)</span></h4>
          <div class="cart-table">
              <div class="overlay">
                  <i class="fa fa-refresh fa-spin"></i>
              </div>
              <table class="timetable_sub">
              <thead>
              <tr>
                  <th>SL No.</th>
                  <th>Product</th>
                  <th>Quantity</th>
                  <th>Product Name</th>
                  <th>Price</th>
                  <th>Remove</th>
              </tr>
              </thead>
              <tbody>
              @php
              $i= 1;
              @endphp
              @foreach ($cart['services'] as $id => $item)
                <tr data-id="{{$id}}">
                  <td class="invert">{{$id}}</td>
                  <td class="invert-image">
                    <a href="/category/{{$item['category']}}/{{$item->slug}}"></a>
                      <img src="{{$item['img'] ?? '/images/no_image.png' }}" alt="{{$item['title']}}">
                    </a>
                  </td>
                  <td class="invert">
                      <div class="quantity">
                          <div class="quantity-select">
                              <div class="entry value-minus">&nbsp;</div>
                              <div class="entry value"><span>{{$item->quantity}}</span></div>
                              <div class="entry value-plus active">&nbsp;</div>
                          </div>
                      </div>
                  </td>
                  <td class="invert">{{$item['title']}}</td>
                  <td class="invert">{{$item['price']}}</td>
                  <td class="invert">
                      <div class="rem">
                          <a class="removeItem"></a>
                      </div>
                  </td>
              </tr>
              @php
              $i += 1;
              @endphp
              @endforeach
              </tbody>
            </table>
          </div>
      </div>
      <div class="checkout-left">
          <div class="col-md-4 checkout-left-basket">
              <h4>Continue to basket</h4>
              <ul class="total-list">
                  @foreach ($cart['services'] as $id => $item)
                  <li>{{$item['title']}} <i>-</i> <span>{{$item['price']}} * {{$item->quantity}}</span></li>
                  <?php endforeach; ?>
                  <li>Total <i>-</i> <span>{{$cart['total']}}</span></li>
              </ul>
          </div>
          <div class="col-md-8 address_form_agile">
              <h4>Add a new Details</h4>
              <form action="payment.html" method="post" class="creditly-card-form agileinfo_form">
                  <section class="creditly-wrapper wthree, w3_agileits_wrapper">
                      <div class="information-wrapper">
                          <div class="first-row form-group">
                              <div class="controls">
                                  <label class="control-label">Full name: </label>
                                  <input class="billing-address-name form-control" type="text" name="name" 
                                  placeholder="Full name">
                              </div>
                              <div class="w3_agileits_card_number_grids">
                                  <div class="w3_agileits_card_number_grid_left">
                                      <div class="controls">
                                          <label class="control-label">Mobile number:</label>
                                          <input class="form-control" type="text" placeholder="Mobile number">
                                      </div>
                                  </div>
                                  <div class="w3_agileits_card_number_grid_right">
                                      <div class="controls">
                                          <label class="control-label">Landmark: </label>
                                          <input class="form-control" type="text" placeholder="Landmark">
                                      </div>
                                  </div>
                                  <div class="clear"> </div>
                              </div>
                              <div class="controls">
                                  <label class="control-label">Town/City: </label>
                                  <input class="form-control" type="text" placeholder="Town/City">
                              </div>
                              <div class="controls">
                                  <label class="control-label">Address type: </label>
                                  <select class="form-control option-w3ls">
                                      <option>Office</option>
                                      <option>Home</option>
                                      <option>Commercial</option>

                                  </select>
                              </div>
                          </div>
                          <button class="submit check_out">Delivery to this Address</button>
                      </div>
                  </section>
              </form>
              <div class="checkout-right-basket">
                  <a href="payment.html">Make a Payment <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a>
              </div>
          </div>
          <div class="clearfix"> </div>
      </div>
      <?php else: ?>
          <h3>Корзина пуста</h3>
      <?php endif; ?>
    </div>
</div>
@endsection
