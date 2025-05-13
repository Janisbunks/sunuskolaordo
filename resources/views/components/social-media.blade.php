@hasoptions('social_profiles')
  @options('social_profiles')
    @options('social_profile')
      <a class="w-8 h-8 flex items-center justify-center rounded-full border border-white group hover:bg-white [&_svg_path]:hover:fill-black" href="@sub('social_profile_url')" target="_blank" rel="nofollow noreferrer noopener" title="Apskati Mūs @sub('social_profile_name')">
        @sub('svg_code')
      </a>
    @endoptions
  @endoptions
@endhasoptions