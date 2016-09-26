<?php

/**
 * Class with generic helper functions for extensioin
 *
 * @author Erik Hommel (CiviCooP) <erik.hommel@civicoop.org>
 * @date 26 Sep 2016
 * @license AGPL-3.0
 */
class CRM_Civiruleswebform_Utils {
  /**
   * Method to check if the civirules extension is installed and enabled
   *
   * @return bool
   * @access public
   * @static
   */
  public static function isCiviRulesEnabled() {
    try {
      $extensions = civicrm_api3('Extension', 'get', array());
      foreach ($extensions['values'] as $extensionName => $extensionStatus) {
        if ($extensionName == 'org.civicoop.civirules' && $extensionStatus = 'installed') {
          return TRUE;
        }
      }
    } catch (CiviCRM_API3_Exception $ex) {}
    return FALSE;
  }
}