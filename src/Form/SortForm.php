<?php

namespace Drupal\bubblesort\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class SortForm.
 */
class SortForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'sort_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $vector = NULL) {
    $form['sort'] = [
      '#type' => 'submit',
      '#value' => $this->t('Step'),
      '#submit' => array('::sortHandler'),
      '#disabled' => $vector->field_sorted->value,
    ];
    $form['shuffle'] = [
      '#type' => 'submit',
      '#value' => $this->t('Shuffle'),
      '#submit' => array('::shuffleHandler'),
    ];

    $this->entity = $vector;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * Sort handler.
   */
  public function sortHandler(array &$form, FormStateInterface $form_state) {
    $entity = &$this->entity;

    // Perform the sort.
    $entity->sort();
  }

  /**
   * Shuffle handler.
   */
  public function shuffleHandler(array &$form, FormStateInterface $form_state) {
    $entity = &$this->entity;

    // Re-initialize the array.
    $entity->shuffle();
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $form_state->setRedirect('entity.vector.canonical', ['vector' => $entity->id()]);
  }

}
