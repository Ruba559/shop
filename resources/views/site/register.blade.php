@extends('site.app')

@section('content_head')

@endsection

@section('title')

@endsection

@section('content')

<body class="home-page home-01 ">

	<!-- mobile menu -->
    <div class="mercado-clone-wrap">
        <div class="mercado-panels-actions-wrap">
            <a class="mercado-close-btn mercado-close-panels" href="#">x</a>
        </div>
        <div class="mercado-panels"></div>
    </div>

	@include('site.header')
	
	<!--main area-->
	<main id="main" class="main-site left-sidebar">

		<div class="container">

			<div class="wrap-breadcrumb">
				<ul>
					<li class="item-link"><a href="#" class="link">home</a></li>
					<li class="item-link"><span>Register</span></li>
				</ul>
			</div>
			<div class="row">
				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 col-md-offset-3">							
					<div class=" main-content-area">
						<div class="wrap-login-item ">
							<div class="register-form form-item ">
                                                              <form class="form-stl" name="frm-login" method="POST" action="{{ route('register') }}">
                                                                     @csrf
								
									<fieldset class="wrap-title">
										<h3 class="form-title">Create an account</h3>
										<h4 class="form-subtitle">Personal infomation</h4>
									</fieldset>									
									<fieldset class="wrap-input">
										<label for="frm-reg-lname">Name*</label>
										<input type="text" id="frm-reg-lname" name="cus_name" value="{{ old('cus_name') }}" placeholder="Last name*">
									
                                @error('cus_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                                                        </fieldset>
									<fieldset class="wrap-input">
										<label for="frm-reg-email">Email Address</label>
										<input type="email" id="frm-reg-email" name="cus_email" value="{{ old('cus_email') }}" placeholder="Email address">
									
                                @error('cus_email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror  
                                                                                 </fieldset>
							<fieldset class="wrap-input">
										<label for="frm-reg-email">Phone</label>
										<input type="text" id="frm-reg-email" name="cus_mobile" value="{{ old('cus_mobile') }}" placeholder="Phone">
									
                                @error('cus_mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                                           </fieldset>
				                                    <fieldset class="wrap-input">
										<label for="frm-reg-email">Address</label>
										<input type="text" id="frm-reg-email" name="cus_address" value="{{ old('cus_address') }}" placeholder="Address">
									
                                @error('cus_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror 
                                                                      </fieldset>
									
									 
									<fieldset class="wrap-input item-width-in-half left-item ">
										<label for="frm-reg-pass">Password *</label>
										<input type="text" id="frm-reg-pass" name="cus_pwd" placeholder="Password">
									</fieldset>
									<fieldset class="wrap-input item-width-in-half ">
										<label for="frm-reg-cfpass">Confirm Password *</label>
										<input type="text" id="frm-reg-cfpass" name="password_confirmation" placeholder="Confirm Password">
									</fieldset>
									<input type="submit" class="btn btn-sign" value="Register" name="register">
								</form>
							</div>											
						</div>
					</div><!--end main products area-->		
				</div>
			</div><!--end row-->

		</div><!--end container-->

	</main>
	<!--main area-->

	@include('site.footer')

	@endsection