<?php

namespace Drupal\bubblesort;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Vector entity.
 *
 * @see \Drupal\bubblesort\Entity\Vector.
 */
class VectorAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\bubblesort\Entity\VectorInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished vector entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published vector entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit vector entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete vector entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add vector entities');
  }

}
