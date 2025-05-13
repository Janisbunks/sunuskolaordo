<section class="py-8">
  <div class="{{$container}}">
    <div class="grid grid-cols-1 md:grid-cols-2 max-md:items-center gap-4">
      <div class="p-4 bg-white shadow-lg rounded-xl">
        <h2 class="text-3xl font-bold text-center text-black mb-5">Uzraksti man ziņu!</h2>
        @if(is_single(59))
        {!! do_shortcode('[contact-form-7 id="6235fcd" title="Pieteikumu Forma Pamatpaklausibas nodarbibam"]') !!}
        @else
        {!! do_shortcode('[contact-form-7 id="1c40f1b" title="Pieteikumu Forma"]') !!}
        @endif
      </div>
      <div class="p-4 lg:p-10 bg-white shadow-lg rounded-xl">
        <img class="m-auto" src="@asset('images/agnese-2.jpg?as=webp')" alt="Agnese Bunka" title="Agnese Bunka">
      </div>
    </div>
  </div>
</section>