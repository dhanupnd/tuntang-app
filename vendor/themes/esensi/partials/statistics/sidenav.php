<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php 
  $s_links = [
    [
      'target' => 'statistikPenduduk',
      'title_key' => 'population_statistics',
      'icon' => 'fa-chart-pie',
      'submenu' => [
        [
          'slug' => 'first/statistik/13',
          'title_key' => 'age_range'
        ],
        [
          'slug' => 'first/statistik/15',
          'title_key' => 'age_category'
        ],
        [
          'slug' => 'first/statistik/0',
          'title_key' => 'education_in_family_card'
        ],
        [
          'slug' => 'first/statistik/14',
          'title_key' => 'current_education'
        ],
        [
          'slug' => 'first/statistik/1',
          'title_key' => 'occupation'
        ],
        [
          'slug' => 'first/statistik/2',
          'title_key' => 'marital_status'
        ],
        [
          'slug' => 'first/statistik/3',
          'title_key' => 'religion'
        ],
        [
          'slug' => 'first/statistik/4',
          'title_key' => 'gender'
        ],
        [
          'slug' => 'first/statistik/hubungan_kk',
          'title_key' => 'family_card_relationship'
        ],
        [
          'slug' => 'first/statistik/5',
          'title_key' => 'citizenship'
        ],
        [
          'slug' => 'first/statistik/6',
          'title_key' => 'resident_status'
        ],
        [
          'slug' => 'first/statistik/7',
          'title_key' => 'blood_type'
        ],
        [
          'slug' => 'first/statistik/9',
          'title_key' => 'disability'
        ],
        [
          'slug' => 'first/statistik/10',
          'title_key' => 'chronic_illness'
        ],
        [
          'slug' => 'first/statistik/16',
          'title_key' => 'family_planning_acceptor'
        ],
        [
          'slug' => 'first/statistik/17',
          'title_key' => 'birth_certificate'
        ],
        [
          'slug' => 'first/statistik/18',
          'title_key' => 'id_card_ownership'
        ],
        [
          'slug' => 'first/statistik/19',
          'title_key' => 'health_insurance'
        ],
        [
          'slug' => 'first/statistik/covid',
          'title_key' => 'covid_status'
        ],
        [
          'slug' => 'first/statistik/suku',
          'title_key' => 'ethnicity'
        ],
        [
          'slug' => 'first/statistik/bpjs-tenagakerja',
          'title_key' => 'employment_bpjs'
        ]
      ]
    ],
    [
      'target' => 'statistikKeluarga',
      'title_key' => 'family_statistics',
      'icon' => 'fa-chart-bar',
      'submenu' => [
        [
          'slug' => 'first/statistik/kelas_sosial',
          'title_key' => 'social_class'
        ]
      ]
    ],
    [
      'target' => 'statistikBantuan',
      'title_key' => 'aid_statistics',
      'icon' => 'fa-chart-line',
      'submenu' => [
        [
          'slug' => 'first/statistik/bantuan_penduduk',
          'title_key' => 'resident_aid_recipients'
        ],
        [
          'slug' => 'first/statistik/bantuan_keluarga',
          'title_key' => 'family_aid_recipients'
        ],
        [
          'slug' => 'first/statistik/501',
          'title' => 'BPNT'
        ],
        [
          'slug' => 'first/statistik/502',
          'title' => 'BLSM'
        ],
        [
          'slug' => 'first/statistik/503',
          'title' => 'PKH'
        ],
        [
          'slug' => 'first/statistik/504',
          'title_key' => 'house_renovation'
        ],
        [
          'slug' => 'first/statistik/505',
          'title' => 'JAMKESMAS'
        ]
      ]
    ],
    [
      'target' => 'statistikLainnya',
      'title_key' => 'other_statistics',
      'icon' => 'fa-chart-area',
      'submenu' => [
        [
          'slug' => 'first/dpt',
          'title_key' => 'prospective_voters'
        ],
        [
          'slug' => IS_PREMIUM ? 'data-wilayah' : 'first/wilayah',
          'title_key' => 'administrative_area'
        ]
      ]
    ]
  ]
?>

<div class="sticky top-5 w-full shadow">
  <div class="accordion" id="statistikNavigation">
    <?php foreach($s_links as $statistik) : ?>
      <?php $url_slug = str_replace(site_url(), '', current_url()) ?>
      <?php $is_active = array_search($url_slug, array_column($statistik['submenu'], 'slug')) !== false ? true : false ?>
      <div class="accordion-item bg-white border border-gray-200 overflow-hidden">
        <h4 class="accordion-header mb-0" id="heading-<?= $statistik['target'] ?>">
          <button
            class="accordion-button relative flex items-center w-full py-4 px-5 text-base text-left bg-white border-0 rounded-none transition focus:outline-none text-h5"
            type="button" data-bs-toggle="collapse" data-bs-target="#<?= $statistik['target']?>" aria-expanded="<?= $is_active ? 'true' : 'false' ?>"
            aria-controls="<?= $statistik['target']?>">
            <i class="fas <?= $statistik['icon'] ?> mr-2"></i> <?= bilingual_text($statistik['title_key']) ?>
          </button>
        </h4>
        <div id="<?= $statistik['target'] ?>" class="accordion-collapse collapse <?php $is_active && print('show') ?>" data-bs-parent="#statistikNavigation" aria-labelledby="heading-<?= $statistik['target']?>">
          <div class="accordion-body">
            <ul class="divide-y-2">
              <?php foreach($statistik['submenu'] as $submenu) : ?>
                <?php $stat_slug = str_replace('first/', '', $submenu['slug']) ?>
                <?php if($this->web_menu_model->menu_aktif($stat_slug)) : ?>
                  <li id="statistik_13"><a href="<?= site_url($submenu['slug']) ?>" class="px-5 py-2 block <?= site_url($submenu['slug']) === current_url() ? 'bg-primary-100 text-white' : 'hover:cursor-pointer hover:text-primary-100' ?>"><?= isset($submenu['title_key']) ? bilingual_text($submenu['title_key']) : $submenu['title'] ?></a></li>
                <?php endif ?>
              <?php endforeach ?>
            </ul>
          </div>
        </div>
      </div>
    <?php endforeach ?>
  </div>
</div>
