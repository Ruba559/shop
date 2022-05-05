 <!--Start sidebar-wrapper-->
   <div class="my_sidebar" id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
     <div class="brand-logo">
      <a href="#">
       <img src="assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
       <h5 class="logo-text">Dashtreme Admin</h5>
     </a>
   </div>
   <ul class="sidebar-menu do-nicescrol">
      <li class="sidebar-header">MAIN NAVIGATION</li>
      <li>
        <a href="/home">
          <i class="zmdi zmdi-view-dashboard"></i> <span>{{__('dashboard.Dashboard')}}</span>
        </a>
      </li>


<li>
  <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> <i class="zmdi zmdi-format-list-bulleted"></i>{{ __('dashboard.Product') }}</a>
  <ul class="collapse list-unstyled" id="pageSubmenu">
    <li>
      <a href="/productname">
        <span>{{ __('dashboard.Add_product') }}</span>
      </a>
    </li>
    <hr>
    <li>
      <a href="/productprice">
        <span>{{ __('dashboard.Add_price') }}</span>
      </a>
    </li>
      
  </ul>
</li>


<li>
  <a href="#pageSubmenuser" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="zmdi zmdi-format-list-bulleted"></i>{{ __('dashboard.User_management') }}</a>
  <ul class="collapse list-unstyled" id="pageSubmenuser">
    @if(auth()->user()->can('user-list'))
    <li>
      <a href="/user">
       <span>{{ __('dashboard.User') }}</span>
      </a>
    </li>
    @endif
    <hr>
    @if(auth()->user()->can('rule-list'))
    <li>
      <a href="/rule">
       <span>{{ __('dashboard.Rule') }}</span>
      </a>
    </li>
    @endif
      
  </ul>
</li>



 @if(auth()->user()->can('category-list'))
      <li>
        <a href="/category">
          <i class="zmdi zmdi-format-list-bulleted"></i> <span>{{ __('dashboard.Category') }}</span>
        </a>
      </li>
@endif

  @if(auth()->user()->can('product-list'))
      <li>
        <a href="/product">
          <i class="zmdi zmdi-format-list-bulleted"></i> <span>{{ __('dashboard.Product') }}</span>
        </a>
      </li>
@endif
 @if(auth()->user()->can('delivery-list'))
      <li>
        <a href="/delivery">
          <i class="zmdi zmdi-account-circle"></i> <span>{{ __('dashboard.Delivery') }}</span>
        </a>

      </li>

@endif

@if(auth()->user()->can('deliverystatus-list'))
 <li>
        <a href="/delivery_status">
          <i class="zmdi zmdi-account-circle"></i> <span>{{ __('dashboard.Delivery_status') }}</span>
        </a>

      </li>
@endif

     @if(auth()->user()->can('supplier-list'))
       <li>
        <a href="/supplier">
          <i class="zmdi zmdi-account-circle"></i> <span>{{ __('dashboard.Supplier') }}</span>
        </a>
      </li>
@endif

 @if(auth()->user()->can('advert-list'))
  <li>
        <a href="/advertising">
         <i class="zmdi zmdi-format-list-bulleted"></i> <span>{{ __('dashboard.Advert') }}</span>
        </a>
      </li>
@endif


@if(auth()->user()->can('request-list'))
<li>
  <a href="#pageSubmenur" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> <i class="zmdi zmdi-format-list-bulleted"></i>{{ __('dashboard.Requests') }}</a>
  <ul class="collapse list-unstyled" id="pageSubmenur">
    <li>
      <a href="/request">
         <span>{{ __('dashboard.Requests') }}</span>
      </a>
    </li>
    <hr>
    <li>
      <a href="/request2">
        <span>{{ __('dashboard.Request_pending') }}</span>
      </a>
    </li>
      
  </ul>
</li>
@endif

<li>
  <a href="/velocity">
    <i class="zmdi zmdi-format-list-bulleted"></i> <span>{{ __('dashboard.Velocity') }}</span>
  </a>
</li>

<li>
  <a href="#pageSubmenu2" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> <i class="zmdi zmdi-format-list-bulleted"></i>{{ __('dashboard.Calculation') }}</a>
  <ul class="collapse list-unstyled" id="pageSubmenu2">

    <li>
      <a href="/calculation">
        <span>{{ __('dashboard.Calculation_by_bill') }}</span>
      </a>
    </li>
    <hr>
    <li>
      <a href="/profit">
        <span>{{ __('dashboard.Profit') }}</span>
      </a>
    </li>
    <hr>
    <li>
      <a href="/calculationdelivery">
       <span>{{ __('dashboard.Calculation_by_del') }}</span>
      </a>
    </li>
      
  </ul>
</li>


    </ul>
   
   </div>
   <!--End sidebar-wrapper-->

<!--Start topbar header-->
<header class="topbar-nav">
 <nav class="navbar navbar-expand fixed-top">
  <ul class="navbar-nav mr-auto align-items-center">
    <li class="nav-item">
      <a class="nav-link toggle-menu" href="javascript:void();">
       <i class="icon-menu menu-icon"></i>
     </a>
    </li>

    <li class="nav-item">
      <form class="search-bar">
        <input type="text" class="form-control" placeholder="Enter keywords">
         <a href="javascript:void();"><i class="icon-magnifier"></i></a>
      </form>
    </li>
  </ul>
     
  <ul class="navbar-nav align-items-center right-nav-link">
    <li class="nav-item dropdown-lg">
      <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown" href="javascript:void();">
      <i class="fa fa-envelope-open-o"></i></a>
    </li>
    <li class="nav-item dropdown-lg">
      <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown" href="javascript:void();">
      <i class="fa fa-bell-o"></i></a>
    </li>
     @auth()
                          <li class="nav-item">
                           <a class="nav-link text-white" href="#">
                            <a href="/logout" class="message-item d-flex align-items-center border-bottom px-3 py-2">
                              <h5><i class=" fas fa-sign-in-alt text-dark-info"></i>{{__('dashboard.Sign_out')}}</h5>
                             </a>
                           </a>
                          </li>
                          @endauth
     <div class="btn-group mb-1">
            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              @if (App::getLocale() == 'ar')
              {{ LaravelLocalization::getCurrentLocaleName() }}
             <img src="{{ URL::asset('assets/images/flags/EG.png') }}" alt="">
              @else
              {{ LaravelLocalization::getCurrentLocaleName() }}
              <img src="{{ URL::asset('assets/images/flags/US.png') }}" alt="">
              @endif
              </button>
            <div class="dropdown-menu">
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                            {{ $properties['native'] }}
                        </a>
                @endforeach
            </div>
        </div>
   
    
     
</nav>
</header>