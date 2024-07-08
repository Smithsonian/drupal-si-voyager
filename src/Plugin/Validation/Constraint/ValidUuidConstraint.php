<?php

namespace Drupal\si_voyager\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Validates that a field contains a valid UUID.
 *
 * @Constraint(
 *   id = "si_voyager_id",
 *   label = @Translation("Valid UUID", context = "Validation"),
 *   type = {"string"},
 *   validator = "Drupal\si_voyager\Plugin\Validation\Constraint\ValidUuidConstraintValidator",
 * )
 */
class ValidUuidConstraint extends Constraint {

  public $notValidUuidMessage = 'The URL must contain a valid UUID.';

}
