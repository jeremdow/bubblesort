<?php

namespace Drupal\bubblesort;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface VectorStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Vector revision IDs for a specific Vector.
   *
   * @param \Drupal\bubblesort\Entity\VectorInterface $entity
   *   The Vector entity.
   *
   * @return int[]
   *   Vector revision IDs (in ascending order).
   */
  public function revisionIds(VectorInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Vector author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Vector revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\bubblesort\Entity\VectorInterface $entity
   *   The Vector entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(VectorInterface $entity);

  /**
   * Unsets the language for all Vector with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
