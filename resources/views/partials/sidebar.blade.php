@php
    $siblings = get_posts([
        'post_type' => get_post_type(),
        'post__not_in' => [get_the_ID()],
        'posts_per_page' => 5,
        'orderby' => 'date',
        'order' => 'DESC'
    ]);
@endphp

<div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
    <h3 class="text-2xl font-bold mb-4">
      @if (get_post_type() === 'post')
        Citi Raksti
      @else
        Citas {{ ucfirst(get_post_type()) }}
      @endif
    </h3>
    <ul class="siblings-list">
        @foreach ($siblings as $sibling)
            <li class="space-y-4 list-none">
                <a title="Lasīt vairāk @title" aria-label="Lasīt vairāk @title" href="{{ get_permalink($sibling->ID) }}" 
                  class="group sibling-link flex items-center gap-4 justify-between hover:text-cyan-500">
                    {{ $sibling->post_title }}<x-icon-arrow-right class="relative group-hover:-translate-x-2 flex-shrink-0 group-hover:scale-[2.0]" />
                </a>
            </li>
        @endforeach
    </ul>
</div>