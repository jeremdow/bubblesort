<?php

namespace Drupal\bubblesort\Entity;

use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\RevisionableInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Vector entities.
 *
 * @ingroup bubblesort
 */
interface VectorInterface extends RevisionableInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Implement the bubble sort.
   *
   * @return \Drupal\bubblesort\Entity\VectorInterface
   *   The called Vector entity.
   */
  public function sort();

  /**
   * Re-initialize the array with random integers.
   *
   * @return \Drupal\bubblesort\Entity\VectorInterface
   *   The called Vector entity.
   */
  public function shuffle();


  /**
   * Gets the Vector name.
   *
   * @return string
   *   Name of the Vector.
   */
  public function getName();

  /**
   * Sets the Vector name.
   *
   * @param string $name
   *   The Vector name.
   *
   * @return \Drupal\bubblesort\Entity\VectorInterface
   *   The called Vector entity.
   */
  public function setName($name);

  /**
   * Gets the Vector creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Vector.
   */
  public function getCreatedTime();

  /**
   * Sets the Vector creation timestamp.
   *
   * @param int $timestamp
   *   The Vector creation timestamp.
   *
   * @return \Drupal\bubblesort\Entity\VectorInterface
   *   The called Vector entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Vector published status indicator.
   *
   * Unpublished Vector are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Vector is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Vector.
   *
   * @param bool $published
   *   TRUE to set this Vector to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\bubblesort\Entity\VectorInterface
   *   The called Vector entity.
   */
  public function setPublished($published);

  /**
   * Gets the Vector revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Vector revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\bubblesort\Entity\VectorInterface
   *   The called Vector entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Vector revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Vector revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\bubblesort\Entity\VectorInterface
   *   The called Vector entity.
   */
  public function setRevisionUserId($uid);

}
