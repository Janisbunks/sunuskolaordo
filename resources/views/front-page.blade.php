@extends ('layouts.app')

@section ('before-content')
  @include ('sections..hero')
  @include ('sections.front-page.main-content')
  @include ('sections.front-page.nodarbibas')
  @include ('sections.blog')
  @include ('sections.front-page.atsauksmes')
  @include ('sections.kontakt-sekcija')
@endsection

@section ('content')
  @while (have_posts())
    @php (the_post())
    @includeFirst (['partials.content-page', 'partials.content'])
  @endwhile
@endsection

@section ('after-content')
@endsection
