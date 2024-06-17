<?php

namespace Drupal\si_voyager\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\si_voyager\Utility\SiVoyagerUtility;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Template\Attribute;

/**
 * Plugin implementation of the 'si_voyager' formatter.
 *
 * @FieldFormatter(
 *   id = "si_voyager",
 *   label = @Translation("SI Voyager formatter"),
 *   field_types = {
 *     "string"
 *   }
 * )
 */
class SIVoyagerFormatter extends FormatterBase {

  const VOYAGER_BASE_DOCUMENT_URL = 'https://3d-api.si.edu/content/document';

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [$this->t('Displays 3D Voyager embed.')];
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'show_title' => TRUE,
      'show_logo' => TRUE,
      'show_menu' => TRUE,
      'show_help' => TRUE,
      'bg_style' => '',
      'bg_color' => '',
      'aspect_ratio' => 'aspect-widescreen',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    $formatterSettings = $this->getSettings();
    // Prepare the content or any data you want to pass to the template.
    // Use your theme hook, and pass variables to the template.
    foreach ($items as $delta => $item) {
      $uuid = SiVoyagerUtility::extractUuidFromUrl($item->value);
      $documentUrl = sprintf('%s/%s/', self::VOYAGER_BASE_DOCUMENT_URL, $uuid);
      $attributes = new Attribute(
        [
          'class' => ['si-voyager-explorer'],
        ]
      );
      $componentAttributes = new Attribute(
        [
          'root' => $documentUrl,
          'document' => 'document.json',
          'id' => 'voyager-component-' . $uuid,
          'class' => ['si-voyager-explorer-component'],
        ]
      );

      // Set the UI elements to display in the viewer.
      // See: https://smithsonian.github.io/dpo-voyager/explorer/api/#ui-attributes for more information.
      $uiElements = ['none'];
      if ((bool) $formatterSettings['show_title']) {
        $uiElements[] = 'title';
      }
      if ((bool) $formatterSettings['show_logo']) {
        $uiElements[] = 'logo';
      }
      if ((bool) $formatterSettings['show_menu']) {
        $uiElements[] = 'menu';
      }
      if ((bool) $formatterSettings['show_help']) {
        $uiElements[] = 'help';
      }
      $uiMode = implode("|", $uiElements);
      $componentAttributes->setAttribute('uimode', $uiMode);

      if (!empty($formatterSettings['bg_style'])) {
        $componentAttributes->setAttribute('bgstyle', $formatterSettings['bg_style']);
      }

      if (!empty($formatterSettings['bg_color'])) {
        $componentAttributes->setAttribute('bgcolor', trim($formatterSettings['bg_color']));
      }

      // Set the class for the aspect ratio.
      if (!empty($formatterSettings['aspect_ratio'])) {
        $attributes->addClass($formatterSettings['aspect_ratio']);
      }

      // Test if the entity is embedded and being edited in CKEDITOR
      if (isset($_GET['text'])) {
        $scene_image = 'https://3d-api.si.edu/content/document/3d_package:' . $uuid . '/scene-image-thumb.jpg';
      } else {
        $scene_image = NULL;
      }

      $elements[$delta] = [
          '#theme' => 'si_voyager',
          '#si_voyager_id' => $uuid,
          '#scene_image' => $scene_image,
          '#component_attributes' => $componentAttributes,
          '#attributes' => $attributes,
          '#attached' => [
              'library' => [
                  'si_voyager/si_voyager_viewer',
              ],
          ],
      ];
    }

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form = parent::settingsForm($form, $form_state);
    $form['settings_heading'] = [
      '#type' => 'item',
      '#title' => $this->t('Viewer settings'),
      '#description' => $this->t('Elements to display in the viewer. (if available)'),
    ];

    $form['show_title'] = [
      '#title' => $this->t('Show scene title'),
      '#type' => 'checkbox',
      '#default_value' => $this->getSetting('show_title'),
    ];

    $form['show_logo'] = [
      '#title' => $this->t('Show the SI Voyager logo'),
      '#type' => 'checkbox',
      '#default_value' => $this->getSetting('show_logo'),
    ];

    $form['show_menu'] = [
      '#title' => $this->t('Show the viewer menu toolbar.'),
      '#type' => 'checkbox',
      '#default_value' => $this->getSetting('show_menu'),
    ];

    $form['show_help'] = [
      '#title' => $this->t('Show the help button.'),
      '#type' => 'checkbox',
      '#default_value' => $this->getSetting('show_help'),
    ];

    $form['bg_style'] = [
      '#title' => $this->t('Background style'),
      '#type' => 'select',
      '#options' => [
        '' => $this->t('Default'),
        'Solid' => $this->t('Solid'),
        'LinearGradient' => $this->t('Linear Gradient'),
        'RadialGradient' => $this->t('Radial Gradient'),
      ],
      '#default_value' => $this->getSetting('bg_style'),
    ];

    $form['bg_color'] = [
      '#title' => $this->t('Background color'),
      '#type' => 'textfield',
      '#description' => $this->t('Enter one (Solid) or two (Gradient) CSS colors (separated by a space). Example: "#74D1EA #FFCD00".'),
      '#default_value' => $this->getSetting('bg_color'),
    ];

    $form['aspect_ratio'] = [
      '#title' => $this->t('Aspect ratio'),
      '#type' => 'select',
      '#options' => [
        'aspect-widescreen' => $this->t('16:9 - Widescreen Video'),
        'aspect-square' => $this->t('1:1 - Square'),
        'aspect-fullscreen' => $this->t('4:3 - Fullscreen Video'),
        'aspect-mobile-portrait' => $this->t('9:16 - Mobile Portrait'),
      ],
      '#default_value' => $this->getSetting('aspect_ratio'),
    ];

    return $form;
  }

}
