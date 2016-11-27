<!DOCTYPE html>
<html lang="en">
@include('partials.meta')
<body>
    <div id="app">
        @include('partials.nav')
        <div class="container">
            @yield('content')
        </div>
    </div>
    @include('partials.scripts')
</body>
</html>
