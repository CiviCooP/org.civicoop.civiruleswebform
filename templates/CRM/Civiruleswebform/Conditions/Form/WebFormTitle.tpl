<h3>{$ruleConditionHeader}</h3>
<div class="crm-block crm-form-block crm-civirule-rule_condition-block-webform_title">
  <div class="crm-section">
    <div class="label">{$form.operator.label}</div>
    <div class="content">{$form.operator.html}</div>
    <div class="clear"></div>
  </div>
  <div class="crm-section sector-section">
    <div class="label">
      <label for="webform-select">{ts}Webform(s){/ts}</label>
    </div>
    <div class="content crm-select-container" id="webform_block">
      {$form.webform_id.html}
    </div>
    <div class="clear"></div>
  </div>
</div>
<div class="crm-submit-buttons">
  {include file="CRM/common/formButtons.tpl" location="bottom"}
</div>