<?php

/**
 * @file
 * Contains vector.page.inc.
 *
 * Page callback for Vector entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Vector templates.
 *
 * Default template: vector.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_vector(array &$variables) {
  // Fetch Vector Entity Object.
  $vector = $variables['elements']['#vector'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
