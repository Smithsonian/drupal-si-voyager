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

        // Test if the entity is embedded and being edited in CKEDITOR
        if (isset($_GET['text'])) {
            $no_thumbnail_url = base_path() . 'core/modules/media/images/icons/no-thumbnail.png';
        } else {
            $no_thumbnail_url = NULL;
        }

        foreach ($items as $delta => $item) {
            // Prepare the content or any data you want to pass to the template.
            // Use your theme hook, and pass variables to the template.

            $uuid = SiVoyagerUtility::extractUuidFromUrl($item->value);

            $elements[$delta] = [
                '#theme' => 'si_voyager',
                '#si_voyager_id' => $uuid,
                '#no_thumbnail_url' => $no_thumbnail_url,
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
