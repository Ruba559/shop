<!DOCTYPE html>
<html lang="en">
	@extends('site.app')

	@section('content_head')
	
	@endsection
	
	@section('title')
	
	@endsection
	
	@section('content')

<body class="inner-page about-us ">

	<!-- mobile menu -->
    <div class="mercado-clone-wrap">
        <div class="mercado-panels-actions-wrap">
            <a class="mercado-close-btn mercado-close-panels" href="#">x</a>
        </div>
        <div class="mercado-panels"></div>
    </div>

	@include('site.header')
	
	<!--main area-->
	<main id="main" class="main-site">

		<div class="container">

			<div class="wrap-breadcrumb">
				<ul>
					<li class="item-link"><a href="/" class="link">home</a></li>
			 		<li class="item-link"><span>Thank You</span></li>
				</ul>
			</div>
		</div>
		
		<div class="container pb-60">
			<div class="row">
				<div class="col-md-12 text-center">
					<h2>Thank you for your order</h2>
                    <p>A confirmation email was sent.</p>
                    <a href="/" class="btn btn-submit btn-submitx">Continue Shopping</a>
				</div>
			</div>
		</div><!--end container-->

	</main>
	<!--main area-->

	@include('site.footer')

	<script>
    
		function everyTime() {
			
			// $('form').submit(function( event ) {
			// 	event.preventDefault();
			
				$.ajax({
					url: '/updatetime',
					type: 'get',
					data: {
						_token: '{{ csrf_token() }}', 
					}, // Remember that you need to have your csrf token included
					dataType: 'json',
					success: function( _response ){
						// Handle your response..
					},
					error: function( _response ){
						// Handle error
					}
				});
			// });
		}
		
		var myInterval = setInterval(everyTime, 1000 * 60);
	
		</script>

@endsection