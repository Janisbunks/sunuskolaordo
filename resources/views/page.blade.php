@extends('layouts.app')

@section('before-content')
  @include('sections.hero')
@endsection

@section('content')
  @while(have_posts()) @php(the_post())
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <div>
      @thumbnail('full')
    </div>
    <div>
      @includeFirst(['partials.content-page', 'partials.content'])
    </div>
  </div>
  @endwhile
  @if(is_page(65))
    @hasoptions('sertifikati')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-5">
      @options('sertifikati')
        @options('sertifikats')
        <div class="certificate-item">
          @hassub('file', 'type')
          @issub('file', 'type', 'application')
  {{-- Mobile view --}}
  <div class="lg:hidden">
    <a 
      href="@sub('file', 'url')" 
      class="inline-block px-4 py-2 bg-blue-500 text-white rounded-lg text-center w-full"
      target="_blank"
      rel="noopener noreferrer"
    >
      Skatīt PDF Dokumentu
    </a>
  </div>
  
  {{-- Desktop view --}}
  <iframe 
    src="@sub('file', 'url')"
    class="hidden lg:block w-full h-96 lg:h-96 lg:max-h-[400px]"
    type="application/pdf"
    frameborder="0"
    allowfullscreen
  ></iframe>
            @else
              <img src="@sub('file', 'url')" alt="@sub('title')" class="w-full h-auto max-h-[400px] object-contain">
            @endif
          @else
            <img src="@sub('file', 'url')" alt="@sub('title')" class="w-full h-auto max-h-[400px] object-contain">
          @endif
        </div>
        @endoptions
      @endoptions
    </div>
    @endhasoptions
  @endif
@endsection

@section('after-content')
  @include('sections.kontakt-sekcija')
@endsection