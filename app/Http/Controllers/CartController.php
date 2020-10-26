<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\{Request,Response};
use Illuminate\Support\Arr;
use App\Models\{Order, OrderService, Service, Shipping, Payment};

class CartController extends Controller
{
    public function order()
    {
        $shippings = Shipping::all();
        $payments = Payment::all();
        
        return view('cart.order', compact('payments', 'shippings'));
    }

    public function store(Request $request)
    {
        $input =  $request->all();

        $validator = Validator::make($input, [
            'address' => ['required', 'string', 'min:5', 'max:255'],
            'phone' => ['required', 'string', 'min:9', 'max:255'],
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $cart = $request->session()->get('cart');

        $order = Order::create([
            'total' => $cart['total'],
            'address' => $input['address'],
            'phone' => $input['phone'],
            'note' => $input['note'],
            'shipping_id' => (int) $input['shipping'],
            'payment_id' => (int) $input['payment'],
            'user_id' => auth()->user()->id
        ]);

        $orderServices = [];

        foreach ($cart['services'] as $service) {
            OrderService::create([
                'price' => $service['price'],
                'quantity' => $service['quantity'],
                'service_id' => $service['id'],
                'order_id' => $order->id,
            ]); 
        }

        $request->session()->forget('cart');

        return redirect('cart/thanks')
            ->with('status', "Ваш заказ поступил на обработку.");
    }

    public function thanks()
    {
        return view('cart.thanks');
    }

    public function add(Request $request)
    {
        $id =  (int) $request->id;

        $service_current = Service::where('id', $id)->first();
        $category = $service_current->category->slug;
       
        //dd($service_current);
        $cart = $request->session()->get('cart');
        
        // if cart is empty then this the first product
        if(!$cart) {
            $cart['services'][$id] = [
                'id' => $service_current->id,
                'title' => $service_current->title,
                'price' => $service_current->price,
                'img' => $service_current->img,
                'category' => $category,
                'slug' => $service_current->slug,
                'quantity' => 1
            ];
            $cart['quantity'] = 1;
            $cart['total'] = $service_current->price;
            $request->session()->put('cart', $cart);
            
        }else{
            // if cart not empty then check if this product exist then increment quantity
            if(isset($cart['services'][$id])) {
                $cart['services'][$id]['quantity'] += 1;

                $cart['quantity'] = $cart['quantity'] + 1;
                $cart['total'] = $cart['total'] + $service_current->price;
                $request->session()->put('cart', $cart);
                
            }else{
                // if item not exist in cart then add to cart with quantity = 1
                $cart['services'][$id] = [
                    'id' => $service_current->id,
                    'title' => $service_current->title,
                    'price' => $service_current->price,
                    'img' => $service_current->img,
                    'category' => $category,
                    'slug' => $service_current->slug,
                    'quantity' => 1
                ];
                $cart['quantity'] = $cart['quantity'] + 1;
                $cart['total'] = $cart['total'] + $service_current->price;
                $request->session()->put('cart', $cart);
            }
           
        }

        return response()->json([
            'service' => $request->session()->get('cart')
        ], Response::HTTP_OK);
    }

    public function change(Request $request)
    {
        $id =  (int) $request->id;
        $value =  (int) $request->value;
        
        $services = $request->session()->get('cart');

        $exists = Arr::exists($services['services'], $id);

        if($exists){
            $item = Arr::get($services['services'], $id);

            $services['services'][$id]['quantity'] += $value;
            $services['quantity'] += $value;

            $total = 0;
            foreach ($services['services'] as $service) {
                $total += $service['price'] * $service['quantity'];
            }
            $services['total'] = $total;

            $request->session()->put('cart', $services);

            return response()->json([
                'success' => true,
                'service' => $request->session()->get('cart')
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
            'service' => $request->session()->get('cart')
        ], Response::HTTP_OK);
    }

    public function remove(Request $request)
    {
        $id =  (int) $request->id;
        $services = $request->session()->get('cart');

        $exists = Arr::exists($services['services'], $id);

        if($exists){
            $removeItem = Arr::pull($services['services'], $id);

            $services['quantity'] -= $removeItem['quantity'];
            $services['total'] -= $removeItem['price'] * $removeItem['quantity'];
    
            $request->session()->put('cart', $services);
    
            return response()->json([
                'success' => true,
                'service' => $request->session()->get('cart')
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
            'service' => $request->session()->get('cart')
        ], Response::HTTP_OK);
       
    }

    public function clear(Request $request)
    {
        $request->session()->forget('cart');

        return response()->json([
            'success' => true,
            'service' => $request->session()->get('cart')
        ], Response::HTTP_OK);
    }

}
