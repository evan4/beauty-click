<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use App\Models\Service;

class CartController extends Controller
{
    public function order()
    {
        return view('home.order');
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

    public function remove(Request $request)
    {
        $id =  (int) $request->id;
        $service_current = $request->session()->get('cart');

        $removeItem =Arr::pull($service_current['services'], $id);

        $service_current['quantity'] -= $removeItem['quantity'];
        $service_current['total'] -= $removeItem['price'] * $removeItem['quantity'];

        $request->session()->put('cart', $service_current);

        return response()->json([
            'service' => $request->session()->get('cart')
        ], Response::HTTP_OK);
    }

    public function clear(Request $request)
    {
        $request->session()->forget('cart');

        return response()->json([
            'service' => $request->session()->get('cart')
        ], Response::HTTP_OK);
    }
}
