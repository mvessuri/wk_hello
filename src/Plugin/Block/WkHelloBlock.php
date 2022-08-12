<?php

namespace Drupal\wk_hello\Plugin\Block;

/**
 * @file
 * Provides a block for salutation.
 */

use Drupal\Core\Block\BlockBase;
use Drupal\wk_hello\WkHelloSalutationInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;

/**
 * Salutation Block.
 *
 * @Block(
 *  id = "wk_hello_block",
 *  admin_label = @Translation("Hello World Block"),
 * )
 */
class WkHelloBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The salutation service.
   *
   * @var \Drupal\wk_hello\WkHelloSalutationInterface
   */
  protected $salutation;

  /**
   * The config service.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $config;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, WkHelloSalutationInterface $salutation, $config) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->salutation = $salutation;
    $this->config = $config;

  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('wk_hello.salutation'),
      $container->get('config.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->config->get('wk_hello.settings');
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
