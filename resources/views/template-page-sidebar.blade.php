{{--
    Template Name: Page With Sidebar
--}}

@extends('layouts.app')

@section('before-content')
@endsection

@section('content')
    @while(have_posts()) @php(the_post())
        @include('partials.page-header')
        @includeFirst(['partials.content-page', 'partials.content'])
    @endwhile
    @section('sidebar')
        @include('partials.sidebar')
    @endsection
@endsection

@section('after-content')
@endsection