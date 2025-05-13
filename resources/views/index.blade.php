@extends('layouts.app')

@section('before-content')
  @include('sections.hero')
@endsection

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
      @while(have_posts()) @php(the_post())
        @includeFirst(['partials.content-' . get_post_type(), 'partials.content'])
      @endwhile
    </div>
@endsection

@section('after-content')
  @include('sections.kontakt-sekcija')
@endsection
