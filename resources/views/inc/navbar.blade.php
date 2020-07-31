<nav class="navbar navbar-inverse navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'PHUNIN') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">

                        @guest
                            <!-- -->
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                        {{Lang::get('menu.list')}} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{route('spare_parts.index')}}">{{Lang::get('spare_part.title')}}</a></li>
                                    <li><a href="{{route('units.index')}}">{{Lang::get('unit.title')}}</a></li>
                                    <li><a href="{{route('categories.index')}}">{{Lang::get('category.title')}}</a></li>
                                    <li><a href="{{route('positions.index')}}">{{Lang::get('position.title')}}</a></li>
                                    <li><a href="{{route('shops.index')}}">{{Lang::get('shop.title')}}</a></li>
                                    <li><a href="{{route('departments.index')}}">{{Lang::get('department.title')}}</a></li>
                                    <li><a href="{{route('machines.index')}}">{{Lang::get('machine.title')}}</a></li>
                                    <li><a href="{{route('employees.index')}}">{{Lang::get('employee.title')}}</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                        {{Lang::get('menu.store')}} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{route('stock_ins.index')}}">{{Lang::get('stock_in.title')}}</a></li>
                                    <li><a href="{{route('stock_outs.index')}}">{{Lang::get('stock_out.title')}}</a></li>
                                    <li><a href="{{route('repairments.index')}}">{{Lang::get('repairment.title')}}</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                        {{Lang::get('menu.report')}} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{route('reports.index')}}">{{Lang::get('report.title')}}</a></li>
                                </ul>
                            </li>
                        @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    {{ Auth::user()->name }} <span class="caret"></span>
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
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>