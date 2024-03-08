# SI Voyager Module for Drupal 10

The SI Voyager module integrates with the Smithsonian 3D digital collection, allowing users to display 3D models from [https://3d.si.edu](https://3d.si.edu) within their Drupal 10 site. This guide walks you through the process of adding a 3D model to your site.

## Getting Started

Before you begin, ensure the SI Voyager module is installed and enabled on your Drupal 10 site.

## Installing SI Voyager Module

The SI Voyager module can be installed via Composer, which is the recommended way to manage Drupal dependencies. To install the module, you need to add the custom repository for the module and then require it using Composer.

Open your `composer.json` file located at the root of your Drupal project and add the following repository configurations under the `repositories` key:

```json
{
  "repositories": [
    {
      "type": "composer",
      "url": "https://packages.drupal.org/10"
    },
    {
      "type": "git",
      "url": "git@github.com:Smithsonian/drupal-si-voyager.git"
    }
  ]
}
```
```

### Adding a 3D Model

To add a 3D model from the Smithsonian 3D Collection to your site, follow these steps:

1. **Navigate to the Smithsonian 3D Collection**
    - Open your web browser and go to the Smithsonian 3D Collection at [https://3d.si.edu](https://3d.si.edu).
    - Browse or search the collection to find a 3D model you wish to display on your site.

2. **Copy the Model's Link**
    - Once you have selected a 3D model, click on it to view its details.
    - Look for the "Share" or "Copy Link" button. This is usually represented by an icon resembling a link or share symbol.
    - Click the "Copy Link" or "Share" button to copy the model's URL to your clipboard. This URL should look similar to `https://3d.si.edu/object/3d/unio-coloradoensis:2d23d94f-4e12-48ba-b849-96b88db78987`.

3. **Paste the URL into the SI Voyager Field**
    - Navigate to the page on your Drupal site where you wish to display the 3D model. This might be a content creation form, settings page for the SI Voyager module, or another location specified in your module's documentation.
    - Find the field designated for the SI Voyager URL. It might be labeled something like "3D Model URL", "Smithsonian 3D URL", or similar.
    - Paste the copied URL into this field.

4. **Save or Publish Your Content**
    - After pasting the URL, proceed to save or publish your content according to your site's workflow.
    - Once published, the 3D model should be displayed on your site where you've placed the SI Voyager field.

### Troubleshooting

If you encounter any issues while adding a 3D model to your site, please review the following:

- **Check the URL Format:** Ensure that the URL copied from the Smithsonian
