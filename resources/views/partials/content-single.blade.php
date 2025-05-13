<article @php(post_class('h-entry'))>

    <div class="e-content mb-8 lg:max-w-[900px] lg:mx-auto">
      <h2 class="mb-5">@title</h2>
      @thumbnail('full mb-8 w-full lg:max-h-[500px] lg:object-cover')
      @php(the_content())
    </div>

</article>
