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
 *   id = "custom_field_donation_type_widget",
 *   label = @Translation("Donation Type"),
 *   field_types = {"custom_field_donation_type_donation_type"},
 * )
 */
class DonationTypeWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
  // $id = $this->fieldDefinition->getUniqueIdentifier();
  // $wrapper_id = "XXX-$id-$delta-replace";
  $value1_options = array(
    'online' => 'online',
    'offline' => 'offline'
  );

  $selected_value1 = $items[$delta]->value1 ?? 0;
  $element['value1'] = $element + [
    '#type' => 'select',
    '#options' => $value1_options,
    '#empty_option' => '---',
    '#default_value' => $selected_value1,
    '#weight' => 1,
    '#attributes' => [
      'name' => 'field_donation_type',
    ],
  ];

  $selected_value2 = $items[$delta]->value2 ?? 0;
  $element['value2'] = [
    '#type' => 'radios',
    '#title' => t('Select Offline Type'),
    '#default_value' => $selected_value2,
    '#options' => $this->loadOptions($selected_value1),
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
      $options = array(
        'Cash' => 'Cash',
        'Check' => 'Check'
      );
    }
    return $options;
  }

    /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'schema' => 'dataset',
    ] + parent::defaultSettings();
  }

//   /**
//  * {@inheritdoc}
//  */
//   public function settingsForm(array $form, FormStateInterface $form_state) {
//     $element['size'] = [
//       '#type' => 'number',
//       '#title' => $this->t('Size of textfield'),
//       '#default_value' => $this->getSetting('size'),
//       '#required' => TRUE,
//       '#min' => 1,
//     ];

//     return $element;
//   }

   /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    $new_values = [];
    $form_values = $form_state->getUserInput();
    foreach ($values as $delta => $value) {
      $new_values[$delta] = $form_values['field_donation_type'].':'.$value['value2'];
    }
    return $new_values;
  }

}
