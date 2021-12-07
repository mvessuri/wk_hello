<?php

namespace Drupal\wk_hello;

use Drupal\Core\Session\AccountInterface;

/**
 * Salutation service.
 */
class WkHelloSalutation implements WkHelloSalutationInterface {

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  /**
   * WkHelloSalutation constructor.
   *
   * @param \Drupal\Core\Session\AccountInterface $currentUser
   *   The Current User.
   */
  public function __construct(AccountInterface $currentUser) {
    $this->currentUser = $currentUser;
  }

  /**
   * Returns a salutation for the current user.
   */
  public function getSalutation() {
    $time = new \DateTime();
    if ((int) $time->format('G') >= 06 && (int) $time->format('G') < 12) {
      return 'Good morning ' . $this->currentUser->getDisplayName();
    }
    else {
      return 'Good afternoon ' . $this->currentUser->getDisplayName();
    }
  }

}
