<ul class="account-nav">
            <li><a href="{{route('user.index')}}" class="menu-link menu-link_us-s">Dashboard</a></li>
            <li><a href="{{route('user.orders')}}" class="menu-link menu-link_us-s">Orders</a></li>
            <li><a href="{{route('address.index')}}" class="menu-link menu-link_us-s">Adresses</a></li>
            <li><a href="{{route('wishlist.index')}}" class="menu-link menu-link_us-s">Wishlist</a></li>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    document.getElementById("logout-link").addEventListener("click", function(event) {
                        event.preventDefault();
                        document.getElementById("logout-form").submit();
                    });
                });
            </script>
             <li >
              <form id="logout-form" action="{{ route('logout') }}" method="POST"  id="logout-form" >
                  @csrf
              </form>
              <a href="#" id="logout-link" class="menu-link menu-link_us-s">
                  <div class="icon"><i class="icon-settings"></i></div>
                  <div class="text">Logout</div>
              </a>
          </li>
           
          </ul>


         