# Changelog
All notable changes to this project will be documented in this file, formatted via [this recommendation](https://keepachangelog.com/).

## [1.7.0] - 2022-08-30
### Added
- New filter to set a time before the Form Abandonment email is sent.

### Changed
- Minimum WPForms version supported is 1.7.5.5.
- Check GDPR settings before trying to use a cookie.

### Fixed
- Abandoned Entries were saved while ignoring the "Save Only If Email Address" setting.
- Compatibility with WordPress Multisite installations.
- Email notifications were being sent for both abandoned and completed forms instead of only one.

## [1.6.0] - 2022-03-16 
### Added
- Compatibility with WPForms 1.6.8 and the updated Form Builder.
- New JavaScript event `wpformsFormAbandonmentDataSent` triggered when successfully sending the abandoned data to be saved.
- Compatibility with WPForms 1.7.3 and its search functionality on the Entries page.

### Changed
- Minimum WPForms version supported is 1.7.3.
- Do not store Abandoned Entries and do not send related notifications when Entry storage is disabled.

### Fixed
- Some smart tags are not rendered correctly in the abandonment notifications.
- Abandoned Entries were not saved when a user clicks on any internal link inside the Firefox browser.

## [1.5.0] - 2021-03-31
### Added
- Notification's "Enable for abandoned forms entries" option compatibility improvements with payment addons adding own rules whether to send a notification email.

### Changed
- Replaced `jQuery.ready()` function with recommended way since jQuery 3.0.

## [1.4.4] - 2020-12-17
### Fixed
- Form abandonment via external links not always detected on some mobile devices.

## [1.4.3] - 2020-08-05
### Changed
- Password field values are no longer stored by default, can be enabled with `wpforms_process_save_password_form_abandonment` filter.

### Fixed
- Abandoned entries are counting towards entry limits defined via Form Locker addon settings.
- Prevent abandoned entry duplicates creation when 2 AJAX-based forms are present on the same page and only one of them was submitted.

## [1.4.2] - 2020-06-10
### Fixed
- Entry must have the "completed" type after its creation through non-ajax form.

## [1.4.1] - 2020-04-30
### Fixed
- Prevent 'Abandoned' (duplicate) entry on successful form submit.

## [1.4.0] - 2020-01-15
### Added
- Access Controls compatibility (WPForms 1.5.8).

## [1.3.0] - 2020-01-09s
### Added
- Tracking closing of the window or tab by listening to the `beforeunload` event.

### Changed
- Do not send duplicate abandonment notifications if 'no duplicates' option is enabled.

## [1.2.0] - 2019-07-23
### Added
- Complete translations for French and Portuguese (Brazilian).

### Fixed
- Form abandonment records only last checkbox field selection.
- "Prevent duplicate abandoned entries" saves duplicate entries.

## [1.1.0] - 2019-02-06
### Added
- Complete translations for Spanish, Italian, Japanese, and German.

### Fixed
- Typos, grammar, and other i18n related issues.

## [1.0.2] - 2018-02-12
### Fixed
- Conflict with email notifications configured with conditional logic causing notifications to send when they should not.

## [1.0.1] - 2017-02-01
### Fixed
- Incorrect version in updater which caused WordPress to think an update was available.

## [1.0.0] - 2017-02-01
### Added
- Initial release.
