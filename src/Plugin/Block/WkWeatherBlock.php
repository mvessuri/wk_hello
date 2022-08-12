<?php

namespace Drupal\wk_hello\Plugin\Block;

/**
 * @file
 * Provides a block for salutation.
 */

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\wk_hello\WkHelloWeatherInterface;

/**
 * Weather Block.
 *
 * @Block(
 *  id = "wk_hello_weather_block",
 *  admin_label = @Translation("weKnow Weather Block"),
 * )
 */
class WkWeatherBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The Weather Service.
   *
   * @var \Drupal\wk_hello\WkHelloWeatherInterface
   */
  protected $weatherService;

  /**
   * WkHelloWeather constructor.
   *
   * @param array $configuration
   *   The plugin configuration.
   * @param string $plugin_id
   *   The plugin id.
   * @param mixed $plugin_definition
   *   The plugin definition.
   * @param \Drupal\wk_hello\WkHelloWeatherInterface $weather
   *   The Weather Service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, WkHelloWeatherInterface $weather) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->weatherService = $weather;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('wk_hello.weather')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    $city = $this->configuration['weather_block_city'];

    $weather = $this->weatherService->getWeather($city);

    if (!empty($weather)) {
      $output = [
        '#theme' => 'wk_hello_weather',
        '#location' => $weather['location'],
        '#temperature' => $weather['temperature'],
        '#condition' => $weather['condition'],
        '#icon' => $weather['icon'],
        '#wind' => $weather['wind'],
        '#wind_direction' => $weather['wind_direction'],
        '#precipitation' => $weather['precipitation'],
        '#humidity' => $weather['humidity'],
      ];
    }
    else {
      $output = [
        '#markup' => $this->t('No weather data available.'),
      ];
    }

    return $output;

  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    // Set the cache expiry time set on the block configuration.
    $cache = isset($this->configuration['weather_block_cache']) ? $this->configuration['weather_block_cache'] : 0;
    return $cache * 60;
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['weather_block_settings'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Weather Block Settings'),
    ];

    $form['weather_block_settings']['weather_block_city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Weather Block City'),
      '#default_value' => isset($this->configuration['weather_block_city']) ? $this->configuration['weather_block_city'] : '',
      '#required' => TRUE,
    ];
    $form['weather_block_settings']['weather_block_cache'] = [
      '#type' => 'select',
      '#title' => $this->t('Weather Block Cache time'),
      '#default_value' => isset($this->configuration['weather_block_cache']) ? $this->configuration['weather_block_cache'] : 0,
      '#options' => [
        0 => $this->t('No Cache'),
        10 => $this->t('10 minutes'),
        30 => $this->t('30 minutes'),
        60 => $this->t('1 hour'),
        360 => $this->t('6 hours'),
        1440 => $this->t('1 day'),
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['weather_block_city'] = $form_state->getValue(['weather_block_settings', 'weather_block_city']);
    $this->configuration['weather_block_cache'] = $form_state->getValue(['weather_block_settings', 'weather_block_cache']);

  }

}
