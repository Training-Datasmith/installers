# Architecture: installers

## Purpose
A Composer plugin that provides custom package installer paths for 50+ PHP frameworks and CMSs. When a Composer package declares a supported `type` (e.g., `wordpress-plugin`, `drupal-module`), this plugin installs it into the framework-specific directory instead of `vendor/`.

## Directory Structure
```
src/
  Composer/Installers/
    Installer.php          # Main installer — dispatches to per-framework installer classes
    Base_Installer.php     # Shared path-resolution logic for all framework installers
    Plugin.php             # Composer plugin entry point — registers the custom installer
    bootstrap.php          # Autoloader bootstrap
    # ~90 framework-specific installer classes:
    Wordpress_Installer.php
    Drupal_Installer.php
    Laravel_Installer.php
    Cake_PHP_Installer.php
    Magento_Installer.php
    Symfony_Installer.php
    ... (one per supported CMS/framework)
tests/
  Composer/Installers/Test/
    Installer_Test.php     # Tests for the core installer dispatch logic
    *_Installer_Test.php   # Per-framework path resolution tests
```

## Key Design Decisions
- **Composer plugin architecture** — `Plugin.php` implements `Composer\Plugin\PluginInterface` and registers `Installer` as a custom installer for all package types it handles.
- **Type-based dispatch** — `Installer::getInstallPath()` uses the package's `type` metadata to select the correct framework-specific installer class.
- **`extra.installer-paths` override** — callers can override the default install path in `composer.json` via `extra.installer-paths`, giving consumers full control.
- **`Base_Installer` template method** — each framework installer defines only a `$locations` map; path variable substitution is handled in `Base_Installer`.

## Extension Points
- Add a new framework by creating a `{Framework}_Installer.php` class extending `Base_Installer` with a `$locations` array.
- Override install paths project-by-project via `extra.installer-paths` in `composer.json`.

## Dependency Flow
```
Composer (package install)
  └─ Plugin::activate()
       └─ Composer\Installer\InstallationManager::addInstaller(Installer)
            └─ Installer::getInstallPath($package)
                 ├─ detect package type
                 ├─ select Framework_Installer
                 └─ Base_Installer::getInstallPath() → resolved filesystem path
```
