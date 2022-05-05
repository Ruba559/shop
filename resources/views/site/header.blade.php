<header id="header" class="header header-style-1">
    <div class="container-fluid">
        <div class="row">
            <div class="topbar-menu-area">
                <div class="container">
                    <div class="topbar-menu left-menu">
                        <ul>
                            <li class="menu-item" >
                                <a title="Hotline: (+123) 456 789" href="#" ><span class="icon label-before fa fa-mobile"></span>Hotline: (+123) 456 789</a>
                            </li>
                        </ul>
                    </div>
                    <div class="topbar-menu right-menu">
                        <ul>
                            @auth('customer')
                             <li class="menu-item" ><a title="Register or Login" href="/logout_customer">Logout</a></li>
                            @else
                           <li class="menu-item" ><a title="Register or Login" href="/login_site">Login</a></li>
                          
                            @endauth
                            <li class="menu-item" ><a title="Register or Login" href="/register_site">Register</a></li>
                            <li class="menu-item lang-menu menu-item-has-children parent">
                                <a title="English" href="#"><span class="img label-before"><img src="assetssite/images/lang-en.png" alt="lang-en"></span>English<i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                <ul class="submenu lang">
                                    <li class="menu-item" ><a title="french" href="#"><span class="img label-before"><img src="assetssite/images/lang-fra.png" alt="lang-fre"></span>French</a></li>
                                    <li class="menu-item" ><a title="canada" href="#"><span class="img label-before"><img src="assetssite/images/lang-can.png" alt="lang-can"></span>Canada</a></li>
                                </ul>
                            </li>
                            {{-- <li class="menu-item menu-item-has-children parent" >
                                <a title="Dollar (USD)" href="#">Dollar (USD)<i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                <ul class="submenu curency" >
                                    <li class="menu-item" >
                                        <a title="Pound (GBP)" href="#">Pound (GBP)</a>
                                    </li>
                                    <li class="menu-item" >
                                        <a title="Euro (EUR)" href="#">Euro (EUR)</a>
                                    </li>
                                    <li class="menu-item" >
                                        <a title="Dollar (USD)" href="#">Dollar (USD)</a>
                                    </li>
                                </ul>
                            </li> --}}
                        </ul>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="mid-section main-info-area">

                    <div class="wrap-logo-top left-section">
                        <a href="#" class="link-to-home"><img src="assetssite/images/Address Shop for electronic shop service1.png" alt="mercado"></a>
                    </div>

                    <div class="wrap-search center-section">
                        <div class="wrap-search-form">
                            <form action="/search" method="POST" id="form-search-top" name="form-search-top">
                                {{ csrf_field() }}
                                <input type="text" class="typeahead" name="search" value="" placeholder="Search here...">
                                <button form="form-search-top" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                                <div class="wrap-list-cate">
                                    <input type="hidden" class="category_name" name="product-cate" value="" id="product-cate">
                                    <a href="#" class="link-control">All Category</a>
                                    <ul class="list-cate">

                                        @foreach ($category as $item)
                                        
                                        <li class="level-1 cat" category_id="{{ $item->cat_id }}">{{ $item->cat_name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>
                       @auth('customer')

                       @php 
                       $count = DB::table('favorite')->where('cus_id' , auth('customer')->user()->cus_id )->count();
                       @endphp

                    <div class="wrap-icon right-section">
                        <div class="wrap-icon-section wishlist">
                            <a href="#" class="link-direction">
                                <i class="fa fa-heart" aria-hidden="true"></i>
                                <div class="left-info">
                                    <span class="index">{{$count}} item</span>
                                    <span class="title">Wishlist</span>
                                </div>
                            </a>
                        </div>
                           @endauth
                           @auth('customer')
                        <div class="wrap-icon-section minicart">
                            <a href="/index_cart" class="link-direction">
                                <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                                <div class="left-info">
                                    <span class="index">{{ count((array) session('cart')) }} items</span>
                                    <span class="title">CART</span>
                                </div>
                            </a>
                        </div>
                           @endauth
                        <div class="wrap-icon-section show-up-after-1024">
                            <a href="#" class="mobile-navigation">
                                <span></span>
                                <span></span>
                                <span></span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

                <div class="primary-nav-section">
                    <div class="container">
                        <ul class="nav primary clone-main-menu" id="mercado_main" data-menuname="Main menu" >
                            <li class="menu-item home-icon">
                                <a href="/" class="link-term mercado-item-title"><i class="fa fa-home" aria-hidden="true"></i></a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="aboutus link-term mercado-item-title">About Us</a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="link-term mercado-item-title">Shop</a>
                            </li>
                            @auth('customer')
                            
                            <li class="menu-item">
                                <a href="index_cart" class="link-term mercado-item-title">Cart</a>
                            </li>
                                
                            @endauth
                            {{-- <li class="menu-item">
                                <a href="#" class="link-term mercado-item-title">Checkout</a>
                            </li> --}}
                            

                            <li class="menu-item">
                                <a href="#cat" class="link-term mercado-item-title">Category</a>
                            </li>																	
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
