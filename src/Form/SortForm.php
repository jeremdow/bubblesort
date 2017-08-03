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
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Step'),
      '#disabled' => $vector->field_sorted->value,
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
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $entity = &$this->entity;

    // Perform the sort.
    $entity->sort();

    $form_state->setRedirect('entity.vector.canonical', ['vector' => $entity->id()]);
  }

}
