<?php

namespace Drupal\si_voyager\Plugin\Validation\Constraint;

use Drupal\si_voyager\Utility\SiVoyagerUtility;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates the ValidUuid constraint.
 */
class ValidUuidConstraintValidator extends ConstraintValidator {

    /**
     * {@inheritdoc}
     */
    public function validate($items, Constraint $constraint) {
        foreach ($items as $item) {
            // Now $item->value should be the string you want to validate.

            $uuid = SiVoyagerUtility::extractUuidFromUrl($item->value);

            if (!$uuid) {
                $this->context->buildViolation($constraint->notValidUuidMessage)
                    ->atPath($item->getFieldDefinition()->getName())
                    ->addViolation();
            }

//            if (!empty($item->value) && !preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $item->value)) {
//                $this->context->buildViolation($constraint->notValidUuidMessage)
//                    ->atPath($item->getFieldDefinition()->getName())
//                    ->addViolation();
//            }
        }
    }
}
