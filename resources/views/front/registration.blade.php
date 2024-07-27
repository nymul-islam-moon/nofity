
<!DOCTYPE html>
<html lang="zxx">
<head>
		<meta charset="utf-8" />
		<meta name="author" content="Themezhub" />
		<meta name="viewport" content="width=device-width, initial-scale=1">

        <title>E-Book</title>

        <!-- Custom CSS -->
        {{-- <link href="{{ asset('frontend/assets/css/plugins/animation.css') }}" rel="stylesheet"> --}}
        <link href="{{ asset('frontend/assets/css/plugins/bootstrap.min.css') }}" rel="stylesheet">
        {{-- <link href="{{ asset('frontend/assets/css/plugins/flaticon.css') }}" rel="stylesheet"> --}}
        <link href="{{ asset('frontend/assets/css/plugins/font-awesome.css') }}" rel="stylesheet">
        {{-- <link href="{{ asset('frontend/assets/css/plugins/iconfont.css') }}" rel="stylesheet"> --}}
        {{-- <link href="{{ asset('frontend/assets/css/plugins/ion.rangeSlider.min.css') }}" rel="stylesheet"> --}}
        {{-- <link href="{{ asset('frontend/assets/css/plugins/light-box.css') }}" rel="stylesheet"> --}}
        {{-- <link href="{{ asset('frontend/assets/css/plugins/line-icons.css') }}" rel="stylesheet"> --}}
        {{-- <link href="{{ asset('frontend/assets/css/plugins/slick-theme.css') }}" rel="stylesheet"> --}}
        {{-- <link href="{{ asset('frontend/assets/css/plugins/slick.css') }}" rel="stylesheet"> --}}
        {{-- <link href="{{ asset('frontend/assets/css/plugins/snackbar.min.css') }}" rel="stylesheet"> --}}
        {{-- <link href="{{ asset('frontend/assets/css/plugins/themify.css') }}" rel="stylesheet"> --}}
        <link href="{{ asset('frontend/assets/css/styles.css') }}" rel="stylesheet">

        {{-- My custome link --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    </head>

    <body>

		<!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <div id="main-wrapper">

            <!-- ============================================================== -->
            <!-- Top header  -->
            <!-- ============================================================== -->
			<!-- Top Header -->
			<div class="py-2 br-bottom">
				<div class="container">
					<div class="row">

						<div class="col-xl-7 col-lg-6 col-md-6 col-sm-12 hide-ipad">
							<div class="top_second"><p class="medium"><a href="/" class="medium text-dark text-decoration-none">E-Book</a></a></p></div>
						</div>

						<!-- Right Menu -->
						<div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">
							<div class="currency-selector dropdown js-dropdown float-right mr-3">
                                @if ( auth()->check() )
                                    <a href="" class="text-muted medium"><i class="lni lni-user mr-1"></i>{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</a>
                                @else
                                    <a href="{{ route('admin.login') }}" class="text-muted medium"><i class="lni lni-user mr-1"></i>Sign In</a> | <a href="{{ route('front.registration.index') }}" class="text-muted medium"><i class="lni lni-user mr-1"></i>Sign Up</a>
                                @endif
							</div>
						</div>

					</div>
				</div>
			</div>

			<section class="middle">
				<div class="container">

					<div class="row justify-content-center">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
							<div class="sec_title position-relative text-center">
								<h2 class="off_title">Registration</h2>
								<h3 class="ft-bold pt-3">Registration</h3>
							</div>
						</div>
					</div>

					<div class="row align-items-center rows-products">
                        <form class="row g-3" action="{{ route('front.registration.store') }}" method="POST">
                            @csrf
                            <div class="col-md-6">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" name="first_name" class="form-control" id="first_name" placeholder="Enter First Name">
                                @error('first_name')
                                    {{ $message }}
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Enter Last Name">
                                @error('last_name')
                                    {{ $message }}
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email">
                                @error('email')
                                    {{ $message }}
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" name="phone" class="form-control" id="phone" placeholder="Enter Phone">
                                @error('phone')
                                    {{ $message }}
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="inputState" class="form-label">Gender</label>
                                <select id="inputState" name="gender" class="form-select">
                                    <option selected>Choose Gender</option>
                                    <option value="1">Male</option>
                                    <option value="2">Female</option>
                                </select>
                                @error('gender')
                                    {{ $message }}
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" class="form-control" id="address" placeholder="Enter Address">
                            </div>
                            <div class="col-md-6">
                                <label for="inputPassword4" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="inputPassword4" placeholder="Enter Password">
                                @error('password')
                                    {{ $message }}
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Enter Confirm Password">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Sign Up</button>
                            </div>
                        </form>
					</div>

					<div class="row justify-content-center">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12"></div>
					</div>
				</div>
			</section>
		</div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script>

		</script>
	</body>

</html>
