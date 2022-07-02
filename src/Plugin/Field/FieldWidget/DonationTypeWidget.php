<?php

namespace Drupal\custom_field_donation_type\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;

/**
 * Defines the 'custom_field_donation_type_donation_type' field widget.
 *
 * @FieldWidget(
 *   id = "custom_field_donation_type_donation_type",
 *   label = @Translation("Donation Type"),
 *   field_types = {"string"},
 * )
 */
class DonationTypeWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
  $id = $this->fieldDefinition->getUniqueIdentifier();
  $wrapper_id = "XXX-$id-$delta-replace";
  $value1_options = array(
    'online' => 'online',
    'offline' => 'offline'
  );

  $selected_value1 = $items[$delta]->value1 ?? 0;
  $element['value1'] = $element + [
    '#type' => 'select',
    '#options' => $value1_options,
    '#empty_option' => '---',
    '#default_value' => '',
    '#weight' => 1,
    '#ajax' => [
      'event' => 'change',
      'method' => 'html',
      'callback' => [$this, 'getValues'],
      'wrapper' => $wrapper_id,
      'progress' => [
        'type' => 'throbber',
        'message' => NULL,
      ],
    ],
    '#attributes' => [
      'name' => 'field_donation_type',
    ],
  ];

  $element['value2'] = [
    '#type' => 'radios',
    '#title' => t('Select Offline Type'),
    '#default_value' => '',
    '#options' => $this->loadOptions($selected_value1), //array(t('Optional'), t('Required'))
    '#id' => 'al1',
    '#title_display' =>'Offline Type'
  ];

  //set visibility
  $element['value2']['#states'] = [
    'visible' => [
      [
        [':input[name="field_donation_type"]' => ['value' => 'offline']],
      ],
    ],
  ];

  $element += [
    '#type' => 'container',
    '#attributes' => ['class' => ['container-inline']],
  ];

  return $element;
  }

  public function getValues(array &$form, FormStateInterface $form_state) {
    $triggeringElement = $form_state->getTriggeringElement();
    $selected_value = $triggeringElement['#value'];
    $html = '';
    $options = $this->loadOptions($selected_value);
    foreach ($options as $key => $value) {
      $html .= "<option value='$key'>$value</option>";
    }
  
    $ajax_response = new AjaxResponse();
    $wrapper_id = $triggeringElement['#ajax']['wrapper'];
    $ajax_response->addCommand(new HtmlCommand("#{$wrapper_id} select", $html));
    return $ajax_response;
  }

  private function loadOptions($selected_value) {
    $options = [];
    if ($selected_value == 'offline') {
      // load whatever options belong to the value of $selected_value
      $options = array(t('Cash'), t('Check'));
    }
    
    return $options;
  }

}
