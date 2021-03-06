<?php
/**
 * Copyright (C) 2014 Michael Peters
 * Licensed under GNU GPL v3. See LICENSE for full details
 */

abstract class SprintProjectCustomField extends PhabricatorProjectCustomField
  implements PhabricatorStandardCustomFieldInterface {

  /**
   * Use this function to determine whether to show sprint fields
   *
   *    public function renderPropertyViewValue(array $handles) {
   *      if (!$this->shouldShowSprintFields()) {
   *        return
   *      }
   *      // Actually show something
   *
   * NOTE: You can NOT call this in functions like "shouldAppearInEditView" because
   * $this->getObject() is not available yet.
   *
   */
  protected function shouldShowSprintFields()
  {
    return (strpos($this->getObject()->getName(),'Sprint') !== FALSE);
  }

  /**
   * As nearly as I can tell, this is never actually used, but is required in order to
   * implement PhabricatorStandardCustomFieldInterface
   */
  public function getStandardCustomFieldNamespace() {
    return 'project';
  }

  /**
   * Each subclass must either declare a proxy or implement this method
   */
  public function renderPropertyViewLabel() {
    if (!$this->shouldShowSprintFields()) {
      return;
    }

    if ($this->getProxy()) {
      return $this->getProxy()->renderPropertyViewLabel();
    }
    return $this->getFieldName();

  }

  /**
   * Each subclass must either declare a proxy or implement this method
   */
  public function renderPropertyViewValue(array $handles) {
    if (!$this->shouldShowSprintFields()) {
      return;
    }

    if ($this->getProxy()) {
      return $this->getProxy()->renderPropertyViewValue($handles);
    }
    throw new PhabricatorCustomFieldImplementationIncompleteException($this);
  }

  // == Edit View
  public function shouldAppearInEditView() {
    return true;
  }

  /**
   * Each subclass must either declare a proxy or implement this method
   */
  public function renderEditControl(array $handles) {
    if (!$this->shouldShowSprintFields()) {
      return;
    }

    if ($this->getProxy()) {
      return $this->getProxy()->renderEditControl($handles);
    }
    throw new PhabricatorCustomFieldImplementationIncompleteException($this);
  }
}
