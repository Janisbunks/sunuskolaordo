<footer class="py-8 bg-black">
    <div class="{{ $container }}">
      <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
        <div class="md:col-span-4">
          <x-logo type="primary" class="[&_img]:max-h-[150px]"/>
          <div class="flex gap-4 items-center mt-4">
            <x-social-media />
          </div>
        </div>
        <div class="md:col-span-4">
          @include('partials.footer-menu')
        </div>
        <div class="md:col-span-4">
          <p class="text-white font-semibold mb-4">Kontakti</p>
          <a class="text-white hover:text-cyan-400 group flex items-center gap-2" href="tel:{{str_replace(' ', '', trim(get_field('contact_information', 'option')['phone_number']))}}" title="Zvaniet Man!" aria-label="Zvaniet Man!">
            <x-icon-phone class="[&_path]:group-hover:fill-cyan-400" />{{ get_field('contact_information', 'option')['phone_number']; }}
          </a>
          <a class="text-white mb-0 group flex items-center gap-2 hover:text-cyan-400" href="mailto:sunuskolaordo@inbox.lv" title="Sūtiet mums ziņu!" aria-label="Sūtiet mums ziņu!"><x-icon-mail class="[&_rect]:group-hover:stroke-cyan-400 [&_polyline]:group-hover:stroke-cyan-400" />sunuskolaordo@inbox.lv</a>
        </div>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-12 items-center gap-5 text-white mt-8">
          <div class="md:col-span-10 flex align-middle justify-start">
              <p class="mb-0">© {{ date('Y') }} {!! $siteName !!} | <a href="@permalink(52)" class="hover:text-cyan-400">Kontakti</a> | <a href="#" class="hover:text-cyan-400">Privātuma politika</a></p>
          </div>
      </div>
    </div>
</footer>
