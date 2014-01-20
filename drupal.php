<?php

/**
 * @file
 * The PHP page that serves all page requests on a Drupal installation.
 *
 * The routines here dispatch control to the appropriate handler, which then
 * prints the appropriate page.
 *
 * All Drupal code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt.
 */

/**
 * Root directory of Drupal installation.
 */
define('DRUPAL_ROOT', getcwd());
function pr($var) {
  echo '<pre>' .print_r($var, true) .'</pre>';
}

      
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';

      
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
//@include_once DRUPAL_ROOT . '/includes/database/log.inc';
//Database::startLog('devel');
menu_execute_active_handler();
//variable_set('error_level', ERROR_REPORTING_DISPLAY_ALL);
//pr(Database::getLog('devel', 'default'));

//$cache = cache_get('node_types:en');
//
// pr($cache);
// 

//pr(drupal_get_messages());
//pr(get_included_files());

