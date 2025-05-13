<div class="flex items-center lg:hidden bg-white rounded-full p-2.5 w-[43px] h-[43px]">
  <button title="Open Navigation" @click="open = !open" class="relative z-20 h-full w-full inline-flex items-center justify-center p-0 rounded-md focus:outline-none transition duration-150 ease-in-out" id="menuToggle">
      <span x-bind:class="open ? 'translate-y-0 rotate-45' : '-translate-y-1.5'"
          class="transform transition duration-300 w-full h-0.5 bg-black absolute"></span>
      <span x-bind:class="open ? 'opacity-0 translate-x-3' : 'opacity-100'"
          class="transform transition duration-500 w-full h-0.5 bg-black absolute"></span>
      <span x-bind:class="open ? 'translate-y-0 -rotate-45' : 'translate-y-1.5'"
          class="transform transition duration-300 w-full h-0.5 bg-black absolute"></span>
  </button>
</div>