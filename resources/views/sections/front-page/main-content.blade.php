<section class="py-16 relative bg-gradient-to-br from-orange-50 via-red-50 to-amber-50 overflow-hidden">
  <div class="container relative mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
      <div class="relative overflow-hidden rounded-2xl shadow-2xl group">
        <img
          src="@asset('images/agnese.jpg?as=webp')"
          alt="Suņu Trenere Agnese"
          title="Suņu Trenere Agnese"
          class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 max-h-[650px]"
          loading="lazy"
        />
      </div>

      <div class="space-y-8">
        <div class="space-y-4">
          <div class="inline-flex items-center space-x-2 text-orange-600 font-medium text-sm uppercase tracking-wider">
            <span class="w-8 h-px bg-orange-400"></span>
            <span>Par Mani</span>
            <span class="w-8 h-px bg-orange-400"></span>
          </div>
          <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 leading-tight">
            Agnese Bunka
            <span class="block text-2xl lg:text-3xl font-normal text-orange-600 mt-2"
              >Suņu Trenere & Uzvedības Speciāliste</span
            >
          </h2>
        </div>

        <div class="prose prose-lg max-w-none">
          <p class="text-gray-700 leading-relaxed text-lg">Mans vārds ir <strong class="text-gray-900">Agnese Bunka</strong>. Esmu suņu apmācību trenere un suņu uzvedības speciāliste. Suņu apmācību jomā darbojos jau ceturto gadu.</p>

          <div class="mt-6 space-y-4">
            <div class="flex items-center space-x-3">
              <div class="w-3 h-3 bg-orange-400 rounded-full flex-shrink-0 animate-pulse"></div>
              <p class="text-gray-700 leading-relaxed mb-0">Kinoloģijas nozarē sāku izglītoties 2013. gadā, kad iestājos un pabeidzu Latvijas Kinoloģiskās federācijas piedāvātos kursus "Kinoloģijas pamati".</p>
            </div>

            <div class="flex items-center space-x-3">
              <div class="w-3 h-3 bg-orange-400 rounded-full flex-shrink-0 animate-pulse"></div>
              <p class="text-gray-700 leading-relaxed mb-0">2017. gadā ieraudzīju reklāmu suņu treneru apmācību kursam Igaunijā, kuras organizēja Norvēģijas suņu skola Nordic Dog Trainer School.</p>
            </div>

            <div class="flex items-center space-x-3">
              <div class="w-3 h-3 bg-orange-400 rounded-full flex-shrink-0 animate-pulse"></div>
              <p class="text-gray-700 leading-relaxed mb-0">2020. gadā sāku praktizēt kā suņu apmācību trenere PetCity suņu skolā, kurā arī ieguvu praktiskās zināšanas.</p>
            </div>

            <div class="flex items-center space-x-3">
              <div class="w-3 h-3 bg-orange-400 rounded-full flex-shrink-0 animate-pulse"></div>
              <p class="text-gray-700 leading-relaxed mb-0">2023. gads nāca ar ļoti lielu prieku, jo beidzot durvis vēra manis pašas suņu skola <strong class="text-orange-600">ORDO</strong>.</p>
            </div>
          </div>
        </div>

        <div class="pt-4">
          <a
            href="{{get_permalink(65)}}"
            class="relative inline-flex items-center justify-center px-8 py-2.5 overflow-hidden tracking-tighter text-white bg-gray-800 rounded-md group"
          >
            <span
              class="absolute w-0 h-0 transition-all duration-500 ease-out bg-orange-600 rounded-full group-hover:w-56 group-hover:h-56"
            ></span>
            <span class="absolute bottom-0 left-0 h-full -ml-2">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-auto h-full opacity-100 object-stretch"
                viewBox="0 0 487 487"
              >
                <path
                  fill-opacity=".1"
                  fill-rule="nonzero"
                  fill="#FFF"
                  d="M0 .3c67 2.1 134.1 4.3 186.3 37 52.2 32.7 89.6 95.8 112.8 150.6 23.2 54.8 32.3 101.4 61.2 149.9 28.9 48.4 77.7 98.8 126.4 149.2H0V.3z"
                ></path>
              </svg>
            </span>
            <span class="absolute top-0 right-0 w-12 h-full -mr-3">
              <svg xmlns="http://www.w3.org/2000/svg" class="object-cover w-full h-full" viewBox="0 0 487 487">
                <path
                  fill-opacity=".1"
                  fill-rule="nonzero"
                  fill="#FFF"
                  d="M487 486.7c-66.1-3.6-132.3-7.3-186.3-37s-95.9-85.3-126.2-137.2c-30.4-51.8-49.3-99.9-76.5-151.4C70.9 109.6 35.6 54.8.3 0H487v486.7z"
                ></path>
              </svg>
            </span>
            <span
              class="absolute inset-0 w-full h-full -mt-1 rounded-lg opacity-30 bg-gradient-to-b from-transparent via-transparent to-gray-200"
            ></span>
            <span class="relative text-base font-semibold">Lasīt Vairāk Par Mani!</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const tiltElement = document.querySelector('[data-tilt]');

    if (!tiltElement) return;

    tiltElement.addEventListener('mousemove', (e) => {
      const rect = tiltElement.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;

      const centerX = rect.width / 2;
      const centerY = rect.height / 2;

      const rotateX = (y - centerY) / 100;
      const rotateY = -(x - centerX) / 100;

      tiltElement.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
    });

    tiltElement.addEventListener('mouseleave', () => {
      tiltElement.style.transform = 'perspective(1000px) rotateX(0) rotateY(0)';
    });
  });
</script>
