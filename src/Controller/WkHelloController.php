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
    $config = $this->config('wk_hello.settings');
    $text = 'Hello World!';

    if (isset($config->get('wk_hello.text')['value'])) {
      $text = $config->get('wk_hello.text')['value'];
    }

    return [
      '#type' => 'markup',
      '#markup' => $text,
    ];
  }

}
