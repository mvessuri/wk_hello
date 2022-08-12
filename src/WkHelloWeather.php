<?php

namespace Drupal\wk_hello;

use GuzzleHttp\Client;
use Drupal\Core\Config\ConfigFactoryInterface;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Weather Service.
 */
class WkHelloWeather implements WkHelloWeatherInterface {

  /**
   * The current user.
   *
   * @var \GuzzleHttp\Client
   */
  protected $httpClient;

  /**
   * Config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * WkHelloWeather constructor.
   *
   * @param \GuzzleHttp\Client $http_client
   *   The HTTP Client.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The Config Factory.
   */
  public function __construct(Client $http_client, ConfigFactoryInterface $config_factory) {
    $this->httpClient = $http_client;
    $this->configFactory = $config_factory;
  }

  /**
   * Returns the weather for the current user.
   */
  public function getWeather($city) {

    $api_key = $this->configFactory->get('wk_hello.settings')->get('wk_hello.weather_api');
    $weather = [];

    if (!empty($api_key)) {

      $api_url = "http://api.weatherapi.com/v1/current.json?key=$api_key&q=$city&aqi=yes";

      try {
        $request = $this->httpClient->get($api_url);
        $response = json_decode($request->getBody());
      }
      catch (GuzzleException $e) {
        $response = [];
      }

      if (!empty($response)) {
        $weather = [
          'location' => $response->location->name,
          'condition' => $response->current->condition->text,
          'icon' => $response->current->condition->icon,
          'temperature' => $response->current->temp_c,
          'wind' => $response->current->wind_kph,
          'wind_direction' => $response->current->wind_dir,
          'precipitation' => $response->current->precip_mm,
          'humidity' => $response->current->humidity,
        ];
      }
    }
    return $weather;
  }

}
