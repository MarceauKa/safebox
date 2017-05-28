<!DOCTYPE html>
<html lang="en">
@include('partials.meta')
<body>
<div id="app">
    @include('partials.nav')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <search></search>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                @yield('content')
            </div>
        </div>
        <client-entry></client-entry>
        <site-entry></site-entry>
        <account-entry></account-entry>
    </div>
    @include('partials.footer')
</div>
@include('partials.scripts')
</body>
</html>
