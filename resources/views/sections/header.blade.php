<header class="w-full py-5" x-data="{ open: false, hidden: false }">
  <div class="{{$container}}">
    <div class="grid grid-cols-12 items-center">
      <div class="col-span-1">
        <x-logo type="secondary" class="[&_img]:max-h-[60px]" />
      </div>
      <div class="col-span-11 flex items-center gap-2 justify-between">
        @include ('partials.navigation')
        <div>
          <a
            class="text-black group hover:font-bold flex items-center gap-2"
            href="tel:{{str_replace(' ', '', trim(get_field('contact_information', 'option')['phone_number']))}}"
            title="Zvaniet Man!"
            aria-label="Zvaniet Man!"
          >
            <x-icon-phone class="group-hover:scale-110 transition-transform duration-300" />
            <span>{{get_field('contact_information', 'option')['phone_number']}}</span>
          </a>
          <a
            class="text-black group hover:font-bold flex items-center gap-2"
            href="mailto:{{get_field('contact_information', 'option')['email_address']}}"
            title="Uzraksti Man!"
            aria-label="Uzraksti Man!"
          >
            <x-icon-mail class="group-hover:scale-110 transition-transform duration-300" />
            <span>{{get_field('contact_information', 'option')['email_address']}}</span>
          </a>
        </div>
        <x-mobile-menu-toggle />
      </div>
    </div>
  </div>
  @include ('partials.mobile-menu')
</header>
