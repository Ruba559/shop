@extends('site.app')

@section('content_head')

@endsection

@section('title')

@endsection

@section('content')

<body class="home-page home-01">

	<!-- mobile menu -->
    <div class="mercado-clone-wrap">
        <div class="mercado-panels-actions-wrap">
            <a class="mercado-close-btn mercado-close-panels" href="#">x</a>
        </div>
        <div class="mercado-panels"></div>
    </div>

	@include('site.header')

	<main id="main">
		<div class="container">

			<!--MAIN SLIDE-->
			<div class="wrap-main-slide">
				<div class="slide-carousel owl-carousel style-nav-1" data-items="1" data-loop="1" data-nav="true" data-dots="false">
				 @foreach ($advertising as $item)
				
					<div class="item-slide">
						<img src="{{ asset('images/advert/'.$item->advert_image) }}" alt="" class="img-slide">
						<div class="slide-info slide-1">
							<h2 class="f-title"><b> </b></h2>
							<span class="subtitle">{{ $item->advert_name }} </span>
							<p class="sale-info"><span class="price"> </span></p>
							
						</div>
					</div>
                @endforeach
					
				</div>
			</div>

			<!--BANNER-->
			{{-- <div class="wrap-banner col-xl-3">

				@foreach($categories as $item)

				<div class="banner-item col-sm-3">
					<a href="" class="link-banner banner-effect-1">
						<figure><img src="{{ asset('images/category/'.$item->cat_thumbnail) }}" alt="" width="590" height="140"></figure>
					</a>
				</div>

				<div class="banner-item col-sm-3">
					<a href="" class="link-banner banner-effect-1">
						<figure><img src="{{ asset('images/category/'.$item->cat_thumbnail) }}" alt="" width="590" height="140"></figure>
					</a>
				</div>

				@endforeach

			</div> --}}

			<!--On Sale-->
			<div class="wrap-show-advance-info-box style-1 has-countdown">
				<h3 class="title-box">On Sale</h3>
				<div class="wrap-countdown mercado-countdown" data-expire="2020/12/12 12:34:56"></div>
				<div class="wrap-products slide-carousel owl-carousel style-nav-1 equal-container " data-items="5" data-loop="false" data-nav="true" data-dots="false" data-responsive='{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"3"},"992":{"items":"4"},"1200":{"items":"5"}}'>

					@foreach ($product_offers as $item)
						
				
					<div class="product product-style-2 equal-elem ">
						<div class="product-thumnail">
							<a href="detail.html" title="T-Shirt Raw Hem Organic Boro Constrast Denim">
								<figure><img src="{{ asset('images/food/'.$item->foo_thumbnail	) }}" width="800" height="800" alt=""></figure>
							</a>
							<div class="group-flash">
								<span class="flash-item sale-label">sale</span>
							</div>
							<div class="wrap-btn">
                                @auth('customer') 
								<a href="detail_product/{{ $item->foo_id }}" class="function-link">quick view</a>
							        @else
                                <a href="/login_site" class="function-link">quick view</a>
                                 @endauth
                              </div>
						</div>
						<div class="product-info">
							<div class="wrap-price"><span class="product-price">{{ $item->foo_name }}</span></div>
							<a href="#" class="product-name"><span>{{ $item->foo_info_en }}</span></a>
							<div class="wrap-price"><span class="product-price">${{ $item->foo_price}}</span></div>
						</div>
					</div>

					@endforeach

				</div>
			</div>

			<!--Latest Products-->
			<div class="wrap-show-advance-info-box style-1">
				<h3 class="title-box">Latest Products</h3>
				<div class="wrap-top-banner">
					<a href="#" class="link-banner banner-effect-2">
						<figure><img src="images/AddressShopCover.jpg" width="1170" height="240" alt=""></figure>
					</a>
				</div>
				<div class="wrap-products">
					<div class="wrap-product-tab tab-style-1">						
						<div class="tab-contents">
							<div class="tab-content-item active" id="digital_1a">
								<div class="wrap-products slide-carousel owl-carousel style-nav-1 equal-container" data-items="5" data-loop="false" data-nav="true" data-dots="false" data-responsive='{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"3"},"992":{"items":"4"},"1200":{"items":"5"}}' >

									@foreach ($products as $item)
										
									<div class="product product-style-2 equal-elem ">
										<div class="product-thumnail">
											<a href="" title="T-Shirt Raw Hem Organic Boro Constrast Denim">
												<figure><img src="{{ asset('images/food/'.$item->foo_thumbnail) }}" width="800" height="800" alt="T-Shirt Raw Hem Organic Boro Constrast Denim"></figure>
											</a>
											<div class="group-flash">
												<span class="flash-item new-label">new</span><br>
											</div>
											<div class="wrap-btn">
												@auth('customer')
												<a href="detail_product/{{ $item->foo_id }}" class="function-link">quick view</a>
												@else
												<a href="login_site" class="function-link">quick view</a>
												@endauth
												
											</div>
										</div>
										<div class="product-info">
											<div class="wrap-price"><span class="product-price">{{ $item->foo_name }}</span></div>
											<a href="" class="product-name"><span>{{ $item->foo_info_en }}</span></a>
											<div class="wrap-price"><span class="product-price">${{ $item->foo_price }}</span></div>
										</div>
									</div>

									@endforeach
								</div>
							</div>							
						</div>
					</div>
				</div>
			</div>

			<!--Product Categories-->
			<div id="cat" class="wrap-show-advance-info-box style-1">
				<h3 class="title-box">Product Categories</h3>
				<div class="wrap-top-banner">
					<a href="#" class="link-banner banner-effect-2">
						<figure><img src="assetssite/images/fashion-accesories-banner.jpg" width="70" height="240" alt=""></figure>
					</a>
				</div>
				<div class="wrap-products">
					<div class="wrap-product-tab tab-style-1">
			
						<div class="tab-control">
							@foreach ($category as $key=>$item)
							<a href="#cat_{{ $item->cat_id }}" class="tab-control-item {{ $key==0 ? 'active' : ''}}">{{ $item->cat_name }}</a>
						
							@endforeach
						</div>
						
							<div class="tab-contents">

							@foreach ($category as $key=>$item)
												
							<div class="tab-content-item {{ $key==0 ? 'active' : ''}}" id="cat_{{ $item->cat_id }}">
								<div class="wrap-products slide-carousel owl-carousel style-nav-1 equal-container" data-items="5" data-loop="false" data-nav="true" data-dots="false" data-responsive='{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"3"},"992":{"items":"4"},"1200":{"items":"5"}}' >
								@php 
								   $c_product = DB::table('food')->where('cat_id' , $item->cat_id)->get();
								@endphp
									@foreach ($c_product as $raw)
									<div class="product product-style-2 equal-elem ">
										<div class="product-thumnail">
											<a href="" title="T-Shirt Raw Hem Organic Boro Constrast Denim">
												<figure><img src="{{ asset('images/food/'.$raw->foo_thumbnail) }}" width="800" height="800" alt="T-Shirt Raw Hem Organic Boro Constrast Denim"></figure>
											</a>
											<div class="group-flash">
												<span class="flash-item new-label">new</span>
											</div>
											<div class="wrap-btn">
												@auth('customer')
												<a href="detail_product/{{ $raw->foo_id }}" class="function-link">quick view</a>
												@else
												<a href="login_site" class="function-link">quick view</a>
												@endauth
											</div>
										</div>
										<div class="product-info">
											<a href="#" class="product-name"><span>{{ $raw->foo_name }}</span></a>
											<div class="wrap-price"><span class="product-price">${{ $raw->foo_price }}</span></div>
										</div>
									</div>
									@endforeach
								
									

								</div>
							</div>
							


							@endforeach	

						</div>
						
					</div>
				</div>
			</div>			

		</div>

	</main>
		


@include('site.footer')


@endsection