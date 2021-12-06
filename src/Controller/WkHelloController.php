<?php

namespace Drupal\wk_hello\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\wk_hello\WkHelloSalutationInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Shows a hello world message.
 */
class WkHelloController extends ControllerBase {

  /**
   * @var WkHelloSalutationInterface $salutation
   */
  protected $salutation;

  /**
   * Class constructor.
   */
  public function __construct(WkHelloSalutationInterface $salutation)
  {
    $this->salutation = $salutation;
  }

  public static function create(ContainerInterface $container)
  {
    return new static(
      $container->get('wk_hello.salutation')
    );
  }


  /**
   * Displays a hello message.
   */
  public function content() {
    $config = $this->config('wk_hello.settings');
    $text = '<h2>' . $this->salutation->getSalutation() . '</h2>';

    if (isset($config->get('wk_hello.text')['value'])) {
      $text .= $config->get('wk_hello.text')['value'];
    }

    return [
      '#type' => 'markup',
      '#markup' => $text,
    ];
  }

}
