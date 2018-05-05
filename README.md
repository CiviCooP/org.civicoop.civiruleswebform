# CiviRules Webform Trigger

This extension provides a Trigger to work with the CiviRules extension so that a CiviRule can invoke actions when a webform is submitted.

## Installation

This extension provides both a CiviCRM extension and a Drupal module - both need to be installed.

1. `git clone` this repository to your CiviCRM extensions directory
1. install the CiviCRM extension (eg via Adminster -> System Settings -> Extensions)
1. symlink or copy the drupal/civiruleswebform directory to your Drupal modules directory
1. enable the Drupal module (eg Admin -> Modules)

## Usage

When a webform is submitted, the content is made available to CiviActions as eg:
```
  $webform = $triggerData->getEntityData('webform');
```
