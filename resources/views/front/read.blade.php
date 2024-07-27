
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

        <style>
            a {
                text-decoration: none;
                color: black;
            }
            iframe {
                height: 1000%;
                width: 100%;
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
                                    <a href="{{ route('front.registration.index') }}" class="text-muted medium"><i class="lni lni-user mr-1"></i>Sign Up</a>
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


					<div class="row justify-content-center">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <iframe src="{{ asset('uploads/books/file') }}/{{ $book->file }}" frameborder="0" allowfullscreen></iframe>
						</div>
					</div>

				</div>
			</section>
		</div>

        <!-- Button trigger modal -->

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script>

		</script>
	</body>

</html>
