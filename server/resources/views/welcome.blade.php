@extends('layouts.app')

@section('content')
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth 
                        {{ Auth::user()->nickname }}
                        <a href="{{ url('/home') }}">Home</a>
                        <a href="/users/{{ Auth::user()->nickname }}">マイページ</a>
                    @else
                        <a href="{{ route('login') }}">Login</>
                    @endauth
                </div>
            @endif
        </div>
@endsection
