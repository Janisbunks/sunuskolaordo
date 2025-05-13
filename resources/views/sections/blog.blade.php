@query('posts', 'post', 'post_type=post')
<section class="py-8 relative">
  <div class="{{$container}}">
    <h2 class="text-3xl font-bold text-center text-black mb-12">Raksti</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
      @hasposts
        @posts
        <a class="relative group p-4 rounded-xl border-grey/50 border shadow-lg" href="@permalink" title="@title" aria-label="@title">
          <span class="absolute opacity-0 group-hover:opacity-100 rounded-xl transition-opacity z-[-1] duration-300 inset-0 w-full h-full bg-indigo-50"></span>
          @thumbnail('full z-10 max-h-[300px] object-cover w-full h-full')
          <h3 class="text-2xl font-bold z-10 mt-4 mb-6 capitalize group-hover:text-blue-400">@title</h3>
          <p class="text-base group-hover:-translate-y-2 group-hover:text-blue-400">Lasīt vairāk</p>
        </a>
        @endposts
      @endhasposts
    </div>
  </div>
</section>
