<section class="relative min-h-[550px]">
  <picture>
    <source srcset="@asset('images/backgrounds/bg-hero.jpg?as=webp')" type="image/webp">
    <source srcset="@asset('images/backgrounds/bg-hero.jpg')" type="image/jpg">
    <img src="@asset('images/backgrounds/bg-hero.jpg')" alt="Hero Background" class="w-full h-full object-cover absolute inset-0">
  </picture>
  <div class="container text-center z-20 min-h-[550px] flex flex-col items-end relative">
    <div class="flex-1 flex items-end justify-center">
      @hasfield('h1')
        <h1 class="text-white text-4xl font-bold mb-20">@field('h1')</h1>
      @elseif(is_home())
        <h1 class="text-white text-4xl font-bold mb-20">Raksti</h1>
      @else
        <h1 class="text-white text-4xl font-bold mb-20">@title</h1>
      @endif
    </div>
    @if(!is_front_page())
      <div class="mb-4 self-start">
        <x-breadcrumb />
      </div>
    @endif
  </div>
  <div class="absolute inset-0 bg-black/50 w-full h-full"></div>
</section>