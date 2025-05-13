@if($footerNav)
  <p class="text-white font-semibold mb-4">Nodarbības</p>
  <div class="space-y-1">
    @foreach ($footerNav as $item)
      <a class="font-medium text-base text-white block hover:text-cyan-400" href="{{ $item->url }}" title="Lasīt par {{ $item->label }}">
        {!! $item->label !!}
      </a>
    @endforeach
  </div>
@endif