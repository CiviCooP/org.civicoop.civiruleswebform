<?php

/**
 * Class CRM_Civiruleswebform_TriggerData_Webform to receive and process data from a webform submission
 *
 * @author Erik Hommel (CiviCooP)
 * @date 26 Sep 2016
 * @license AGPL-3.0

 */
class CRM_Civiruleswebform_TriggerData_Webform extends CRM_Civirules_TriggerData_TriggerData {

  protected $entity;

  /**
   * CRM_Civiruleswebform_TriggerData_Webform constructor.
   * @param $entity
   * @param $objectId
   * @param $data
   */
  public function __construct($entity, $objectId, $data) {
    parent::__construct();

    $this->entity = $entity;
    $this->setEntityData($entity, $data);
    $this->setContactId($data['contact_id']);
  }

  /**
   * Getter for entity
   *
   * @return mixed
   */
  public function getEntity() {
    return $this->entity;
  }
}