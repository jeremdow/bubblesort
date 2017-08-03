<?php

namespace Drupal\bubblesort\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class DefaultController.
 */
class DefaultController extends ControllerBase {

  /**
   * Render BubbleSort simulation.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function render() {
    return [
      '#theme' => 'bubblesort',
      '#test_var' => $this->t('This is passed from the default controller.')
    ];
  }

}
