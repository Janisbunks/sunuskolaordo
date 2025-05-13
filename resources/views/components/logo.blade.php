@php
$types = [
    'primary' => 'logo',
    'secondary' => 'logo_secondary',
    'mobile' => 'logo_mobile',
];
$logo = get_field('branding', 'option')[$types[$attributes->get('type', 'primary')]];
$logoWebp = get_field('branding', 'option')[$types[$attributes->get('type', 'primary')] . '_webp'];
@endphp

<a href="{{ home_url('/') }}" class="logo {{ $attributes->get('class') }}" title="Visit {!! $siteName !!}">
  @php
      $logoExt = pathinfo($logo['url'], PATHINFO_EXTENSION);
  @endphp
  <picture>
      @if(isset($logoWebp) && is_array($logoWebp))
          <source srcset="{{ $logoWebp['url'] }}" type="image/webp">
      @endif
      <source srcset="{{ $logo['url'] }}" type="image/{{ $logoExt }}">
      <img src="{{ $logo['url'] }}" alt="{{$logo['alt']}}" title="{{$logo['title']}}">
  </picture>
</a>