<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>muse shop</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="stylesite.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Allura&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/plugins/swiper.min.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
        integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    @stack("styles")


</head>

<body>

<header>
  <!-- SVG symboles -->
  <svg style="display: none;">
    <symbol id="icon_search" viewBox="0 0 20 20">
      <g clip-path="url(#clip0_6_7)">
        <path d="M8.80758 0C3.95121 0 0 3.95121 0 8.80758C0 13.6642 3.95121 17.6152 8.80758 17.6152C13.6642 17.6152 17.6152 13.6642 17.6152 8.80758C17.6152 3.95121 13.6642 0 8.80758 0ZM8.80758 15.9892C4.84769 15.9892 1.62602 12.7675 1.62602 8.80762C1.62602 4.84773 4.84769 1.62602 8.80758 1.62602C12.7675 1.62602 15.9891 4.84769 15.9891 8.80758C15.9891 12.7675 12.7675 15.9892 8.80758 15.9892Z" fill="currentColor" />
        <path d="M19.7618 18.6122L15.1006 13.9509C14.783 13.6333 14.2686 13.6333 13.951 13.9509C13.6334 14.2683 13.6334 14.7832 13.951 15.1005L18.6122 19.7618C18.771 19.9206 18.9789 20 19.187 20C19.3949 20 19.603 19.9206 19.7618 19.7618C20.0795 19.4444 20.0795 18.9295 19.7618 18.6122Z" fill="currentColor" />
      </g>
      <defs>
        <clipPath id="clip0_6_7">
          <rect width="20" height="20" fill="White" />
        </clipPath>
      </defs>
    </symbol>
    <symbol id="icon_cart" viewBox="0 0 24 24" fill="none">
  <path d="M7 18C5.89543 18 5 18.8954 5 20C5 21.1046 5.89543 22 7 22C8.10457 22 9 21.1046 9 20C9 18.8954 8.10457 18 7 18ZM1 2V4H3L6.6 11.59L5.24 14.04C5.09 14.32 5 14.65 5 15C5 16.1046 5.89543 17 7 17H19V15H7.42C7.28 15 7.17 14.89 7.17 14.75L7.2 14.65L8.1 13H15.55C16.3 13 16.96 12.58 17.3 11.97L20.88 5.48C20.95 5.34 21 5.17 21 5C21 4.45 20.55 4 20 4H5.21L4.27 2H1ZM17 18C15.8954 18 15 18.8954 15 20C15 21.1046 15.8954 22 17 22C18.1046 22 19 21.1046 19 20C19 18.8954 18.1046 18 17 18Z" fill="currentColor"/>
</symbol>


    <symbol id="icon_heart" viewBox="0 0 20 20">
      <g clip-path="url(#clip0_6_54)">
        <path d="M18.3932 3.30806C16.218 1.13348 12.6795 1.13348 10.5049 3.30806L9.99983 3.81285L9.49504 3.30806C7.32046 1.13319 3.78163 1.13319 1.60706 3.30806C-0.523361 5.43848 -0.537195 8.81542 1.57498 11.1634C3.50142 13.3041 9.18304 17.929 9.4241 18.1248C9.58775 18.2578 9.78467 18.3226 9.9804 18.3226C9.98688 18.3226 9.99335 18.3226 9.99953 18.3223C10.202 18.3317 10.406 18.2622 10.575 18.1248C10.816 17.929 16.4982 13.3041 18.4253 11.1631C20.5371 8.81542 20.5233 5.43848 18.3932 3.30806Z" fill="currentColor" />
      </g>
      <defs>
        <clipPath id="clip0_6_54">
          <rect width="20" height="20" fill="white" />
        </clipPath>
      </defs>
    </symbol>
  </svg>

  <nav class="navbar">
    <div class="logo">
      <a href="{{route('home.index')}}">
        <img class="lg" src="{{asset('assets/10.jpeg')}}" alt="Muse Logo">
      </a>
    </div>

    <ul class="nav-links">
      <li><a href="{{route('home.index')}}">Home</a></li>
      <li><a href="#aboutus">About</a></li>
      <li><a href="{{route('shop.index')}}">Shop</a></li>
      <li><a href="#contact">Contact</a></li>
    </ul>

    
    @php
    use Illuminate\Support\Facades\Auth;
    
@endphp
    <div class="nav-icons">
      @guest
        <a href="{{route('login')}}" class="header-tools_item">Log in</a>
      @else
        <a href="{{Auth::user()->utype==='ADM' ? route('admin.index') : route('user.index')}}" class="header-tools_item">My Account</a>
        <span class="pr-6px">{{Auth::user()->name}}</span>
      @endguest

    
      <a href="{{route('cart.index')}}">
        <svg width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <use href="#icon_cart" />
        </svg>
      </a>

      <a href="{{route('wishlist.index')}}">
        <svg width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <use href="#icon_heart" />
        </svg>
      </a>

    
      <a href="#" class="js-search-toggle">
        <svg width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <use href="#icon_search" />
        </svg>
      </a>
    </div>

    
    <div class="search-popup" id="searchBar">
      <form action="#" method="GET" class="search-field container">
        <p class="text-uppercase text-secondary fw-medium mb-4">What are you looking for?</p>
        <div class="position-relative">
          <input class="search-field__input search-popup__input w-100 fw-medium" type="text" name="search-keyword"  id="search-input" placeholder="Search products" />
          <button class="btn-icon search-popup__submit" type="submit">
            <svg class="d-block" width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <use href="#icon_search" />
            </svg>
          </button>
          <button class="btn-icon btn-close-lg search-popup__reset" type="reset"></button>
        </div>
        <div class="search-popup__results">
            <ul id="box-content-search"></ul>
          </div>
      </form>
    </div>
  </nav>
</header>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.querySelector(".js-search-toggle");
    const searchBar = document.querySelector("#searchBar");

    toggleBtn.addEventListener("click", function (e) {
      e.preventDefault();
      searchBar.classList.toggle("active");
    });
  });
</script>



        

  </header>      
       
    @yield("content")

    <main >
      
    @php
        use Illuminate\Support\Facades\Route;
    @endphp
    @if(Route::currentRouteName() == 'home.index')

     <div class="product-grid">
      

        <div class="product-card">
        <img src="{{ asset('assets/8.jpeg') }}" alt="Elegant Necklaces">
        <h2>Elegant Necklaces</h2>
        <form action="{{ route('shop.index') }}" method="GET">
            <input type="hidden" name="categories" value="3"> 
            <button type="submit">See more</button>
        </form>
        </div>
        <div class="product-card">
            <img src="{{asset('assets/13.jpeg')}}" alt="Charm Bracelets">
            <h2>Charm Bracelets</h2>
            <form action="{{ route('shop.index') }}" method="GET">
                <input type="hidden" name="categories" value="5"> 
                <button type="submit">See more</button>
            </form>
        </div>
        <div class="product-card">
            <img src="{{asset('assets/9.jpeg')}}" alt="Lightening earrings">
            <h2>Lightening earrings </h2>
            <form action="{{ route('shop.index') }}" method="GET">
                <input type="hidden" name="categories" value="4"> 
                <button type="submit">See more</button>
            </form>
        </div>
        <div class="product-card">
            <img src="{{asset('assets/12.jpeg')}}" alt="Classy watches">
            <h2>Classy watches </h2>
            <form action="{{ route('shop.index') }}" method="GET">
                <input type="hidden" name="categories" value="6"> 
                <button type="submit">See more</button>
            </form>
        </div>
        <div class="product-card">
            <img src="{{asset('assets/11.jpeg')}}" alt=Modern rings">
            <h2>Modern rings </h2>
            <form action="{{ route('shop.index') }}" method="GET">
                <input type="hidden" name="categories" value="2"> 
                <button type="submit">See more</button>
            </form>
        </div>

        @endif

    </main>
    
    
    <div class="About" id="aboutus">
        <div class="texteSurImage">
          <br>
          <br>
            <h2>ABOUT US.</h2>
            <p>Welcome to the Muse Store, where elegance meets craftsmanship. We offer exquisite rings, dazzling necklaces, and timeless bracelets designed to complement your unique style. Let our collections add a touch of brilliance to every moment. </p>
          <br>
          </div>
    </div>
            

    
    <section id="contact">
      <hr>
        <h2>Contact Us</h2>
        <p>Email: muse@gmail.com</p>
        <p>Phone: +212 534 567 890</p>
        <p>Address: 123 Future St, Cyber City, FC 45678</p>
    </section>
    
    <footer>
        <p>&copy; 2025 Muse Jewelery. All Rights Reserved.</p>
    </footer>
        <style>  
          body {
              font-family: 'Poppins', sans-serif;
              background-color: #f3eae3;
              text-align: center;
              margin: 0;
              padding: 0;
              color: #5a4a42;
              background-image: url('background.jpg');
              background-size: cover;
              background-attachment: fixed;
              background-position: center;
          }
          




          .navbar {
              display: flex;
              justify-content: space-between;
              align-items: center;
              padding: 15px 50px;
              background: rgba(255, 255, 255, 0.9);
              position: fixed;
              width: 100%;
              top: 0;
              z-index: 1000;
          }

          .nav-links {
              list-style: none;
              display: flex;
              gap: 20px;
              padding:0px;
              margin:0px;
          }

          .nav-links li a {
              text-decoration: none;
              color: #5a4a42;
              font-weight: bold;
          }

          .nav-icons {
    display: flex;
    justify-content: center; /* Centrer les icônes */
    align-items: center; /* Assurer l'alignement vertical */
    gap: 20px; /* Espacement uniforme */
}

.nav-icons a {
    display: flex;
    align-items: center;
    justify-content: center; 
    width: 50px; /* Fixe une taille pour éviter les décalages */
    height: 50px;
    text-decoration: none;
    color: #5a4a42;
}

.nav-icons svg {
    width: 20px; /* Taille uniforme des icônes */
    height: 20px;
}


          .nav-icons i:hover {
              color:#a96155;
          }

          .product-grid {
              display: flex;
              justify-content: center;
              gap: 20px;
              margin-top: 20px;
              flex-wrap: wrap;
          }

          .product-card {
              background: #fff9f6;
              padding: 15px;
              border-radius: 15px;
              box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
              width: 190px;
              transition: transform 0.3s ease;
          }

          .product-card:hover {
              transform: scale(0.85);
          }

          .product-card img {
              width: 100%;
              border-radius: 10px;
          }
          .search-popup {
  display: none;
  position: absolute;
  top: 70px; /* Ajuste selon ton header */
  right: 20px;
  background: white;
  z-index: 999;
  padding: 15px;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
  border-radius: 8px;
}

.search-popup.active {
  display: block;
}


          button {
              background-color: #c8a78e;
              color: white;
              border: none;
              padding: 10px;
              margin-top: 10px;
              cursor: pointer;
              border-radius: 5px;
              font-weight: bold;
              transition: background 40s ease;
          }

          button:hover {
              background-color: #a88672;
          }
          .lg{
              width: 48px;
              height: 48px;

          }   

          .nav-links li a {
              position: relative; 
              text-decoration: none;
              color: #5a4a42;
              font-weight: bold;
              padding-bottom: 5px; 
          }

          .nav-links li a:hover,.nav-links li a.active {
              color: #a96155;
          }

          .nav-links li a.active::after,.nav-links li a:hover::after {
              content: "";
              width: 100%;
              height: 2px;
              background: #a96155;
              position: absolute;
              bottom: 0; 
              left: 0;
          }
          .nav-icons a {
              position: relative;
              text-decoration: none;
              color: #5a4a42;
              font-weight: bold;
              padding-bottom: 5px;
          }

          .nav-icons a:hover {
              color: #a96155;
          }

          .nav-icons a:hover::after {
              content: "";
              width: 100%;
              height: 2px;
              background: #a96155;
              position: absolute;
              bottom: 0;
              left: 0;
          }
          .About h2 {
                font-size: 30px;
                color: black;
                text-align: center; 
            }

          .About p {
                margin: 30px auto; 
                font-size: 20px;
                color: black;
                max-width: 100%; 
                padding: 0 20px; 
            }
            #box-content-search {
  max-height: 300px; /* Ajuste la hauteur selon tes besoins */
  overflow-y: auto; /* Permet le défilement vertical */
  position: absolute;
  width: 100%;
  background: #fff;
  border: 1px solid #ddd;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  border-radius: 8px; /* Coins arrondis */
  padding: 10px;
}


        </style>
  <script>
  $(function () {
    $("#search-input").on("keyup", function () {
      var searchQuery = $(this).val();
      if (searchQuery.length > 2) {
        $.ajax({
          type: "GET",
          url: "{{ route('home.search') }}",
          data: { query: searchQuery },
          dataType: 'json',
          success: function (data) {
            $("#box-content-search").html('');
            $.each(data, function (index, item) {
              var url = "{{ route('shop.product.details', ['product_slug' => 'product_slug_pls']) }}";
              var link = url.replace('product_slug_pls', item.slug);

              $("#box-content-search").append(`
                      <li>
                        <div class="product-item flex items-start">
                          <div class="image no-bg">
                            <img src="{{ asset('assets/') }}/${item.image}" alt="${item.name}" width="150" height="150"> 
                          </div>
                          <div class="name">
                            <a href="${link}" class="body-text">${item.name}</a>
                          </div>
                        </div>
                        <div class="divider mb-5"></div>
                      </li>
                    `);

            });
          }
        });
      }
    });
  });
  
</script>
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
        <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('assets/js/bootstrap-select.min.js')}}"></script>   
        <script src="{{asset('assets/js/sweetalert.min.js')}}"></script>    
        <script src="{{asset('assets/js/apexcharts/apexcharts.js')}}"></script>
        <script src="{{asset('assets/js/main.js')}}"></script>
        @stack("scripts")
</body> 
</html>