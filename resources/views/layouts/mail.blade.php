<!DOCTYPE html>
<html lang="en">
<head>

    @include('partials._head')

</head>

<body>

<div class="container">

@yield('content')

</div><!--End of .container-->
@include('partials._javascript')

@yield('scripts')
</body>
</html>