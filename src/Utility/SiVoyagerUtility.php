<?php

namespace Drupal\si_voyager\Utility;

/**
 * Utility functions for the SI Voyager module.
 */
class SiVoyagerUtility {

  /**
   * Extracts a UUID from a given URL.
   *
   * @param string $url
   *   The URL from which to extract the UUID.
   *
   * @return string|null The extracted UUID or null if not found.
   */
  public static function extractUuidFromUrl(string $url): ?string {
    $parsedUrl = parse_url($url);
    $path = $parsedUrl['path'] ?? '';
    $uuidPattern = '/[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/';

    if (preg_match($uuidPattern, $path, $matches)) {
      return trim($matches[0]);
    }

    return NULL;
  }

}
