        <header class="header_in is_sticky menu_fixed">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-12">
                        <div id="logo">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset('logox.png') }}" width="165" height="35" alt="" class="logo_sticky">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-9 col-12">
                        <!-- /top_menu -->
                        <a href="#menu" class="btn_mobile">
                            <div class="hamburger hamburger--spin" id="hamburger">
                                <div class="hamburger-box">
                                    <div class="hamburger-inner"></div>
                                </div>
                            </div>
                        </a>
                        <nav id="menu" class="main-menu">
                            <ul>
                                <li><a href="{{ route('home') }}">Home</a></li>
                                
                                @foreach($pages as $page)
                                    <li><a href="{{ route('page.show', $page->slug) }}">{{ ucfirst($page->title) }}</a></li>
                                @endforeach                                
                                @guest
                                    <li><a href="{{ route('register') }}" class="text">Provider Sign-Up</a></li>
                                    <li><a href="{{ route('login') }}" class="" title="Sign In">Sign In</a></li>
                                @else
                                    <li><a href="{{ route('dashboard') }}" class="">Dashboard</a></li>
                                @endguest                            
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->		
        </header>         
