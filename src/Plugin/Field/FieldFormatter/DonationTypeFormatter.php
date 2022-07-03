<?php

namespace Drupal\custom_field_donation_type\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'Donation Type' formatter.
 *
 * @FieldFormatter(
 *   id = "custom_field_donation_type_formatter",
 *   label = @Translation("Donation Type"),
 *   field_types = {"custom_field_donation_type_donation_type"},
 * )
 */
class DonationTypeFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];

    foreach ($items as $delta => $item) {
      $element[$delta] = [
        '#type' => 'item',
        '#markup' => $item->value,
      ];
    }

    return $element;
  }

//   /**
//  * {@inheritdoc}
//  */
// public function settingsForm(array $form, FormStateInterface $form_state) {
//   $form['text_length'] = [
//     '#title' => $this->t('Text length'),
//     '#type' => 'select',
//     '#options' => [
//       'short' => $this->t('Short'),
//       'long' => $this->t('Long'),
//     ],
//     '#default_value' => $this->getSetting('text_length'),
//   ];

//   return $form;
// }

}
