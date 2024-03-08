<?php

namespace Drupal\si_voyager\Plugin\media\Source;

use Drupal\Core\Entity\Entity\EntityViewDisplay;
use Drupal\media\MediaInterface;
use Drupal\media\MediaSourceBase;
use Drupal\media\MediaSourceFieldConstraintsInterface;

/**
 * External asset media source.
 *
 * @MediaSource(
 *   id = "si_voyager_id",
 *   label = @Translation("SI Voyager ID Source"),
 *   description = @Translation("Uses a text ID for SI Voyager."),
 *   allowed_field_types = {"string"},
 *   default_thumbnail_filename = "generic.png"
 * )
 */
class SIVoyagerIDSource extends MediaSourceBase implements MediaSourceFieldConstraintsInterface {

    /**
     * Key for "Name" metadata attribute.
     *
     * @var string
     */
    const METADATA_ATTRIBUTE_NAME = 'name';

    /**
     * {@inheritdoc}
     */
    public function getMetadataAttributes() {
        return [
            static::METADATA_ATTRIBUTE_NAME => $this->t('Name'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getMetadata(MediaInterface $media, $attribute_name) {
        $source_field = $this->configuration['source_field'];
        $value = $media->get($source_field)->value;
        switch ($attribute_name) {
            case static::METADATA_ATTRIBUTE_NAME:
                return $value;
        }
        return NULL;
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldConstraints(): array {
        // Define any constraints for your media source's field here
        return [
            // Example constraint: Ensure the field is not empty
            'not_empty' => [
                'Constraint' => 'NotEmpty',
            ],
        ];
    }

    public function getSourceFieldConstraints(): array {
        return [
            'si_voyager_id' => [],
        ];
    }

    /**
     * Figure out the formatter class to be used on a given media entity.
     *
     * @param \Drupal\media\MediaInterface $media
     *   The media entity we are interested in.
     *
     * @return string
     *   The FQN of the formatter class configured in the `default` media display
     *   for the media source field.
     */
    public function getFormatterClass(MediaInterface $media) {
        $source_field = $this->configuration['source_field'];
        $media_type = $media->bundle();
        $view_mode = 'default';
        $display = EntityViewDisplay::load('media.' . $media_type . '.' . $view_mode);
        $source_field_display = $display->getComponent($source_field);
        $formatter = $source_field_display['type'];
        return $formatter;
    }
}
