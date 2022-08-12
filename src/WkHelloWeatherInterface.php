<?php

namespace Drupal\wk_hello;

/**
 * Salutation interface.
 */
interface WkHelloWeatherInterface {

  /**
   * Returns a werather array.
   */
  public function getWeather($city);

}
