<?php

  return $app_config = array(
    'name' => language::translate('title_geo_zones', 'Geo Zones'),
    'default' => 'geo_zones',
    'theme' => array(
      'color' => '#4398e7',
      'icon' => 'fa-globe',
    ),
    'menu' => array(),
    'docs' => array(
      'geo_zones' => 'geo_zones.inc.php',
      'edit_geo_zone' => 'edit_geo_zone.inc.php',
    ),
  );
