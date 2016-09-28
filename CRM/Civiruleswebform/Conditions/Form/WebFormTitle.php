<?php

require_once 'CRM/Core/Form.php';

/**
 * Class for CiviRulesWebform Condition Web Form Title is (not) one of
 *
 * @author Erik Hommel (CiviCooP) <erik.hommel@civicoop.org>
 * @date 27 Sep 2016
 * @license AGPL-3.0
 */
class CRM_Civiruleswebform_Conditions_Form_WebFormTitle extends CRM_CivirulesConditions_Form_Form {
  /**
   * Overridden parent method to build form
   *
   * @access public
   */
  public function buildQuickForm() {
    $this->add('hidden', 'rule_condition_id');
    $webformList = CRM_Civiruleswebform_Utils::getWebforms();
    asort($webformList);
    $this->add('select', 'webform_id', ts('Webform(s)'), $webformList, true,
      array('id' => 'webform_ids', 'multiple' => 'multiple','class' => 'crm-select2'));
    $this->add('select', 'operator', ts('Operator'), array('is one of', 'is NOT one of'), true);

    $this->addButtons(array(
      array('type' => 'next', 'name' => ts('Save'), 'isDefault' => TRUE,),
      array('type' => 'cancel', 'name' => ts('Cancel'))));
  }

  /**
   * Overridden parent method to set default values
   *
   * @return array $defaultValues
   * @access public
   */
  public function setDefaultValues() {
    $defaultValues = parent::setDefaultValues();
    $data = unserialize($this->ruleCondition->condition_params);
    if (!empty($data['webform_id'])) {
      $defaultValues['webform_id'] = $data['webform_id'];
    }
    if (!empty($data['operator'])) {
      $defaultValues['operator'] = $data['operator'];
    }
    return $defaultValues;
  }

  /**
   * Overridden parent method to process form data after submission
   *
   * @throws Exception when rule condition not found
   * @access public
   */
  public function postProcess() {
    $data['webform_id'] = $this->_submitValues['webform_id'];
    $data['operator'] = $this->_submitValues['operator'];
    $this->ruleCondition->condition_params = serialize($data);
    $this->ruleCondition->save();
    parent::postProcess();
  }
}
