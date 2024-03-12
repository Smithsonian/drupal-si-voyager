<?php

namespace Drupal\si_voyager\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\si_voyager\Utility\SiVoyagerUtility;

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

    /**
     * {@inheritdoc}
     */
    public function viewElements(FieldItemListInterface $items, $langcode) {
        $elements = [];

        foreach ($items as $delta => $item) {
            // Prepare the content or any data you want to pass to the template.
            // Use your theme hook, and pass variables to the template.

            // Test if the entity is embedded and being edited in CKEDITOR
            if (isset($_GET['text'])) {
//                ray($item->value . '/scene-image-thumb.jpg');
                $scene_image = $item->value . '/scene-image-thumb.jpg';
            } else {
                $scene_image = NULL;
            }

            $uuid = SiVoyagerUtility::extractUuidFromUrl($item->value);

            $elements[$delta] = [
                '#theme' => 'si_voyager',
                '#si_voyager_id' => $uuid,
                '#scene_image' => $scene_image,
                '#attached' => [
                    'library' => [
                        'si_voyager/si_voyager_viewer',
                    ],
                ],
            ];
        }

//        ray($elements);

        return $elements;
    }
}
