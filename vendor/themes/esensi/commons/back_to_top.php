<div 
  class="fixed bottom-0 mb-5 right-0 mr-5"
  x-data="{backTop: false}"
  @scroll.window="backTop = window.scrollY > document.querySelector('header').getBoundingClientRect().top + 800">
  <a 
    href="#"
    class="flex items-center justify-center h-10 w-10 rounded-full btn btn-accent p-0 transition duration:300 shadow-lg"
    :class="{'opacity-100': backTop, 'opacity-0': !backTop}"
    aria-label="<?= bilingual_current_language() === 'en' ? 'back to top button' : 'tombol kembali ke atas' ?>">
      <i 
        class="fa fa-chevron-up"
        aria-label="<?= bilingual_current_language() === 'en' ? 'back to top icon' : 'ikon kembali ke atas' ?>">
      </i>
  </a>
</div>
