@extends('layouts.app')
@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
      <h2 class="page-title">Wishlist</h2>
      <div class="checkout-steps">
        <a href="shop_cart.html" class="checkout-steps__item active">
          <span class="checkout-steps__item-number">01</span>
          <span class="checkout-steps__item-title">
            <span>Shopping Bag</span>
            <em>Manage Your Items List</em>
          </span>
        </a>
        <a href="shop_checkout.html" class="checkout-steps__item">
          <span class="checkout-steps__item-number">02</span>
          <span class="checkout-steps__item-title">
            <span>Shipping and Checkout</span>
            <em>Checkout Your Items List</em>
          </span>
        </a>
        <a href="shop_order_complete.html" class="checkout-steps__item">
          <span class="checkout-steps__item-number">03</span>
          <span class="checkout-steps__item-title">
            <span>Confirmation</span>
            <em>Review And Submit Your Order</em>
          </span>
        </a>
      </div>
      <div class="shopping-cart">
        @if(Cart::instance('wishlist')->content()->count()>0)
        <div class="cart-table__wrapper">
          <table class="cart-table">
            <thead>
              <tr>
                <th>Product</th>
                <th></th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Action</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
              <tr>
                <td>
                  <div class="shopping-cart__product-item"> 
                    <img loading="lazy" src="{{ asset('assets/' . $item->model->image) }}" width="120" height="120" alt="{{$item->name}}" />
                  </div>
                </td>
                <td>
                  <div class="shopping-cart__product-item__detail">
                    <h4>{{$item->name}}</h4>
                   
                  </div>
                </td>
                <td>
                  <span class="shopping-cart__product-price">{{$item->price}}</span>
                </td>
                <td>
                {{$item->qty}}
                </td>
                <td>
                 <form  method="POST" action="{{route('wishlist.item.remove',['rowId'=>$item->rowId])}}" id="remove-item">
                @csrf
                @method('DELETE')
                <a href="#" class="remove-cart" onclick="event.preventDefault(); document.getElementById('remove-item').submit();">
                DELETE
                    </a>
                  </form>
                </td>
            
              </tr>
            @endforeach
            </tbody>
          </table>
          
        </div>
        @else
                    <div class="row">
                      <div class="col-md-12"></div>
                      <p>No item found in your wishlist</p>
                      <a href="{{route('shop.index')}}" class="btn btn-info">Wishlist Now</a>
                    </div>
        @endif
      </div>
    </section>
  </main>

@endsection