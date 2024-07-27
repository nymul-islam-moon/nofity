
<!DOCTYPE html>
<html lang="en">
@include('layouts.frontend.header')
<body>

    @yield('frontend_content')

    @include('layouts.frontend.scripts')

    @stack('frontend_js')
</body>
</html>
