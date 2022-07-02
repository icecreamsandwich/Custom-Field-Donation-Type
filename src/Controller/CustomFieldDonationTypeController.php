<?php

namespace Drupal\custom_field_donation_type\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for custom_field_donation_type routes.
 */
class CustomFieldDonationTypeController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

}
