@extends('layouts.app')
@section('content')
<style>
  .filled-heart{
    color:#a4514c;
  }
</style>

<main class="pt-90">
@if(session()->has('success'))
    <div id="flash-message" style="
        background-color: rgba(199, 232, 157, 0.84);
        color: black;
        padding: 10px;
        border-radius: 5px;
        position: fixed;
        top: 20px;
        right: 20px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        transition: opacity 0.5s ease-in-out;">
        {{ session('success') }}
    </div>
@endif
    <section class="shop-main container d-flex pt-4 pt-xl-5">
    <div class="shop-sidebar side-sticky" id="shopFilter" style="background-color:#f3eae3 ">
        <div class="aside-header d-flex d-lg-none align-items-center">
          <h3 class="text-uppercase fs-6 mb-0">Filter By</h3>
          <button class="btn-close-lg js-close-aside btn-close-aside ms-auto"></button>
        </div>

        <div class="pt-0 pt-lg-0" style="background-color:#f3eae3";> <h3>Filter</h3></div>

        <div class="accordion" id="categories-list" style="background-color:#f3eae3">
          <div class="accordion-item  mb-0 pb-0" style="background-color:#f3eae3" >
            <h5 class="accordion-header" id="accordion-heading-1" style="background-color:#f3eae3">
            <button class="accordion-button p-2 border-2 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
            data-bs-target="#accordion-filter-1" aria-expanded="true" aria-controls="accordion-filter-1" 
            style="background-color:#c8a78e; color: white; width: 100%; border: 2px solid white;"
            onmouseover="this.style.backgroundColor='#754c29';" 
            onmouseout="this.style.backgroundColor='#c8a78e';">
                Product Categories
                <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">                  <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                    <path
                      d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                  </g>
                </svg>
              </button>
            </h5>
            <div id="accordion-filter-1" class="accordion-collapse collapse show border-0"
              aria-labelledby="accordion-heading-1" data-bs-parent="#categories-list" style="background-color:#f3eae3">
              <div class="accordion-body px-0 pb-0 pt-0">
                <ul class="list list-inline mb-0">
                @foreach ($categories as $category)
                        <li class="list-item">
                          <span class="menu-link py-1"> 
                            <input type="checkbox" name="categories" value="{{$category->id}}" class="chk-category"
                             @if(in_array($category->id,explode(',',$f_categories))) checked="checked" @endif /> 
                             {{$category->name}}
                          </span> 
                          <span class="text-right float-right">
                            {{$category->products()->count()}}</span>                                        
                        </li>
                      @endforeach   
          
                </ul>
              </div>
            </div>
          </div>
        </div>

       


        <div class="accordion" id="color-filters">
          <div class="accordion-item mb-4 pb-3" style="background-color:#f3eae3">
            <h5 class="accordion-header" id="accordion-heading-1">
            <button class="accordion-button p-2 border-2 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
    data-bs-target="#accordion-filter-2" aria-expanded="true" aria-controls="accordion-filter-2" 
    style="background-color:#c8a78e; color: white; width: 100%; border: 2px solid white;"
    onmouseover="this.style.backgroundColor='#754c29';" 
    onmouseout="this.style.backgroundColor='#c8a78e';">
    Color
                <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                  <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                    <path
                      d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                  </g>
                </svg>
              </button>
            </h5>
          <!-- Filter de couleur -->
<div id="accordion-filter-2" class="accordion-collapse collapse show border-0"
     aria-labelledby="accordion-heading-1" data-bs-parent="#color-filters" style="background-color:#f3eae3">
    <div class="accordion-body px-0 pb-0">
        <div class="d-flex flex-wrap">
            <!-- Lien pour couleur rouge -->
            <a href="{{ url('shop?color=selver&categories=' . request('categories') . '&min=' . request('min') . '&max=' . request('max') . '&order=' . request('order')) }}" class="swatch-color js-filter" style="background-color: rgb(174, 174, 174);"></a>
            
            <!-- Lien pour couleur jaune -->
            <a href="{{ url('shop?color=gold&categories=' . request('categories') . '&min=' . request('min') . '&max=' . request('max') . '&order=' . request('order')) }}" class="swatch-color js-filter" style="background-color: rgb(225, 178, 47);"></a>
            
            <!-- Lien pour couleur rose -->
            <a href="{{ url('shop?color=goldenrose&categories=' . request('categories') . '&min=' . request('min') . '&max=' . request('max') . '&order=' . request('order')) }}" class="swatch-color js-filter" style="background-color: rgb(223, 173, 159);"></a>
            
            <!-- Ajoute d'autres couleurs ici selon tes besoins -->
        </div>
    </div>
</div>

          </div>
        </div>


        


        


        <div class="accordion" id="price-filters">
          <div class="accordion-item mb-4"  style="background-color:#f3eae3">
            <h5 class="accordion-header mb-2" id="accordion-heading-price">
            <button class="accordion-button p-2 border-2 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
                    data-bs-target="#accordion-filter-price" aria-expanded="true" aria-controls="accordion-filter-price"
                    style="background-color:#c8a78e; color: white; width: 100%; border: 2px solid white; border-radius: 5px;"
                    onmouseover="this.style.backgroundColor='#754c29';" 
                    onmouseout="this.style.backgroundColor='#c8a78e';">
                    Price
                <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                  <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                    <path
                      d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                  </g>
                </svg>
              </button>
            </h5>

            <div id="accordion-filter-price" class="accordion-collapse collapse show border-0"
              aria-labelledby="accordion-heading-price" data-bs-parent="#price-filters">
              <input class="price-range-slider" type="text" name="price_range" value="" data-slider-min="1"
                data-slider-max="500" data-slider-step="5" data-slider-value="[{{$min_price}},{{$max_price}}]" data-currency="$" />
              <div class="price-range__info d-flex align-items-center mt-2">
                <div class="me-auto">
                  <span class="text-secondary">Min Price: </span>
                  <span class="price-range__min">${{$min_price}}</span>
                </div>
                <div>
                  <span class="text-secondary">Max Price: </span>
                  <span class="price-range__max">${{$max_price}}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>



      <div class="shop-list flex-grow-1">
    <div class="swiper-container js-swiper-slider slideshow slideshow_small slideshow_split" 
         data-settings='{
            "autoplay": { "delay": 5000 },
            "slidesPerView": 1,
            "effect": "fade",
            "loop": true,
            "pagination": {
              "el": ".slideshow-pagination",
              "type": "bullets",
              "clickable": true
            }
          }'>

        <div class="container-fluid">
            <div class="row align-items-center">

                <div class="col-md-12 d-flex flex-wrap">

                    <div class="col-md-7 d-flex flex-column justify-content-center p-5"
                         style="background-color: #f5e6e0; min-height: 500px; flex-grow: 1; overflow: hidden;">
                        <h2 class="text-uppercase section-title fw-normal mb-3">
                            Women's <br /><strong>ACCESSORIES</strong>
                        </h2>
                        <p class="mb-0">
                            Accessories are the best way to update your look. Add a title edge with new styles and new colors, or go for timeless pieces.
                        </p>
                        <a href="#shoop" class="btn btn-dark mt-3">Shop Now</a>
                    </div>

                 
                    <div class="col-md-5 p-0">
                        <img loading="lazy" src="{{ asset('assets/34.jpg') }}" width="100%" height="500"
                            alt="Women's accessories" style="object-fit: cover; max-width: 100%; height: auto; display: block;" />
                    </div>

                </div>

            </div>
        </div>

        <div class="container p-3 p-xl-5">
            <div class="slideshow-pagination d-flex align-items-center position-absolute bottom-0 mb-4 pb-xl-2"></div>
        </div>

    </div>

    <div class="mb-3 pb-2 pb-xl-3"></div>

<!-- Breadcrumb: Home / Shop -->
<div class="d-flex justify-content-between mb-4 pb-md-2">
    <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
        <a href="{{route('home.index')}}" class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
        <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
        <a href="#shoop" class="menu-link menu-link_us-s text-uppercase fw-medium">The Shop</a>
    </div>
</div>

<!-- Default Sorting Select -->
<div class="d-flex justify-content-between mb-4 pb-md-2">
<div class="shop-acs d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
            <select class="shop-acs__select form-select w-auto border-0 py-0 order-1 order-md-0" aria-label="Sort Items"
              name="orderby" id="orderby">
              <option value="-1" {{ $order == -1 ? 'selected': ''}}>Default </option>
              <option value="2"{{ $order == 2 ? 'selected': ''}}>Date, old to new</option>
              <option value="1"{{ $order == 1 ? 'selected': ''}}>Date, new to old</option>
              <option value="3"{{ $order ==  3 ? 'selected': ''}}>Price, low to high</option>
              <option value="4"{{ $order == 4 ? 'selected': ''}}>Price, high to low</option>
            </select>
    </div>
</div>

<!-- Product List: Static and Two Columns -->
<div class="container" id="shoop">
    <div class="row row-cols-1 row-cols-md-2">
        @foreach ($products as $product)
        <div class="col mb-4">
            <div class="product-card-wrapper">
                <div class="product-card">
                    <div class="pc__img-wrapper">
                        <div class="swiper-container background-img js-swiper-slider" data-settings='{"resizeObserver": true}'>
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <a href="{{route('shop.product.details', ['product_slug' => $product->slug])}}">
                                    <img src="{{ asset('assets/' . $product->image) }}" width="330" height="200" alt="{{ $product->name }}">

                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pc__info position-relative">
                        <p class="pc__category">{{$product->category->name}}</p>
                        <h6 class="pc__title">
                            <a href="{{route('shop.product.details',['product_slug'=>$product->slug])}}">{{$product->name}}</a>
                        </h6>

                        <div class="product-card__price">
                            <span class="money price">
                                @if($product->sale_price)
                                    <s>${{$product->regular_price}}</s> ${{$product->sale_price}} {{round(($product->regular_price - $product->sale_price)*100/$product->regular_price)}}% OFF
                                @else
                                    ${{$product->regular_price}}
                                @endif
                            </span>
                        </div>
                        @if(Cart::instance("cart")->content()->Where('id',$product->id)->count()>0)
                    <a href="{{route('cart.index')}}" class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium js-add-cart btn-warning">Go to Cart</a>
                @else
                <form name="addtocart-form" method="POST" action="{{route('cart.store')}}">
                    @csrf
                    <div class="product-single__addtocart">                                               
                        <input type="hidden" name="id" value="{{$product->id}}" />
                        <input type="hidden" name="name" value="{{$product->name}}" />
                        <input type="hidden" name="quantity" value="1"/>
                        <input type="hidden" name="price" value="{{$product->sale_price == '' ? $product->regular_price:$product->sale_price}}" />
                        <button type="submit" class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium js-add-cart">Add to Cart</button>
                    </div>
                </form>
                @endif   
                @if(Cart::instance('wishlist')->content()->where('id',$product->id)->count()>0)
                <button  type="submit" class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist filled-heart"
                  title="Add To wishlist">
                  <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_heart" />
                  </svg>
                </button>
                @else
                <form  method="POST"action="{{route('wishlist.add')}}">
                @csrf
                <input type="hidden" name="id" value="{{$product->id}}">
                <input type="hidden" name="name" value="{{$product->name}}">
                <input type="hidden" name="price" value="{{$product->sale_price=='' ? $product->regular_price : $product->sale_price}}"/>
                <input type="hidden" name="quantity" value="1"/>


                <button  type="submit" class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist"
                  title="Add To wishlist">
                  <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_heart" />
                  </svg>
                </button>
                </form>
                @endif

                        
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>


      


    <div class="divider"></div>
        <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">                
            {{$products->withQueryString()->links('pagination::bootstrap-5')}}
    </div>
    </section>
    <style>
    /* Style the slider track */
        .slider .slider-track {
            background: white; /* Black track */
            height: 6px;
        }

        /* Style the selected range */
        .slider .slider-selection {
            background: #a96155; /* Black selected range */
        }

        /* Style the handles */
        .slider .slider-handle {
            background: #fff; /* White handle */
            border: 2px solid #a96155;
            width: 19px;
            height: 19px;
        }

        /* Remove the default box shadow */
        .slider .slider-handle:hover {
            box-shadow: none;
        }

        /* Adjust text styles for Min/Max price */
        .price-range__info span {
            font-size: 14px;
            font-weight: bold;
        }

        </style>
  </main>
  <form id="frmfilter" method="GET" action="{{route('shop.index')}}">
    <input type="hidden" id="order" name="order" value="{{$order}}" />
    <input type="hidden" name="categories" id="hdnCategories" />
    <input type="hidden" name="min" id="hdnMinPrice" value="{{$min_price}}" />
    <input type="hidden" name="max" id="hdnMaxPrice" value="{{$max_price}}" />
  <form>
  @endsection
  @push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.6.1/bootstrap-slider.min.js"></script>

<script>
    $(document).ready(function() {
        $(".price-range-slider").slider({});
    });
</script>
<script>
      document.addEventListener("DOMContentLoaded", function() {
          let flashMessage = document.getElementById("flash-message");
          if (flashMessage) {
              setTimeout(() => {
                  flashMessage.style.opacity = "0";
                  setTimeout(() => flashMessage.remove(), 500);
              }, 1000); // Hides after 2 seconds
          }
      });
  </script>
  <script>
    $(function()
  {     $("#orderby").on("change",function(){
        $("#order").val($("#orderby option:selected").val());
        $("#frmfilter").submit();

  })
    $("input[name='categories']").on("change",function(){
                  var categories ="";
                  $("input[name='categories']:checked").each(function(){
                      if(categories=="")
                      {
                          categories += $(this).val();
                      }
                      else{
                          categories += "," + $(this).val();
                      }
                  });
                  $("#hdnCategories").val(categories);
                  $("#frmfilter").submit();              
              });

    $("[name='price_range']").on("change",function() {
      var min = $(this).val().split(',')[0];  
      var max = $(this).val().split(',')[1];

      $("#hdnMinPrice").val(min);
      $("#hdnMaxPrice").val(max);
      setTimeout(() => {
        $("#frmfilter").submit();  
        
      }, 2000);
      
    });

  })
  

    </script>


@endpush