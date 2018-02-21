<nav class="navbar navbar-inverse navbar-static-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">CryptoPlus</a>
        <ul class="nav navbar-nav">

            @if(Auth::user() instanceof App\Admin)
                <li class="{{Request::is('admin/home') ? "active" : ""}}"><a href="{{url('admin/home')}}">Home <span class="sr-only">(current)</span></a></li>
                <li class="{{Request::is('admin/users') ? "active" : ""}}"><a href="{{ route('admin.users') }}">Korisnici</a></li>&nbsp;
                <li class="{{Request::is('admin/provision') ? "active" : ""}}"><a href="{{ route('admin.showProvision') }}">Provizije</a></li>
                <li class="{{Request::is('admin/categories') ? "active" : ""}}"><a href="{{ route('admin.showCategories') }}">Kategorije</a></li>
                <li class="{{Request::is('admin/currencies') ? "active" : ""}}"><a href="{{ route('admin.showCurrencies') }}">Kripto Valute</a></li>
                <li class="{{Request::is('admin/orders') ? "active" : ""}}"><a href="{{ route('admin.showOrders') }}">Porudžbine</a></li>
                <li class="{{Request::is('admin/orders') ? "active" : ""}}"><a href="{{ route('admin.showOrders') }}">Podešavanja</a></li>
                <li class="{{Request::is('admin/orders') ? "active" : ""}}"><a href="{{ route('admin.showOrders') }}">Wallet-i</a></li>
        </ul>
                <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                        {{ Auth::user() instanceof App\Admin ? ucfirst(Auth::user()->username) : Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
                </ul>
            @elseif(Auth::user() instanceof App\User)

                <li class="{{Request::is('home') ? "active" : ""}}"><a href="{{url('home')}}">Home <span class="sr-only">(current)</span></a></li>
                <li class="{{Request::is('user/myAccount') ? "active" : ""}}"><a href="{{route('user.myAccount')}}">Moj Nalog</a></li>
                <li class="{{Request::is('user/buysell') ? "active" : ""}}"><a href="{{route('user.buysell')}}">Kupovina/Prodaja</a></li>

            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                        {{ Auth::user() instanceof App\User ? ucfirst(Auth::user()->username) : Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
            @else
            <li class="{{Request::is('home') ? "active" : ""}}"><a href="{{url('home')}}">Home <span class="sr-only">(current)</span></a></li>
        </ul>
            @endif


            @guest
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}">Register</a></li>
            </ul>
            @endguest
    </div>
</nav>


