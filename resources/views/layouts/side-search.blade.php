<!DOCTYPE html>
<html lang="en">
@include('partials.meta')
<body>
<div id="app">
    @include('partials.nav')
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-xs-12">
                @yield('content')
            </div>
            <div class="col-sm-3 col-xs-12">
                <search></search>
            </div>
        </div>
        <client-entry></client-entry>
        <site-entry></site-entry>
    </div>
    @include('partials.footer')
</div>
@include('partials.scripts')
</body>
</html>
