<?php

namespace Drupal\si_voyager\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\media_library\Form\AddFormBase;

/**
 * Form to create media entities using the Media Remote source plugin.
 */
class SIVoyagerMediaForm extends AddFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return $this->getBaseFormId() . '_si_voyager_media';
  }

  /**
   * {@inheritdoc}
   */
  protected function buildInputElement(array $form, FormStateInterface $form_state) {
    // Add a container to group the input elements for styling purposes.
    $form['container'] = [
      '#type' => 'container',
    ];

    $form['container']['id'] = [
      '#type' => 'text',
      '#title' => $this->t('Text ID'),
      '#required' => TRUE,
      '#attributes' => [
        'placeholder' => 'ID of Media',
      ],
    ];

    return $form;
  }

}
