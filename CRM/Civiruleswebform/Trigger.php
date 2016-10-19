<?php
/**
 * Class for CiviRules trigger handling on webform submission
 *
 * @author Erik Hommel (CiviCooP)
 * @date 26 Sep 2016
 * @license AGPL-3.0
 */

class CRM_Civiruleswebform_Trigger extends CRM_Civirules_Trigger {

  protected $objectName;

  protected $op;

  /**
   * Returns an array of entities on which the trigger reacts
   *
   * @return CRM_Civirules_TriggerData_EntityDefinition
   */
  protected function reactOnEntity() {
    $entity = 'webform';
    return new CRM_Civirules_TriggerData_EntityDefinition('webform', $entity, $this->getDaoClassName(), $entity);
  }

  protected function getAdditionalEntities() {
    $entities = parent::getAdditionalEntities();
    $entities[] = new CRM_Civirules_TriggerData_EntityDefinition('Case', 'Case', 'CRM_Case_DAO_Case' , 'Case');
    return $entities;
  }

  /**
   * Return the name of the DAO Class. If a dao class does not exist return an empty value
   *
   * @return string
   */
  protected function getDaoClassName() {
    return NULL;
  }

  /**
   * Trigger a rule for this trigger. In this case it will be called from the drupal module
   *
   * @param $op
   * @param $entity
   * @param $nid
   * @param $data
   */
  public function triggerTrigger($op, $entity, $nid, $data) {
    $this->op = $op;
    $this->objectName = $entity;
    $this->triggerParams = $data;
    // find all rules with the specific trigger and trigger each rule
    $this->setTriggerId($this->getTriggerIdForWebformSubmission());
    $triggerData = new CRM_Civiruleswebform_TriggerData_Webform($entity, $nid, $data);
    $triggerData->setTrigger($this);

    // Set the case data.
    if (!empty($data['case_id'])) {
      try {
        $case = civicrm_api3('Case', 'getsingle', array('id' => $data['case_id']));
        $triggerData->setEntityData('Case', $case);
      } catch (Exception $e) {
        // Do nothing.
      }
    }

    $rules = CRM_Civirules_BAO_Rule::getRuleIdsByTriggerId($this->getTriggerId());
    foreach ($rules as $ruleId) {
      $this->setRuleId($ruleId);
      CRM_Civirules_Engine::triggerRule($this, $triggerData);
    }
  }
  /**
   * Public getter for objectName
   */
  public function getObjectName() {
    return $this->objectName;
  }

  /**
   * Method to ge trigger id
   */
  private function getTriggerIdForWebformSubmission() {
    try {
      return civicrm_api3('CiviRuleTrigger', 'getvalue', array('name' => 'webform_submission', 'return' => 'id'));
    } catch (CiviCRM_API3_Exception $ex) {
      throw new Exception('Could not find a trigger with name webform_submission in '.__METHOD__
        .', contact your system administrator');
    }
  }
}