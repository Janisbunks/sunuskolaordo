<section class="py-10 relative bg-gradient-to-br from-amber-50 to-orange-50 lg:overflow-hidden">
  <div class="absolute inset-0 opacity-50">
    <div class="absolute h-32 w-32 -left-16 -top-16 bg-amber-200 rounded-full"></div>
    <div class="absolute h-24 w-24 right-10 top-1/2 bg-orange-200 rounded-full"></div>
    <div class="absolute h-40 w-40 right-0 lg:-right-20 -bottom-20 bg-amber-200 rounded-full"></div>
  </div>
  <div class="container relative">
    <div class="grid grid-cols-12 items-center lg:justify-between lg:gap-8 bg-white/80 backdrop-blur-sm rounded-2xl lg:p-4 shadow-lg">
      <div class="col-span-12 lg:col-span-5">
        <div class="tilt-wrapper transition-transform duration-300 ease-out lg:p-10" data-tilt>
          <img src="@asset('images/agnese.jpg?as=webp')" alt="Suņu Trenere Agnese" title="Suņu Trenere Agnese" class="w-full">
        </div>
      </div>
      <div class="col-span-12 lg:col-span-6 lg:col-start-7">
        <h2 class="mb-8">Par Mani</h2>
        <p>Mans vārds ir Agnese Bunka. Esmu suņu apmācību trenere un suņu uzvedības speciāliste. Suņu
          apmācību jomā darbojos jau ceturto gadu. Kinoloģijas nozarē sāku izglītoties 2013. gadā, kad iestājos un
          pabeidzu Latvijas Kinoloģiskās federācijas piedāvātos kursus “Kinoloģijas pamati”. Pabeidzu kursus un
          tad nāca ģimenes veidošanas laiks. 2017. gadā pavisam nejauši internetā ieraudzīju reklāmu suņu treneru
          apmācību kursam Igaunijā, kuras organizēja Norvēģijas suņu skola Nordic Dog Trainer School. Tajā laikā
          man nebija suņa, bet ļoti to vēlējos. Man sķita, kas es par suņu treneri, ja pašai suņa nav? Tā manā dzīvē
          ienāca Ordo. Burvīgs vācu aitu suns, kurš arī mani pabīdīja savas suņu skolas virzienā. 2020. gadā sāku
          praktizēt kā suņu apmācību trenere PetCity suņu skolā, kurā arī ieguvu praktiskās zināšanas. 2023. gads
          nāca ar ļoti lielu prieku, jo beidzot durvis vēra manis pašas suņu skola ORDO.
        </p>
        <x-button href="{{get_permalink(65)}}" variant="transparent-black" class="mt-8" size="small" title="Uzzināt Vairāk Par Mani." aria-label="Uzzināt Vairāk Par Mani.">Lasīt Vairāk</x-button>
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
    
    // Changed from 20 to 40 to make the movement more subtle
    const rotateX = (y - centerY) / 100;
    const rotateY = -(x - centerX) / 100;
    
    tiltElement.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
  });
  
  tiltElement.addEventListener('mouseleave', () => {
    tiltElement.style.transform = 'perspective(1000px) rotateX(0) rotateY(0)';
  });
});
</script>