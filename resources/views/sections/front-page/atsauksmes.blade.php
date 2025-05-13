<section class="bg-black py-8">
  <div class="{{$container}}">
    <h2 class="text-3xl font-bold text-center text-white mb-5">Atsauksmes</h2>
    @hasoption('atsauksmes')
      @options('atsauksmes')
      <div class="splide splide-atsauksmes">
        <div class="splide__track max-w-[280px] md:max-w-[550px] mx-auto">
          <div class="splide__list justify-between">
            @options('atsauksme_single')
              <div class="splide__slide text-center">
                <div class="testimonial text-white [&_p]:text-sm md:[&_p]:text-base">@sub('description')</div>
              </div>
            @endoptions
          </div>
        </div>
      </div>
      @endoptions
    @endhasoptions
  </div>
</section>

@push('after-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const splide = new Splide('.splide-atsauksmes', {
                type: 'fade',
                rewind: true,
                pagination: false,
                autoplay: true,
                interval: 3000,
                speed: 1000,
            });

            // Initialize height map
            var heightMap = {};
            
            // Initially set all slides to max-height 0
            document.querySelectorAll(".splide-atsauksmes .splide__slide").forEach(function(e) {
                e.style.maxHeight = 0;
            });

            // Store heights of all slides
            splide.on("mounted", function() {
                var i = 0;
                document.querySelectorAll(".splide-atsauksmes .splide__slide").forEach(function(e) {
                    if (!e.classList.contains('splide__slide--clone')) {
                        heightMap[i] = e.scrollHeight;
                        i++;
                    }
                });
            });

            // Update height when slide becomes active
            splide.on("active", function(e) {
                var maxHeight = heightMap[e.index] + "px";
                e.slide.style.maxHeight = maxHeight;
                e.slide.parentElement.style.maxHeight = maxHeight;
            });

            splide.mount();
        });
    </script>
@endpush