@extends ('layouts.app')

@section ('before-content')
  @include ('sections.hero')
@endsection

@section ('content')
  @while (have_posts())
    @php (the_post())
    @includeFirst (['partials.content-single-' . get_post_type(), 'partials.content-single'])
  @endwhile
  @section ('sidebar')
    @include ('partials.sidebar')
  @endsection
@endsection

@section ('after-content')
  @include ('sections.kontakt-sekcija')
@endsection
