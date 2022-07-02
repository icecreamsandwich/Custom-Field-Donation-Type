<?php

namespace Drupal\custom_field_donation_type\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'Donation Type' formatter.
 *
 * @FieldFormatter(
 *   id = "custom_field_donation_type_donation_type",
 *   label = @Translation("Donation Type"),
 *   field_types = {"string"},
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

}
