<?php

namespace Drupal\bubblesort\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\bubblesort\Entity\VectorInterface;

/**
 * Class VectorController.
 *
 *  Returns responses for Vector routes.
 */
class VectorController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Vector  revision.
   *
   * @param int $vector_revision
   *   The Vector  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($vector_revision) {
    $vector = $this->entityManager()->getStorage('vector')->loadRevision($vector_revision);
    $view_builder = $this->entityManager()->getViewBuilder('vector');

    return $view_builder->view($vector);
  }

  /**
   * Page title callback for a Vector  revision.
   *
   * @param int $vector_revision
   *   The Vector  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($vector_revision) {
    $vector = $this->entityManager()->getStorage('vector')->loadRevision($vector_revision);
    return $this->t('Revision of %title from %date', ['%title' => $vector->label(), '%date' => format_date($vector->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Vector .
   *
   * @param \Drupal\bubblesort\Entity\VectorInterface $vector
   *   A Vector  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(VectorInterface $vector) {
    $account = $this->currentUser();
    $langcode = $vector->language()->getId();
    $langname = $vector->language()->getName();
    $languages = $vector->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $vector_storage = $this->entityManager()->getStorage('vector');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $vector->label()]) : $this->t('Revisions for %title', ['%title' => $vector->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all vector revisions") || $account->hasPermission('administer vector entities')));
    $delete_permission = (($account->hasPermission("delete all vector revisions") || $account->hasPermission('administer vector entities')));

    $rows = [];

    $vids = $vector_storage->revisionIds($vector);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\bubblesort\VectorInterface $revision */
      $revision = $vector_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $vector->getRevisionId()) {
          $link = $this->l($date, new Url('entity.vector.revision', ['vector' => $vector->id(), 'vector_revision' => $vid]));
        }
        else {
          $link = $vector->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->getRevisionLogMessage(), '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => Url::fromRoute('entity.vector.revision_revert', ['vector' => $vector->id(), 'vector_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.vector.revision_delete', ['vector' => $vector->id(), 'vector_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['vector_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
