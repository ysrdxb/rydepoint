@php 
    $pages = \App\Models\Page::get();
    $settings = \App\Models\Setting::whereIn('key', [
        'address', 'phone', 'email', 'facebook', 'twitter', 'google', 'pinterest'
    ])->pluck('value', 'key');
@endphp

@include('layouts.head')

<body>
	<div id="page">
		@include('layouts.header')
        <main>
            @if(isset($slot))
                {{ $slot }}
            @else
                @yield('content')
            @endif                 
        </main>

        <footer class="plus_border">
            <div class="container margin_60_35">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <h3 data-bs-target="#collapse_ft_1">Quick Links</h3>
                        <div class="collapse dont-collapse-sm" id="collapse_ft_1">
                            <ul class="links">
                                @foreach($pages as $page)
                                    <li><a href="{{ route('page.show', $page->slug) }}">{{ ucfirst($page->title) }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
        
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <h3 data-bs-target="#collapse_ft_3">Contacts</h3>
                        <div class="collapse dont-collapse-sm" id="collapse_ft_3">
                            <ul class="contacts">
                                <li><i class="ti-home"></i>{{ $settings['address'] ?? 'Abc Street. 123, Dubai - AE' }}</li>
                                <li><i class="ti-headphone-alt"></i>{{ $settings['phone'] ?? '+971 555 689376' }}</li>
                                <li><i class="ti-email"></i><a href="mailto:{{ $settings['email'] ?? 'info@creativezon.com' }}">{{ $settings['email'] ?? 'info@creativezon.com' }}</a></li>
                            </ul>
                        </div>
                    </div>
        
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <h3 data-bs-target="#collapse_ft_4">Keep in touch</h3>
                        <div class="collapse dont-collapse-sm" id="collapse_ft_4">
                            <div id="newsletter">
                                <div id="message-newsletter"></div>
                                <form method="post" action="" name="newsletter_form" id="newsletter_form">
                                    <div class="form-group">
                                        <input type="email" name="email_newsletter" id="email_newsletter" class="form-control" placeholder="Your email">
                                        <input type="submit" value="Submit" id="submit-newsletter">
                                    </div>
                                </form>
                            </div>
                            <div class="follow_us">
                                <h5>Follow Us</h5>
                                <ul>
                                    <li><a href="{{ $settings['facebook'] ?? '#' }}"><i class="ti-facebook"></i></a></li>
                                    <li><a href="{{ $settings['twitter'] ?? '#' }}"><i class="ti-twitter-alt"></i></a></li>
                                    <li><a href="{{ $settings['google'] ?? '#' }}"><i class="ti-google"></i></a></li>
                                    <li><a href="{{ $settings['pinterest'] ?? '#' }}"><i class="ti-pinterest"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /row-->
                <hr>
                <div class="row">
                    <div class="col-lg-6">
                        <ul id="footer-selector">
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <ul id="additional_links">
                            <li><a href="#0">Terms and conditions</a></li>
                            <li><a href="#0">Privacy</a></li>
                            <li><span>© {{ date('Y') }} Rydepoint</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>    

    <script src="{{ asset('assets/js/common_scripts.js') }}"></script>
	<script src="{{ asset('assets/js/functions.js') }}"></script>
	<script src="{{ asset('assets/assets/validate.js') }}"></script>
        
    @stack('scripts')
</body>
</html>