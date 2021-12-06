<?php

namespace Drupal\wk_hello;

use Drupal\Core\Session\AccountInterface;

class WkHelloSalutation implements WkHelloSalutationInterface {

  protected $currentUser;

  /**
   * WkHelloSalutation constructor.
   * @param AccountInterface $currentUser
   */
  public function __construct(AccountInterface $currentUser)
  {
    $this->currentUser = $currentUser;
  }

  /**
   * Returns a salutation for the current user.
   */
  public function getSalutation()
  {
    $time = new \DateTime();
    if ((int) $time->format('G') >= 06 && (int) $time->format('G') < 12) {
      return 'Good morning ' . $this->currentUser->getDisplayName();
    } else {
      return 'Good afternoon ' . $this->currentUser->getDisplayName();
    }
  }
}
