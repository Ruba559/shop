<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield("title")</title>
	<link rel="shortcut icon" type="image/x-icon" href="assetesite/images/favicon.ico">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,400italic,700,700italic,900,900italic&amp;subset=latin,latin-ext" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Open%20Sans:300,400,400italic,600,600italic,700,700italic&amp;subset=latin,latin-ext" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ asset('assetssite/css/animate.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assetssite/css/font-awesome.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assetssite/css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assetssite/css/owl.carousel.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assetssite/css/chosen.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assetssite/css/style.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assetssite/css/color-01.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assetssite/css/flexslider.css') }}">

 @yield('content_head')
 
</head>

     @yield('content')
 
    <script src="{{ asset('assetssite/js/jquery-1.12.4.minb8ff.js?ver=1.12.4') }}"></script>
	<script src="{{ asset('assetssite/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('assetssite/js/chosen.jquery.min.js') }}"></script>
	<script src="{{ asset('assetssite/js/owl.carousel.min.js') }}"></script>
	<script src="{{ asset('assetssite/js/jquery.countdown.min.js') }}"></script>
	<script src="{{ asset('assetssite/js/jquery.sticky.js') }}"></script>
	<script src="{{ asset('assetssite/js/functions.js') }}"></script>
	<script src="{{ asset('assetssite/js/flexslider.js') }}"></script>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js" integrity="sha512-HWlJyU4ut5HkEj0QsK/IxBCY55n5ZpskyjVlAoV9Z7XQwwkqXoYdCIC93/htL3Gu5H3R4an/S0h2NXfbZk3g7w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	
	<script>

		var path = "{{route('autocomplete')}}";
		
		 $('input.typeahead').typeahead({
			  source:  function (query, process) {
			  return $.get(path, { term: query }, function (data) {
					  return process(data);
				  });
			  }
		  });
		
		</script>

    <script>

	$(document).on('click', '.cat', function(){
	
		var category_id = $(this).attr('category_id');
	
		$(".category_name").val(category_id);
	
		  });
	
	</script>
		
		 <script>
			$(".aboutus").click(function(e){
				e.preventDefault();
				$.ajax({
					url: "index_about-us",
					type: "GET",
					success:function(data){
						$("#main").replaceWith(data);
					}
				})
			})

		</script>

	
</body>
</html>