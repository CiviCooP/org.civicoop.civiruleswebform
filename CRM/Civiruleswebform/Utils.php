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

  /**
   * Method to add the trigger for webform submission if it does not exist yet
   *
   * @access public
   * @static
   */
  public static function addTriggersWebformSubmit() {
    $triggerName = 'webform_submission';
    try {
      $exists = civicrm_api3('CiviRuleTrigger', 'getcount', array('name' => $triggerName));
    } catch (CiviCRM_API3_Exception $ex) {
      $exists = 0;
    }
    if ($exists == 0) {
      $nowDate = new DateTime();
      try {
        civicrm_api3('CiviRuleTrigger', 'create', array(
          'name' => $triggerName,
          'label' => 'Drupal Webform is submitted (insert)',
          'class_name' => 'CRM_Civiruleswebform_Trigger',
          'is_active' => 1,
          'created_date' => $nowDate->format('Y-m-d')
        ));
      } catch (CiviCRM_API3_Exception $ex) {
        throw new Exception('Could not create required trigger for webform submission in '.__METHOD__
          .', contact your system administrator. Error from API CiviRulesTrigger create: '.$ex->getMessage());
      }
    }
  }

  /**
   * Method to delete trigger for webform submission if it exists
   *
   * @access public
   * @static
   */
  public static function deleteTriggerWebformSubmit() {
    $triggerName = 'webform_submission';
    try {
      $triggerId = civicrm_api3('CiviRuleTrigger', 'getvalue', array('name' => $triggerName, 'return' => 'id'));
      civicrm_api3('CiviRuleTrigger', 'delete', array('id' => $triggerId));
    } catch (CiviCRM_API3_Exception $ex) {}
  }

  /**
   * Method to determine if installation is PUM
   *
   * @return bool
   */
  public static function installIsPUM() {
    try {
      $contactName = civicrm_api3('Contact', 'getvalue', array(
        'id' => 1,
        'return' => 'sort_name'));
      if ($contactName == "PUM Netherlands senior experts") {
        return TRUE;
      }
    } catch (CiviCRM_API3_Exception $ex) {}
    return FALSE;
  }

  /**
   * Method to get all webforms from drupal node table
   */
  public static function getWebforms() {
    $result = array();
    $query = db_select('node', 'n')
      ->fields('n', array('nid', 'title'))
      ->condition('n.type', 'webform');
    $webForms = $query->execute();
    if ($webForms->rowCount()) {
      foreach ($webForms as $webForm) {
        $result[$webForm->nid] = $webForm->title;
      }
    }
    return $result;
  }

  /**
   * Method to get webform title with webform id
   *
   * @param $webformId
   * @return mixed
   */
  public static function getWebformTitle($webformId) {
    return db_query('SELECT title FROM {node} where nid = :webformId', array('webformId' => $webformId))
      ->fetchField();
  }
}