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
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: sort')
    ];
  }

}
