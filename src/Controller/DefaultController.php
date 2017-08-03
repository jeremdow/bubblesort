<?php

namespace Drupal\bubblesort\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class DefaultController.
 */
class DefaultController extends ControllerBase {

  /**
   * Sort.
   *
   * @return string
   *   Return Hello string.
   */
  public function sort() {
    return [
      '#theme' => 'bubblesort',
      '#test_var' => $this->t('Implement method: sort')
    ];
  }

}
