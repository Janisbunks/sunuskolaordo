@query([
  'post_type' => 'nodarbibas',
  'posts_per_page' => -1,
  'orderby' => 'date',
  'order'   => 'ASC',
])
<section class="bg-black py-8">
  <div class="{{$container}}">
    <h2 class="text-3xl font-bold text-center text-white mb-12">Socializācijas Nodarbības</h2>
    @hasposts
    <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
      @posts
      @php
        global $post;
        $permalink = get_permalink($post->ID);
      @endphp
      <a class="bg-white/10 backdrop-blur-sm rounded-xl p-8 text-center group hover:bg-white/20 cursor-pointer transition-all group" title="@title" aria-label="@title" href="@permalink">
        <div class="text-white mb-4 h-12 w-12 flex justify-center w-full">
          @field('svg')
        </div>
        <h3 class="text-xl font-bold text-white mb-2">@title</h3>
        <p class="text-gray-300 text-sm mb-4">@field('description')</p>
        <div class="text-white font-semibold mb-2">@field('pricing')</div>
        <p class="text-sm text-gray-400">@field('subtitle')</p>
      </a>
      @endposts
    </div>
    @endhasposts
  </div>
</section>