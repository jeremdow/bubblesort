<?php

namespace Drupal\bubblesort;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\bubblesort\Entity\VectorInterface;

/**
 * Defines the storage handler class for Vector entities.
 *
 * This extends the base storage class, adding required special handling for
 * Vector entities.
 *
 * @ingroup bubblesort
 */
class VectorStorage extends SqlContentEntityStorage implements VectorStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(VectorInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {vector_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {vector_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(VectorInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {vector_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('vector_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
