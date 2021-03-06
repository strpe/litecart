<?php
  header('X-Robots-Tag: noindex');

  if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    require_once(FS_DIR_HTTP_ROOT . WS_DIR_INCLUDES . 'app_header.inc.php');
    header('Content-type: text/html; charset='. language::$selected['charset']);
    document::$layout = 'ajax';
    document::$snippets['head_tags']['noindex'] = '<meta name="robots" content="noindex" />';
  }

  document::$snippets['title'][] = language::translate('regional_settings:head_title', 'Regional Settings');

  breadcrumbs::add(language::translate('title_regional_settings', 'Regional Settings'));

  if (isset($_POST['save'])) {

    try {
      $_POST['language_code'] = !empty($_POST['language_code']) ? $_POST['language_code'] : '';
      $_POST['currency_code'] = !empty($_POST['currency_code']) ? $_POST['currency_code'] : '';
      $_POST['country_code'] = !empty($_POST['country_code']) ? $_POST['country_code'] : '';
      $_POST['zone_code'] = !empty($_POST['zone_code']) ? $_POST['zone_code'] : '';
      $_POST['display_prices_including_tax'] = isset($_POST['display_prices_including_tax']) ? (int)$_POST['display_prices_including_tax'] : (int)settings::get('default_display_prices_including_tax');

      language::set($_POST['language_code']);

      currency::set($_POST['currency_code']);

      customer::$data['country_code'] = $_POST['country_code'];
      customer::$data['zone_code'] = $_POST['zone_code'];

      customer::$data['shipping_address']['country_code'] = $_POST['country_code'];
      customer::$data['shipping_address']['zone_code'] = $_POST['zone_code'];

      customer::$data['display_prices_including_tax'] = $_POST['display_prices_including_tax'];

      if (!empty($_COOKIE['cookies_accepted'])) {
        setcookie('country_code', $_POST['country_code'], strtotime('+3 months'), WS_DIR_HTTP_HOME);
        setcookie('zone_code', $_POST['zone_code'], strtotime('+3 months'), WS_DIR_HTTP_HOME);
        setcookie('display_prices_including_tax', $_POST['display_prices_including_tax'], strtotime('+3 months'), WS_DIR_HTTP_HOME);
      }

      if (empty($_GET['redirect_url'])) {
        $_GET['redirect_url'] = document::ilink('', array(), null, array(), $_POST['language_code']);
      }

      notices::add('success', language::translate('success_changes_saved', 'Changes saved successfully'));
      header('Location: '. $_GET['redirect_url']);
      exit;

    } catch (Exception $e) {
      notices::add('errors', $e->getMessage());
    }
  }

  $_page = new view();
  echo $_page->stitch('pages/regional_settings');
