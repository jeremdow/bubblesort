<?php

namespace Drupal\bubblesort\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ShuffleForm.
 */
class ShuffleForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'shuffle_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $vector = NULL) {
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Shuffle'),
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

    // Re-initialize the array.
    $entity->shuffle();
  }

}
