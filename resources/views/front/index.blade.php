
<!DOCTYPE html>
<html lang="zxx">
<head>
		<meta charset="utf-8" />
		<meta name="author" content="Themezhub" />
		<meta name="viewport" content="width=device-width, initial-scale=1">

        <title>E-Book</title>
        <link href="{{ asset('frontend/assets/css/plugins/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/assets/css/plugins/font-awesome.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/assets/css/styles.css') }}" rel="stylesheet">

        {{-- My custome link --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
         {{-- Author : Nymul Islam Moon <towkir1997islam@gmail.com> Toaster CSS --}}
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <style>
            a {
                text-decoration: none;
                color: black;
            }
        </style>

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
							<div class="top_second"><a href="/" class="medium text-dark text-decoration-none"><h5>E-Book</h5></a></div>
						</div>

						<!-- Right Menu -->
						<div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">

							<div class="currency-selector dropdown js-dropdown float-right mr-3">
								@if ( auth()->check() )
                                    <a href="" class="text-muted medium"><i class="lni lni-user mr-1"></i><h5>{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h5></a>
                                @else
                                    <a href="{{ route('front.registration.index') }}" class="text-muted medium"><i class="lni lni-user mr-1"></i>Sign Up</a> | <a href="{{ route('admin.login') }}" class="text-muted medium"><i class="lni lni-user mr-1"></i>Sign In</a>
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
								<h2 class="off_title">Books</h2>
								<h3 class="ft-bold pt-3">Books</h3>
							</div>
						</div>
					</div>

                    <form method="GET">
                        <div class="input-group mb-3">
                            <input
                            type="text"
                            name="search"
                            value="{{ request()->get('search') }}"
                            class="form-control"
                            placeholder="Search..."
                            aria-label="Search"
                            aria-describedby="button-addon2">
                            <select class="form-control" id="" name="category">
                                <option value="" selected>Select Categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" >{{ $category->name }}</option>
                                @endforeach

                            </select>
                            <button class="btn btn-success" type="submit" id="button-addon2">Search</button>
                        </div>
                    </form>

					<div class="row align-items-center rows-products">
						<!-- Single -->
                        @foreach ($books as $book)
                            <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                                <div class="product_grid card b-0">
                                    <div class="card-body p-0">
                                        <div class="shop_thumb position-relative">
                                            <button class="card-img-top d-block overflow-hidden read-book" href="shop-single-v1.html"><img class="card-img-top" src="{{ asset('uploads/books/img/' . $book->img) }}" alt="..."></button>
                                        </div>
                                    </div>
                                    <div class="card-footer b-0 p-0 pt-2 bg-white d-flex align-items-start justify-content-between">
                                        <div class="" style="text-align: center">
                                            <div>
                                                {{-- <div class="elso_titl"><span class="small">{{ $book->books_category }}</span></div> --}}
                                                <h1 class=""><a href="{{ route('front.book.show', $book->id) }}">{{ $book->name }}</a></h1>
                                                {{-- <div class="elis_rty"><span class="ft-bold text-dark fs-sm">$99 - $129</span></div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

					</div>

					<div class="row justify-content-center">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">

						</div>
					</div>

				</div>
			</section>
		</div>

        <!-- Button trigger modal -->

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
         {{--
            Author: Nymul Islam Moon <towkir1997islam@gmail.com>
            Toaster CDN
        --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
		<script>
            $(document).ready(function(){

                /**
                 * Author Name : Nymul Islam Moon <towkir1997islam@gmail.com>
                 * Show Messages
                 *
                 * */

                @if (Session::has('message'))
                    var type="{{ Session::get('alert-type', 'info') }}"
                    switch(type) {
                        case 'info':
                            toastr.info('{{ Session::get('message') }}');
                            break;
                        case 'success':
                            toastr.success('{{ Session::get('message') }}');
                            break;
                        case 'warning':
                            toastr.warning('{{ Session::get('message') }}');
                            break;
                        case 'error':
                            toastr.error('{{ Session::get('message') }}');
                            break;
                    }
                @endif
            });
		</script>
	</body>

</html>
