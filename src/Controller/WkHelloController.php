<?php

namespace Drupal\wk_hello\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Shows a hello world message.
 */
class WkHelloController extends ControllerBase {

  /**
   * Displays a hello message.
   */
  public function content() {
    $text = 'Hello World!';

    return [
      '#type' => 'markup',
      '#markup' => $text,
    ];
  }

}
