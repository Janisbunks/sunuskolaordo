<header class="absolute top-0 left-0 right-0 z-50 w-full" x-data="{ open: false, hidden: false }">
  <div class="{{$container}}">
    <div class="grid grid-cols-12 items-center">
      <div class="col-span-2">
        <x-logo type="primary" class="[&_img]:max-h-[150px]"/>
      </div>
      <div class="col-span-10 flex items-center justify-between">
        @include('partials.navigation')
        <x-button variant="transparent-white" class="rounded-full" size="rounded-full" href="tel:{{str_replace(' ', '', trim(get_field('contact_information', 'option')['phone_number']))}}" title="Zvaniet Man!" aria-label="Zvaniet Man!">
          <x-icon-phone class="[&_path]:group-hover:fill-black" />
        </x-button>
        <x-mobile-menu-toggle />
      </div>
    </div>
  </div>
  @include('partials.mobile-menu')
</header>
