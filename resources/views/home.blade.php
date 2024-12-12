@extends('layouts.app')
@push('head')
<style>
.call_section .wrapper {
    background-color: rgb(0, 113, 188) !important;
    position: relative;
    z-index: 22;
}
@media (max-width:767px) {
    .logo-img {
        max-width: 250px !important;
    }
}
.hero_single {
    position: relative;
    overflow: hidden;
    padding: 100px 0;
    background-color: rgba(0, 0, 0, 0.7);
}
.main_title_2 h2{
	margin: 0px !important;
	padding: 25px 25px !important;
}
.hero_single .overlay {
    background-size: cover !important;
    background-repeat: no-repeat;
    background-position: center;
    background-attachment: fixed;
    filter: brightness(0.6);
    z-index: 1;
}
.hero_single .wrapper {
    position: relative;
    z-index: 2;
    padding: 0 15px;
}
.hero_single .logo-img {
    max-width: 300px;
    height: auto;
    margin: 20px auto 40px;
    display: block;
}
.hero_single h1 {
    font-size: 2.5rem;
    font-weight: 700;
    line-height: 1.4;
    color: #ffffff;
    margin-bottom: 20px;
}
.hero_single p {
    font-size: 1.2rem;
    color: #f0f0f0;
    margin-bottom: 40px;
}
.hero_single .custom-search-input-2 {
    max-width: 600px;
    margin: 0 auto;
}
.hero_single .form-control {
    border-radius: 50px;
    padding: 15px 20px;
    font-size: 1rem;
    background-color: #ffffff;
    box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.15);
}
.hero_single .icon_search {
    color: #333;
}
.hero_single .btn-primary {
    border-radius: 50px;
    font-size: 1rem;
    padding: 10px 20px;
    background: linear-gradient(to right, #ff7e5f, #feb47b);
    border: none;
    transition: all 0.3s ease-in-out;
}
.hero_single .btn-primary:hover {
    background: linear-gradient(to right, #feb47b, #ff7e5f);
}
.hero_single .btn-outline-light {
    border-radius: 50px;
    font-size: 1rem;
    padding: 10px 20px;
    border: 2px solid #ffffff;
    color: #ffffff;
    background-color: transparent;
    transition: all 0.3s ease-in-out;
}
.hero_single .btn-outline-light:hover {
    background-color: #ffffff;
    color: #333;
}
</style>
@endpush

@section('content')
<section class="hero_single version_5 position-relative">
    <div class="overlay" style="background: url(https://i0.wp.com/www.uccnearme.com/wp-content/uploads/2024/05/chloenka_create_a_cafe_enviroment_with_a_middle_age_beautiful_3aea87e1-4f1b-4744-b34f-370573106e6b_0.png?ssl=1); position: absolute; top: 0; left: 0; right: 0; bottom: 0;"></div>
    <div class="wrapper">
        <div class="container position-relative">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10 text-center">
                    <img class="logo-img" src="{{ asset('logox.png') }}" alt="Logo" style="max-width: 500px; margin-top:25px; height: auto;">
                    <h1 class="text-white display-5 mb-3 mt-3">{{ $homepage->hero_title }}</h1>
                    <p class="lead text-light mb-5">{{ $homepage->hero_description }}</p>
                    <form id="searchForm" method="POST" action="{{ route('search.vendors') }}">
                        @csrf
                        <div class="custom-search-input-2">
                            <div class="form-group position-relative">
                                <input id="search" class="form-control form-control-md" type="text" placeholder="{{ $homepage->search_placeholder }}" aria-label="Search service area" onfocus="initializeAutocomplete()" name="search_location">
                                <i class="icon_search position-absolute" style="top: 50%; right: 15px; transform: translateY(-50%);"></i>
                            </div>
                            <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}"/>
                            <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}"/>                                    
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary btn-md">{{ $homepage->button_text }}</button>
                                <a href="{{ route('register') }}" class="btn btn-outline-light btn-md mt-3">{{ $homepage->signup_text }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="call_section">
    <div class="wrapper">
        <div class="container">
            <div class="main_title_2">
                <h2>{{ $homepage->how_to_use_title }}</h2>
                <p>{{ $homepage->how_to_use_description }}</p>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="box_how">
                        <i class="pe-7s-search"></i>
                        <h3>{{ $homepage->step_one_title }}</h3>
                        <p>{{ $homepage->step_one_description }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box_how">
                        <i class="pe-7s-info"></i>
                        <h3>{{ $homepage->step_two_title }}</h3>
                        <p>{{ $homepage->step_two_description }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box_how">
                        <i class="pe-7s-like2"></i>
                        <h3>{{ $homepage->step_three_title }}</h3>
                        <p>{{ $homepage->step_three_description }}</p>
                    </div>
                </div>
                <p class="text-center">
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-md">{{ $homepage->signup_text }}</a>
                </p>					
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC44otCXkNlpDZKwN1evKAKYxuI6w0DGog&libraries=places"></script>
<script>
function initializeAutocomplete() {
    const input = document.getElementById('search');
    const autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.addListener('place_changed', function () {
        const place = autocomplete.getPlace();
        if (place.geometry) {
            document.getElementById('latitude').value = place.geometry.location.lat();
            document.getElementById('longitude').value = place.geometry.location.lng();				
        }
    });
}
</script>
@endpush
