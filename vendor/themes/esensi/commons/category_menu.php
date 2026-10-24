<?php  defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $alt_slug = IS_PREMIUM ? 'artikel' : 'first'; ?>

<section x-data="{catMenu: false}" class="public-top-navigation">
  <button 
    type="button"
    class="lg:hidden inline-block py-4 px-6 z-10 relative"
    @click="catMenu = !catMenu">
    <i class="fa fa-list fa-lg"></i>
  </button>

  <div 
    x-show="catMenu"
    x-on:click="catMenu = false"
    x-transition.opacity
    class="fixed inset-0 z-30 backdrop-blur-sm"
  ></div>

  <div
    class="lg:py-3 px-3 lg:block transform transition-transform duration-300 lg:visible z-40"
    :class="{'bg-white text-gray-700 w-3/4 shadow fixed top-0 left-0 h-screen block inset-0 overflow-y-auto opacity-100 visible': catMenu, 'bg-white lg:bg-transparent fixed lg:relative -translate-x-full h-screen lg:h-auto lg:translate-x-0 opacity-0 lg:opacity-100':!catMenu}"
    x-transitionx-on:click.stop
    x-trap.noscroll.inert="catMenu">

    <h5 class="text-h5 pt-5 pb-3 px-3 lg:hidden"><?= bilingual_text('category_menu') ?></h5>
    <div class="flex lg:flex-row flex-col justify-between items-center relative z-10">
      <ul class="w-full text-sm">
        <?php foreach($menu_kiri as $menu) : ?>
          <li class="lg:inline-block">
            <a href="<?= site_url("{$alt_slug}/kategori/{$menu['slug']}") ?>" class="block lg:inline-block py-2 px-3 hover:text-link">
              <?= bilingual_field($menu, 'kategori') ?>
            </a>
          </li>
          <?php if(count($menu['submenu']) > 0) : ?>
            <?php foreach($menu['submenu'] as $submenu) : ?>
              <li class="lg:inline-block">
                <a href="<?= site_url("{$alt_slug}/kategori/{$submenu['slug']}") ?>" class="block lg:inline-block py-2 px-3 hover:text-link">
                  <?= bilingual_field($submenu, 'kategori') ?>
                </a>
              </li>
            <?php endforeach ?>
          <?php endif ?>
        <?php endforeach; ?>
      </ul>

      <div class="flex flex-col lg:flex-row gap-3 mt-5 lg:mt-0 flex-wrap lg:justify-end w-full px-3">
        <?php $this->load->view('global/language_toggle') ?>
        <?php if($this->setting->layanan_mandiri == 1) : ?>
          <a href="<?= site_url('layanan-mandiri/masuk') ?>" class="btn btn-primary text-sm w-full lg:w-auto text-center"><?= bilingual_text('self_service') ?> <i class="fas fa-external-link-alt ml-1"></i></a>
        <?php endif ?>
        <a href="<?= site_url('siteman') ?>" class="btn btn-accent text-sm w-full lg:w-auto text-center"><?= bilingual_text('admin_login') ?> <i class="fas fa-external-link-alt ml-1"></i></a>
      </div>
    </div>
  </div>

</section>

<script>
  (() => {
    const navigation = document.querySelector('.public-top-navigation');
    const hero = navigation?.closest('header');
    const desktop = window.matchMedia('(min-width: 1024px)');

    if (!navigation || navigation.dataset.autoHideReady) {
      return;
    }

    navigation.dataset.autoHideReady = 'true';
    let previousScrollY = window.scrollY;
    let ticking = false;

    const updateNavigationSurface = () => {
      if (!desktop.matches || !hero) {
        navigation.classList.remove('is-on-light-content');
        return;
      }

      const heroBottom = hero.getBoundingClientRect().bottom;
      navigation.classList.toggle('is-on-light-content', heroBottom <= navigation.offsetHeight + 8);
    };

    const updateNavigation = () => {
      const currentScrollY = window.scrollY;

      if (!desktop.matches || currentScrollY <= 12 || currentScrollY < previousScrollY) {
        navigation.classList.remove('is-hidden');
      } else if (currentScrollY > previousScrollY + 4) {
        navigation.classList.add('is-hidden');
      }

      updateNavigationSurface();
      previousScrollY = currentScrollY;
      ticking = false;
    };

    window.addEventListener('scroll', () => {
      if (!ticking) {
        window.requestAnimationFrame(updateNavigation);
        ticking = true;
      }
    }, { passive: true });

    desktop.addEventListener('change', () => {
      previousScrollY = window.scrollY;
      navigation.classList.remove('is-hidden');
      updateNavigationSurface();
    });

    updateNavigationSurface();
  })();
</script>
