@php
	$setting = DB::table('settings')->get()->first();
	$page_one = DB::table('pages')->where('page_position',1)->get();
	$page_two = DB::table('pages')->where('page_position',2)->get();
@endphp
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="OneTech shop project">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/styles/bootstrap4/bootstrap.min.css">
    <link href="{{asset('frontend')}}/plugins/fontawesome-free-5.0.1/css/fontawesome-all.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/plugins/OwlCarousel2-2.2.1/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
    <link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/plugins/OwlCarousel2-2.2.1/animate.css">
    <link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/plugins/slick-1.8.0/slick.css">
    <link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/styles/main_styles.css">
    <link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/styles/responsive.css">

	{{-- For Popup  --}}
	<link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/toastr/toastr.css') }}">

	<link rel="stylesheet" href="{{ asset('backend') }}/custom/style.css">
</head>

<body>

<div class="super_container">
	
	<!-- Header -->
	
	<header class="header">

		        <!-- Top Bar -->

				<div class="top_bar">
					<div class="container">
						<div class="row">
							<div class="col d-flex flex-row">
								<div class="top_bar_contact_item"><div class="top_bar_icon"><img src="images/phone.png" alt=""></div>{{ $setting->phone_one }}</div>
								<div class="top_bar_contact_item"><div class="top_bar_icon"><img src="images/mail.png" alt=""></div><a href="mailto:{{ $setting->main_email }}">{{ $setting->main_email }}</a></div>
								<div class="top_bar_content ml-auto">								   
									@if(Auth::check())
									<div class="top_bar_menu">
										<ul class="standard_dropdown top_bar_dropdown" >
											<li>
												<a href="#">{{ Auth::user()->name }}<i class="fas fa-chevron-down"></i></a>
												<ul style="width:200px;">
													<li><a href="{{ route('home') }}">Profile</a></li>
													<li><a href="{{ route('customer.logout') }}">Logout</a></li>
												</ul>
											</li>
										  
										</ul>
									</div>
									@endif
		
									@guest
									<div class="top_bar_menu">
										<ul class="standard_dropdown top_bar_dropdown">
											<li>
												<a href="#">Login<i class="fas fa-chevron-down"></i></a>
												<ul style="width:300px; padding:10px;">
												   <div>
													<strong>login your account</strong><br>
													<br>
													   <form action="{{route('customer.login')}}" method="post">
														@csrf
														   <div class="form-group">
															   <label>Email Address</label>
															   <input type="email" class="form-control" name="email" autofocus>
														   </div>
														   <div class="form-group">
															   <label>Password</label>
															   <input type="password" class="form-control" name="password" required="">
														   </div>
														   <div class="form-group row">
															   <div class="offset-md-2">
																   <div class="form-check">
																	   <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
		
																	   <label class="form-check-label" for="remember">
																		   {{ __('Remember Me') }}
																	   </label>
																   </div>
															   </div>
														   </div>
														   <div class="form-group">
															   <button type="submit" class="btn btn-sm btn-info w-100">login</button>
															   <a class="btn btn-link m-0" href="{{ route('password.request') }}">
																{{ __('Forget Your Password') }}
															</a>
														   </div>
													   </form>
												   </div>
												</ul>
											</li>
											<li class="register">
												<a href="{{route('customer.register')}}">Register<i class="fas fa-chevron-down"></i></a>
											</li>
										</ul>
									</div>
									@endguest
								</div>
							</div>
						</div>
					</div>      
				</div>
		
				<!-- Header Main -->

		<div class="header_main">
			<div class="container">
				<div class="row">

					<!-- Logo -->
					<div class="col-lg-2 col-sm-3 col-3 order-1">
						<div class="logo_container">
							<div class="logo"><a href="{{route('index')}}">OneTech</a></div>
						</div>
					</div>

					<!-- Search -->
					<div class="col-lg-6 col-12 order-lg-2 order-3 text-lg-left text-right">
						<div class="header_search">
							<div class="header_search_content">
								<div class="header_search_form_container">
									<form action="#" class="header_search_form clearfix">
										<input type="search" required="required" class="header_search_input" placeholder="Search for products...">
										<div class="custom_dropdown">
											<div class="custom_dropdown_list">
												<span class="custom_dropdown_placeholder">All Categories</span>
												<i class="fas fa-chevron-down"></i>
												<ul class="custom_list clc">
													<li><a class="clc" href="#">All Categories</a></li>
													<li><a class="clc" href="#">Computers</a></li>
													<li><a class="clc" href="#">Laptops</a></li>
													<li><a class="clc" href="#">Cameras</a></li>
													<li><a class="clc" href="#">Hardware</a></li>
													<li><a class="clc" href="#">Smartphones</a></li>
												</ul>
											</div>
										</div>
										<button type="submit" class="header_search_button trans_300" value="Submit"><img src="images/search.png" alt=""></button>
									</form>
								</div>
							</div>
						</div>
					</div>

					<!-- Wishlist -->
					@php
						$wishlist = DB::table('wishlists')->where('user_id',Auth::id())->count();
					@endphp
					<div class="col-lg-4 col-9 order-lg-3 order-2 text-lg-left text-right">
						<div class="wishlist_cart d-flex flex-row align-items-center justify-content-end">
							<div class="wishlist d-flex flex-row align-items-center justify-content-end">
								<div class="wishlist_icon"><img src="images/heart.png" alt=""></div>
								<div class="wishlist_content">
									<div class="wishlist_text"><a href="{{route('wishlist')}}">Wishlist</a></div>
									<div class="wishlist_count">{{$wishlist}}</div>
								</div>
							</div>

							<!-- Cart -->
                            <div class="cart">
                                <div class="cart_container d-flex flex-row align-items-center justify-content-end">
                                    <div class="cart_icon">
                                        <img src="{{ asset('frontend') }}/images/cart.png" alt="">
                                        <div class="cart_count"><span class="cart_qty"></span></div>
                                    </div>
                                    <div class="cart_content">
                                        <div class="cart_text"><a href="{{route('cart')}}">Cart</a></div>
                                        <div class="cart_price">{{ $setting->currency }} <span class="cart_total"></span></div>
                                    </div>
                                </div>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Main Navigation -->
		@yield('navbar')
	</header>
	
	<!-- Banner -->
	@yield('content')
	<!-- Footer -->

	<footer class="footer">
		<div class="container">
			<div class="row">

				<div class="col-lg-3 footer_col">
					<div class="footer_column footer_contact">
						<div class="logo_container">
							<div class="logo"><a href="#">OneTech</a></div>
						</div>
						<div class="footer_title">Got Question? Call Us 24/7</div>
						<div class="footer_phone">+38 068 005 3570</div>
						<div class="footer_contact_text">
							<p>17 Princess Road, London</p>
							<p>Grester London NW18JR, UK</p>
						</div>
						<div class="footer_social">
							<ul>
								<li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
								<li><a href="#"><i class="fab fa-twitter"></i></a></li>
								<li><a href="#"><i class="fab fa-youtube"></i></a></li>
								<li><a href="#"><i class="fab fa-google"></i></a></li>
								<li><a href="#"><i class="fab fa-vimeo-v"></i></a></li>
							</ul>
						</div>
					</div>
				</div>

				<div class="col-lg-2 offset-lg-2">
					<div class="footer_column">
						<div class="footer_title">Others Page</div>
						<ul class="footer_list">
							@foreach ($page_one as $row)
								<li><a href="{{route('view.page',$row->page_slug)}}">{{$row->page_name}}</a></li>
							@endforeach
						</ul>
					</div>
				</div>

				<div class="col-lg-2">
					<div class="footer_column">
						<ul class="footer_list footer_list_2">
							@foreach ($page_two as $row)
								<li><a href="{{route('view.page',$row->page_slug)}}">{{$row->page_name}}</a></li>
							@endforeach
						</ul>
					</div>
				</div>

				<div class="col-lg-2">
					<div class="footer_column">
						<div class="footer_title">Customer Care</div>
						<ul class="footer_list">
							<li><a href="#">My Account</a></li>
							<li><a href="{{route('order.tracking')}}">Order Tracking</a></li>
							<li><a href="#">Wish List</a></li>
							<li><a href="#">Customer Services</a></li>
							<li><a href="#">Returns / Exchange</a></li>
							<li><a href="#">FAQs</a></li>
							<li><a href="#">Product Support</a></li>
						</ul>
					</div>
				</div>

			</div>
		</div>
	</footer>

	<!-- Copyright -->

	<div class="copyright">
		<div class="container">
			<div class="row">
				<div class="col">
					
					<div class="copyright_container d-flex flex-sm-row flex-column align-items-center justify-content-start">
						<div class="copyright_content"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
						<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						</div>
						<div class="logos ml-sm-auto">
							<ul class="logos_list">
								<li><a href="#"><img src="images/logos_1.png" alt=""></a></li>
								<li><a href="#"><img src="images/logos_2.png" alt=""></a></li>
								<li><a href="#"><img src="images/logos_3.png" alt=""></a></li>
								<li><a href="#"><img src="images/logos_4.png" alt=""></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="{{ asset('frontend') }}/js/jquery-3.3.1.min.js"></script>
<script src="{{ asset('frontend') }}/styles/bootstrap4/popper.js"></script>
<script src="{{ asset('frontend') }}/styles/bootstrap4/bootstrap.min.js"></script>
<script src="{{ asset('frontend') }}/plugins/greensock/TweenMax.min.js"></script>
<script src="{{ asset('frontend') }}/plugins/greensock/TimelineMax.min.js"></script>
<script src="{{ asset('frontend') }}/plugins/scrollmagic/ScrollMagic.min.js"></script>
<script src="{{ asset('frontend') }}/plugins/greensock/animation.gsap.min.js"></script>
<script src="{{ asset('frontend') }}/plugins/greensock/ScrollToPlugin.min.js"></script>
<script src="{{ asset('frontend') }}/plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
<script src="{{ asset('frontend') }}/plugins/slick-1.8.0/slick.js"></script>
<script src="{{ asset('frontend') }}/plugins/easing/easing.js"></script>
<script src="{{ asset('frontend') }}/js/custom.js"></script>
<script src="{{ asset('frontend') }}/js/product_custom.js"></script>
<script type="text/javascript" src="{{ asset('backend/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('backend/plugins/sweetalert/sweetalert.min.js') }}"></script>

<script type="text/javascript" charset="utf-8">
    function cart() {
         $.ajax({
            type:'get',
            url:'{{ route('all.cart') }}', 
            dataType: 'json',
            success:function(data){
               $('.cart_qty').empty();
               $('.cart_total').empty();
               $('.cart_qty').append(data.cart_qty);
               $('.cart_total').append(data.cart_total);
            }
        });
    }
    $(document).ready(function(event) {
        cart();
    });    
 </script>
 <script>  
	$(document).on("click", ".delete", function(e){
		e.preventDefault();
		var link = $(this).attr("href");
		   swal({
			 title: "Are you Want to delete?",
			 text: "Once Delete, This will be Permanently Delete!",
			 icon: "warning",
			 buttons: true,
			 dangerMode: true,
		   })
		   .then((willDelete) => {
			 if (willDelete) {
				  window.location.href = link;
			 } else {
			   swal("Safe Data!");
			 }
		   });
	   });
  </script>
<script>
 @if(Session::has('message'))
   var type="{{Session::get('alert-type','info')}}"
   switch(type){
       case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;
       case 'success':
           toastr.success("{{ Session::get('message') }}");
           break;
       case 'warning':
          toastr.warning("{{ Session::get('message') }}");
           break;
       case 'error':
           toastr.error("{{ Session::get('message') }}");
           break;
         }
 @endif
</script>
</body>

</html>