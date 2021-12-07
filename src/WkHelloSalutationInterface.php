<?php

namespace Drupal\wk_hello;

/**
 * Salutation interface.
 */
interface WkHelloSalutationInterface {

  /**
   * Returns a salutation for the current user.
   */
  public function getSalutation();

}
