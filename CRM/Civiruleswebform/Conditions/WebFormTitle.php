<?php
/**
 * Class for CiviRulesWebForm Condition WebForm Title is (not) one of
 *
 * @author Erik Hommel (CiviCooP) <erik.hommel@civicoop.org>
 * @date 27 Sep 2016
 * @license AGPL-3.0
 */

class CRM_Civiruleswebform_Conditions_WebFormTitle extends CRM_Civirules_Condition {

  private $conditionParams = array();

  /**
   * Method to set the Rule Condition data
   *
   * @param array $ruleCondition
   * @access public
   */
  public function setRuleConditionData($ruleCondition) {
    parent::setRuleConditionData($ruleCondition);
    $this->conditionParams = array();
    if (!empty($this->ruleCondition['condition_params'])) {
      $this->conditionParams = unserialize($this->ruleCondition['condition_params']);
    }
  }

  /**
   * Method to determine if the condition is valid
   *
   * @param CRM_Civirules_TriggerData_TriggerData $triggerData
   * @return bool
   */

  public function isConditionValid(CRM_Civirules_TriggerData_TriggerData $triggerData) {
    $isConditionValid = FALSE;
    $webFormData = $triggerData->getEntityData('webform');
    switch ($this->conditionParams['operator']) {
      case 0:
        if (in_array($webFormData['nid'], $this->conditionParams['webform_id'])) {
          $isConditionValid = TRUE;
        }
      break;
      case 1:
        if (!in_array($webFormData['nid'], $this->conditionParams['webform_id'])) {
          $isConditionValid = TRUE;
        }
      break;
    }
    return $isConditionValid;
  }

  /**
   * Returns a redirect url to extra data input from the user after adding a condition
   *
   * Return false if you do not need extra data input
   *
   * @param int $ruleConditionId
   * @return bool|string
   * @access public
   * @abstract
   */
  public function getExtraDataInputUrl($ruleConditionId) {
    return CRM_Utils_System::url('civicrm/civiruleswebform/conditions/form/webformtitle', 'rule_condition_id='.$ruleConditionId);
  }

  /**
   * Returns a user friendly text explaining the condition params
   * e.g. 'Older than 65'
   *
   * @return string
   * @access public
   */
  public function userFriendlyConditionParams() {
    $friendlyText = "";
    if ($this->conditionParams['operator'] == 0) {
      $friendlyText = 'Is in one of these webforms: ';
    }
    if ($this->conditionParams['operator'] == 1) {
      $friendlyText = 'Is NOT in of these webforms: ';
    }
    $webformText = array();
    foreach ($this->conditionParams['webform_id'] as $webformId) {
      $webformText[] = CRM_Civiruleswebform_Utils::getWebformTitle($webformId);
    }
    if (!empty($webformText)) {
      $friendlyText .= implode(", ", $webformText);
    }
    return $friendlyText;
  }

  /**
   * Returns an array with required entity names
   *
   * @return array
   * @access public
   */
  public function requiredEntities() {
    return array('Webform');
  }
}