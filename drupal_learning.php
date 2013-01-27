<?php
function check_plain($text) {
  static $php525;

  if (!isset($php525)) {
    $php525 = version_compare(PHP_VERSION, '5.2.5', '>=');
  }
  // We duplicate the preg_match() to validate strings as UTF-8 from
  // drupal_validate_utf8() here. This avoids the overhead of an additional
  // function call, since check_plain() may be called hundreds of times during
  // a request. For PHP 5.2.5+, this check for valid UTF-8 should be handled
  // internally by PHP in htmlspecialchars().
  // @see http://www.php.net/releases/5_2_5.php
  // @todo remove this when support for either IE6 or PHP < 5.2.5 is dropped.

  if ($php525) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
  }
  return (preg_match('/^./us', $text) == 1) ? htmlspecialchars($text, ENT_QUOTES, 'UTF-8') : '';
}


function t($string, $args = array(), $langcode = NULL) {
  global $language;
  static $custom_strings;

  $langcode = isset($langcode) ? $langcode : $language->language;

  // First, check for an array of customized strings. If present, use the array
  // *instead of* database lookups. This is a high performance way to provide a
  // handful of string replacements. See settings.php for examples.
  // Cache the $custom_strings variable to improve performance.
  if (!isset($custom_strings[$langcode])) {
    $custom_strings[$langcode] = variable_get('locale_custom_strings_'. $langcode, array());
  }
  // Custom strings work for English too, even if locale module is disabled.
  if (isset($custom_strings[$langcode][$string])) {
    $string = $custom_strings[$langcode][$string];
  }
  // Translate with locale module if enabled.
  elseif (function_exists('locale') && $langcode != 'en') {
    $string = locale($string, $langcode);
  }
  if (empty($args)) {
    return $string;
  }
  else {
    // Transform arguments before inserting them.
    foreach ($args as $key => $value) {
      switch ($key[0]) {
        case '@':
          // Escaped only.
          $args[$key] = check_plain($value);
          break;

        case '%':
        default:
          // Escaped and placeholder.
          $args[$key] = theme('placeholder', $value);
          break;

        case '!':
          // Pass-through.
      }
    }
    return strtr($string, $args);
  }
}

function format_plural($count, $singular, $plural, $args = array(), $langcode = NULL) {
  $args['@count'] = $count;
  if ($count == 1) {
    return t($singular, $args, $langcode);
  }

  // Get the plural index through the gettext formula.
  $index = (function_exists('locale_get_plural')) ? locale_get_plural($count, $langcode) : -1;
  // Backwards compatibility.
  if ($index < 0) {
    return t($plural, $args, $langcode);
  }
  else {
    switch ($index) {
      case "0":
        return t($singular, $args, $langcode);
      case "1":
        return t($plural, $args, $langcode);
      default:
        unset($args['@count']);
        $args['@count['. $index .']'] = $count;
        return t(strtr($plural, array('@count' => '@count['. $index .']')), $args, $langcode);
    }
  }
}

function drupal_add_css($path = NULL, $type = 'module', $media = 'all', $preprocess = TRUE) {
  static $css = array();
  global $language;

  // Create an array of CSS files for each media type first, since each type needs to be served
  // to the browser differently.
  if (isset($path)) {
    // This check is necessary to ensure proper cascading of styles and is faster than an asort().
    if (!isset($css[$media])) {
      $css[$media] = array('module' => array(), 'theme' => array());
    }
    $css[$media][$type][$path] = $preprocess;

    // If the current language is RTL, add the CSS file with RTL overrides.
    if ($language->direction == LANGUAGE_RTL) {
      $rtl_path = str_replace('.css', '-rtl.css', $path);
      if (file_exists($rtl_path)) {
        $css[$media][$type][$rtl_path] = $preprocess;
      }
    }
  }

  return $css;
}
