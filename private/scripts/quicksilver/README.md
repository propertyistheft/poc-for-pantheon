# Quicksilver Debugging #

This example is intended for users who want to explore the potential for Quicksilver with a quick debugging example.

## Requirements

While these scripts can be downloaded individually, they are meant to work with Composer. See the installation in the next section.

- Quicksilver script projects and the script name itself should be consistent in naming convention.
- README should include a recommendation for types of hooks and stages that the script should run on.
  - For example, "This script should run on `clone_database` and the `after` stage.
  - Provide a snippet that can be pasted into the `pantheon.yml` file.

### Installation

This project is designed to be included from a site's `composer.json` file, and placed in its appropriate installation directory by [Composer Installers](https://github.com/composer/installers).

In order for this to work, you should have the following in your composer.json file:

```json
{
  "require": {
    "composer/installers": "^1"
  },
  "extra": {
    "installer-paths": {
      "web/private/scripts/quicksilver": ["type:quicksilver-script"]
    }
  }
}
```

The project can be included by using the command:

`composer require pantheon-quicksilver/debugging-example`

If you are using one of the example PR workflow projects ([Drupal 8](https://www.github.com/pantheon-systems/example-drops-8-composer), [Drupal 9](https://www.github.com/pantheon-systems/drupal-project), [WordPress](https://www.github.com/pantheon-systems/example-wordpress-composer)) as a starting point for your site, these entries should already be present in your `composer.json`.

### Example `pantheon.yml`

Here's an example of what your `pantheon.yml` would look like if this were the only Quicksilver operation you wanted to use.

```yaml
api_version: 1

workflows:
  clear_cache:
    after:
      - type: webphp
        description: Dump debugging output
        script: private/scripts/quicksilver/debugging-example/debugging-example.php
```

### Example `terminus workflow:watch` Output ###

Triggering cache clears from your dashboard you should enjoy nice debugging output like this:

```shell
$> terminus workflow:watch your-site-name
[2015-12-15 03:17:26] [info] Watching workflows...
[2015-12-15 03:17:50] [info] Started 1c5421b8-a2db-11e5-8a28-bc764e10b0ce Clear cache for "dev" (dev)
[2015-12-15 03:17:58] [info] Finished Workflow 1c5421b8-a2db-11e5-8a28-bc764e10b0ce Clear cache for "dev" (dev)
[2015-12-15 03:18:00] [info]
------ Operation: Dump debugging output finished in 2s ------
Quicksilver Debuging Output


========= START PAYLOAD ===========
Array
(
    [wf_type] => clear_cache
    [user_id] => ed828d9d-2389-4e8d-9f71-bd2fcafc93c2
    [site_id] => 6c5ee454-9427-4cce-8193-a44d6c54172c
    [user_role] => owner
    [trace_id] => 1c4b90c0-a2db-11e5-9ca4-efb1318547fc
    [environment] => dev
    [wf_description] => Clear cache for "dev"
    [user_email] => josh@getpantheon.com
)

========== END PAYLOAD ============
```

The `wf_type`, `wf_description` and `user_email` values are likely to be of particular interest. You can get additional information from the `$_SERVER` and `$_ENV` superglobals. You can also interrogate the status of the git repository, as well as bootstrapping the CMS. There are lots of possibilities! Have fun with Quicksilver!
