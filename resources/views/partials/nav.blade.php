<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ url('img/logo.png') }}" alt="{{ config('app.name', 'Safebox') }}" class="img-responsive">
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            @if(Auth::guest() === false)
                <ul class="nav navbar-nav">
                    <li><a href="{{ route('backend.clients') }}">{{ trans('app.pages.clients') }}</a></li>
                    <li><a href="{{ route('backend.sites') }}">{{ trans('app.pages.sites') }}</a></li>
                    <li><a href="{{ route('backend.accounts') }}">{{ trans('app.pages.accounts') }}</a></li>
                </ul>
                @endif
                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">{{ trans('app.pages.login') }}</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ url('/logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ trans('app.pages.logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
        </div>
    </div>
</nav>