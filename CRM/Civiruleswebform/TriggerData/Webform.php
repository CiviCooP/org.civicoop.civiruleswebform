<?php

class CRM_Civiruleswebform_TriggerData_Webform extends CRM_Civirules_TriggerData_TriggerData {

  protected $entity;

  public function __construct($entity, $objectId, $data) {
    parent::__construct();

    $this->entity = $entity;

    $this->setEntityData($entity, $data);
      $this->contact_id = $data['contact_id'];
  }

  public function getEntity() {
    return $this->entity;
  }
}