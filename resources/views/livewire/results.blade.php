@extends('layouts.app')
@push('head')
<style>
    .listing-card {
        border: 2px solid #007bff;
        border-radius: 8px;
        padding: 20px;
        margin: 20px 0;
        text-align: center;
    }
    .listing-card img {
        width: 100px;
        margin-bottom: 10px;
    }
    .divider {
        border-top: 2px solid #007bff;
        margin: 20px 0;
    }
    .listing-card h5 {
        font-size: 1.5rem;
        font-weight: bold;
    }
    .review-stars {
        color: gold;
        font-size: 1.2rem;
    }
    .review-count {
        font-size: 0.9rem;
        color: gray;
    }
    .btn-group {
        display: flex;
        justify-content: center;
        gap: 10px;
    }
    .btn-custom {
        background-color: #007bff;
        color: #fff;
        border-radius: 20px;
        padding: 10px 20px;
        border: none;
    }
</style>
@endpush
@section('content')
<br><br><br>
<div class="container">
    @if($vendors->isEmpty())
        <div class="alert alert-warning" role="alert">
            No transport providers found in your area.
        </div>
    @else
        @foreach($vendors as $vendor)
            <div class="listing-card">
                <img src="{{ $vendor->logo_url ?? 'https://via.placeholder.com/100' }}" alt="{{ $vendor->name }}">
                <h5>{{ $vendor->name }}</h5>
                <p><strong>Location:</strong> {{ $vendor->address }}</p>
                <p>{{ $vendor->description }}</p>
                <p class="review-stars">
                    @for($i = 0; $i < 5; $i++)
                        <span>★</span>
                    @endfor
                    <span class="review-count">(Reviews {{ $vendor->review_count ?? 0 }})</span>
                </p>
                <div class="btn-group">
                    <button class="btn btn-custom">Email</button>
                    <button class="btn btn-custom">SMS Text</button>
                    <button class="btn btn-custom">Call</button>
                </div>
            </div>
            <div class="divider" style="15px solid #007bff;"></div>
        @endforeach
    @endif
</div>
@endsection
