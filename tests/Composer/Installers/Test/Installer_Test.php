<?php

declare(strict_types=1);

namespace Composer\Installers\Test;

use Composer\Composer;
use Composer\Config;
use Composer\Installers\Installer;
use Composer\IO\IOInterface;
use Composer\Package\Package;
use Composer\Repository\InstalledRepositoryInterface;
use Composer\Util\Filesystem;
use PHPUnit\Framework\MockObject\MockObject;

class InstallerTest extends TestCase
{
    /** @var Composer */
    private $composer;
    /** @var Config */
    private $config;
    /** @var string */
    private $vendorDir;
    /** @var string */
    private $binDir;
    /** @var InstalledRepositoryInterface&MockObject */
    private $repository;
    /** @var IOInterface */
    private $io;
    /** @var Filesystem */
    private $fs;

    public function setUp(): void
    {
        $this->fs = new Filesystem();

        $this->composer = $this->getComposer();
        $this->config = $this->composer->getConfig();

        $this->vendorDir = realpath(sys_get_temp_dir()) . DIRECTORY_SEPARATOR . 'baton-test-vendor';
        $this->ensureDirectoryExistsAndClear($this->vendorDir);

        $this->binDir = realpath(sys_get_temp_dir()) . DIRECTORY_SEPARATOR . 'baton-test-bin';
        $this->ensureDirectoryExistsAndClear($this->binDir);

        $this->config->merge([
            'config' => [
                'vendor-dir' => $this->vendorDir,
                'bin-dir' => $this->binDir,
            ],
        ]);

        $this->repository = $this->getMockBuilder(InstalledRepositoryInterface::class)->getMock();
        $this->io = $this->getMockIO();
    }

    public function tearDown(): void
    {
        $this->fs->removeDirectory($this->vendorDir);
        $this->fs->removeDirectory($this->binDir);
    }

    /**
     * @dataProvider supportsProvider
     */
    public function testSupports(string $type, bool $expected): void
    {
        $installer = new Installer($this->io, $this->composer);
        $this->assertSame($expected, $installer->supports($type), sprintf('Failed to show support for %s', $type));
    }

    public function supportsProvider(): array
    {
        return [
            ['agl-module', true],
            ['akaunting-module', true],
            ['annotatecms-module', true],
            ['annotatecms-component', true],
            ['annotatecms-service', true],
            ['attogram-module', true],
            ['bitrix-module', true],
            ['bitrix-component', true],
            ['bitrix-theme', true],
            ['botble-plugin', true],
            ['botble-theme', true],
            ['bonefish-package', true],
            ['cakephp', false],
            ['cakephp-', false],
            ['cakephp-app', false],
            ['cakephp-plugin', true],
            ['chef-cookbook', true],
            ['chef-role', true],
            ['cockpit-module', true],
            ['codeigniter-app', false],
            ['codeigniter-library', true],
            ['codeigniter-third-party', true],
            ['codeigniter-module', true],
            ['concrete5-block', true],
            ['concrete5-package', true],
            ['concrete5-theme', true],
            ['concrete5-core', true],
            ['concrete5-update', true],
            ['concretecms-block', true],
            ['concretecms-package', true],
            ['concretecms-theme', true],
            ['concretecms-core', true],
            ['concretecms-update', true],
            ['croogo-plugin', true],
            ['croogo-theme', true],
            ['decibel-app', true],
            ['dframe-module', true],
            ['dokuwiki-plugin', true],
            ['dokuwiki-template', true],
            ['drupal-core', true],
            ['drupal-module', true],
            ['drupal-theme', true],
            ['drupal-library', true],
            ['drupal-profile', true],
            ['drupal-database-driver', true],
            ['drupal-drush', true],
            ['drupal-custom-theme', true],
            ['drupal-custom-module', true],
            ['drupal-custom-profile', true],
            ['dolibarr-module', true],
            ['ee3-theme', true],
            ['ee3-addon', true],
            ['ee2-theme', true],
            ['ee2-addon', true],
            ['elgg-plugin', true],
            ['eliasis-component', true],
            ['eliasis-module', true],
            ['eliasis-plugin', true],
            ['eliasis-template', true],
            ['ezplatform-assets', true],
            ['ezplatform-meta-assets', true],
            ['fuel-module', true],
            ['fuel-package', true],
            ['fuel-theme', true],
            ['fuelphp-component', true],
            ['hurad-plugin', true],
            ['hurad-theme', true],
            ['imagecms-template', true],
            ['imagecms-module', true],
            ['imagecms-library', true],
            ['itop-extension', true],
            ['kanboard-plugin', true],
            ['known-plugin', true],
            ['known-theme', true],
            ['known-console', true],
            ['kohana-module', true],
            ['lms-plugin', true],
            ['lms-template', true],
            ['lms-document-template', true],
            ['lms-userpanel-module', true],
            ['laravel-library', true],
            ['lavalite-theme', true],
            ['lavalite-package', true],
            ['lithium-library', true],
            ['magento-library', true],
            ['majima-plugin', true],
            ['mako-package', true],
            ['matomo-plugin', true],
            ['mantisbt-plugin', true],
            ['miaoxing-plugin', true],
            ['modx-extra', true],
            ['modxevo-snippet', true],
            ['modxevo-plugin', true],
            ['modxevo-module', true],
            ['modxevo-template', true],
            ['modxevo-lib', true],
            ['mediawiki-extension', true],
            ['mediawiki-skin', true],
            ['microweber-module', true],
            ['modulework-module', true],
            ['moodle-mod', true],
            ['october-module', true],
            ['october-plugin', true],
            ['quicksilver-script', true],
            ['quicksilver-module', true],
            ['piwik-plugin', true],
            ['pxcms-module', true],
            ['pxcms-theme', true],
            ['phpbb-extension', true],
            ['plentymarkets-plugin', true],
            ['ppi-module', true],
            ['prestashop-module', true],
            ['prestashop-theme', true],
            ['puppet-module', true],
            ['porto-container', true],
            ['processwire-module', true],
            ['quicksilver-script', true],
            ['quicksilver-module', true],
            ['radphp-bundle', true],
            ['redaxo-addon', true],
            ['redaxo-bestyle-plugin', true],
            ['redaxo5-addon', true],
            ['redaxo5-bestyle-plugin', true],
            ['reindex-theme', true],
            ['reindex-plugin', true],
            ['roundcube-plugin', true],
            ['shopware-backend-plugin', true],
            ['shopware-core-plugin', true],
            ['shopware-frontend-plugin', true],
            ['shopware-theme', true],
            ['shopware-plugin', true],
            ['shopware-frontend-theme', true],
            ['silverstripe-module', true],
            ['silverstripe-theme', true],
            ['smf-module', true],
            ['smf-theme', true],
            ['starbug-module', true],
            ['starbug-theme', true],
            ['starbug-custom-module', true],
            ['starbug-custom-theme', true],
            ['sydes-module', true],
            ['sydes-theme', true],
            ['sylius-theme', true],
            ['tastyigniter-extension', true],
            ['tastyigniter-theme', true],
            ['thelia-module', true],
            ['thelia-frontoffice-template', true],
            ['thelia-backoffice-template', true],
            ['thelia-email-template', true],
            ['tusk-task', true],
            ['tusk-asset', true],
            ['userfrosting-sprinkle', true],
            ['vanilla-plugin', true],
            ['vanilla-theme', true],
            ['whmcs-addons', true],
            ['whmcs-fraud', true],
            ['whmcs-gateways', true],
            ['whmcs-notifications', true],
            ['whmcs-registrars', true],
            ['whmcs-reports', true],
            ['whmcs-security', true],
            ['whmcs-servers', true],
            ['whmcs-social', true],
            ['whmcs-support', true],
            ['whmcs-templates', true],
            ['whmcs-includes', true],
            ['wolfcms-plugin', true],
            ['wordpress-plugin', true],
            ['wordpress-core', false],
            ['yawik-module', true],
            ['zend-library', true],
            ['zikula-module', true],
            ['zikula-theme', true],
            ['kodicms-plugin', true],
            ['kodicms-media', true],
            ['phifty-bundle', true],
            ['phifty-library', true],
            ['phifty-framework', true],
            ['osclass-plugin', true],
            ['osclass-theme', true],
            ['osclass-language', true],
        ];
    }

    /**
     * @dataProvider installPathProvider
     */
    public function testInstallPath(string $type, string $path, string $name, string $version = '1.0.0'): void
    {
        $installer = new Installer($this->io, $this->composer);
        $package = new Package($name, $version, $version);

        $package->setType($type);
        $result = $installer->getInstallPath($package);
        $this->assertEquals(getcwd() . '/' . $path, $result);
    }

    public function installPathProvider(): array
    {
        return [
            ['agl-module', 'More/MyTestPackage/', 'agl/my_test-package'],
            ['akaunting-module', 'modules/MyPackage', 'shama/MyPackage'],
            ['annotatecms-module', 'addons/modules/my_module/', 'vysinsky/my_module'],
            ['annotatecms-component', 'addons/components/my_component/', 'vysinsky/my_component'],
            ['annotatecms-service', 'addons/services/my_service/', 'vysinsky/my_service'],
            ['attogram-module', 'modules/my_module/', 'author/my_module'],
            ['bitrix-module', 'bitrix/modules/my_module/', 'author/my_module'],
            ['bitrix-component', 'bitrix/components/my_component/', 'author/my_component'],
            ['bitrix-theme', 'bitrix/templates/my_theme/', 'author/my_theme'],
            ['bitrix-d7-module', 'bitrix/modules/author.my_module/', 'author/my_module'],
            ['bitrix-d7-component', 'bitrix/components/author/my_component/', 'author/my_component'],
            ['bitrix-d7-template', 'bitrix/templates/author_my_template/', 'author/my_template'],
            ['botble-plugin', 'platform/plugins/my_plugin/', 'author/my_plugin'],
            ['botble-theme', 'platform/themes/my_theme/', 'author/my_theme'],
            ['bonefish-package', 'Packages/bonefish/package/', 'bonefish/package'],
            ['cakephp-plugin', 'Plugin/Ftp/', 'shama/ftp'],
            ['chef-cookbook', 'Chef/mre/my_cookbook/', 'mre/my_cookbook'],
            ['chef-role', 'Chef/roles/my_role/', 'mre/my_role'],
            ['cockpit-module', 'cockpit/modules/addons/My_module/', 'piotr-cz/cockpit-my_module'],
            ['codeigniter-library', 'application/libraries/my_package/', 'shama/my_package'],
            ['codeigniter-module', 'application/modules/my_package/', 'shama/my_package'],
            ['concrete5-block', 'application/blocks/concrete5_block/', 'remo/concrete5_block'],
            ['concrete5-package', 'packages/concrete5_package/', 'remo/concrete5_package'],
            ['concrete5-theme', 'application/themes/concrete5_theme/', 'remo/concrete5_theme'],
            ['concrete5-core', 'concrete/', 'concrete5/core'],
            ['concrete5-update', 'updates/concrete5/', 'concrete5/concrete5'],
            ['concretecms-block', 'application/blocks/concretecms_block/', 'remo/concretecms_block'],
            ['concretecms-package', 'packages/concretecms_package/', 'remo/concretecms_package'],
            ['concretecms-theme', 'application/themes/concretecms_theme/', 'remo/concretecms_theme'],
            ['concretecms-core', 'concrete/', 'concretecms/core'],
            ['concretecms-update', 'updates/concretecms/', 'concretecms/concretecms'],
            ['croogo-plugin', 'Plugin/Sitemaps/', 'fahad19/sitemaps'],
            ['croogo-theme', 'View/Themed/Readable/', 'rchavik/readable'],
            ['decibel-app', 'app/someapp/', 'author/someapp'],
            ['dframe-module', 'modules/author/mymodule/', 'author/mymodule'],
            ['dokuwiki-plugin', 'lib/plugins/someplugin/', 'author/someplugin'],
            ['dokuwiki-template', 'lib/tpl/sometemplate/', 'author/sometemplate'],
            ['dolibarr-module', 'htdocs/custom/my_module/', 'shama/my_module'],
            ['drupal-core', 'core/', 'drupal/core'],
            ['drupal-module', 'modules/my_module/', 'shama/my_module'],
            ['drupal-theme', 'themes/my_theme/', 'shama/my_theme'],
            ['drupal-library', 'libraries/my_library/', 'shama/my_library'],
            ['drupal-profile', 'profiles/my_profile/', 'shama/my_profile'],
            ['drupal-database-driver', 'drivers/lib/Drupal/Driver/Database/my_driver/', 'shama/my_driver'],
            ['drupal-drush', 'drush/my_command/', 'shama/my_command'],
            ['drupal-custom-theme', 'themes/custom/my_theme/', 'shama/my_theme'],
            ['drupal-custom-module', 'modules/custom/my_module/', 'shama/my_module'],
            ['drupal-custom-profile', 'profiles/custom/my_profile/', 'shama/my_profile'],
            ['elgg-plugin', 'mod/sample_plugin/', 'test/sample_plugin'],
            ['eliasis-component', 'components/my_component/', 'shama/my_component'],
            ['eliasis-module', 'modules/my_module/', 'shama/my_module'],
            ['eliasis-plugin', 'plugins/my_plugin/', 'shama/my_plugin'],
            ['eliasis-template', 'templates/my_template/', 'shama/my_template'],
            ['ee3-addon', 'system/user/addons/ee_theme/', 'author/ee_theme'],
            ['ee3-theme', 'themes/user/ee_package/', 'author/ee_package'],
            ['ee2-addon', 'system/expressionengine/third_party/ee_theme/', 'author/ee_theme'],
            ['ee2-theme', 'themes/third_party/ee_package/', 'author/ee_package'],
            ['ezplatform-assets', 'web/assets/ezplatform/ezplatform_comp/', 'author/ezplatform_comp'],
            ['ezplatform-meta-assets', 'web/assets/ezplatform/', 'author/ezplatform_comp'],
            ['fuel-module', 'fuel/app/modules/module/', 'fuel/module'],
            ['fuel-package', 'fuel/packages/orm/', 'fuel/orm'],
            ['fuel-theme', 'fuel/app/themes/theme/', 'fuel/theme'],
            ['fuelphp-component', 'components/demo/', 'fuelphp/demo'],
            ['hurad-plugin', 'plugins/Akismet/', 'atkrad/akismet'],
            ['hurad-theme', 'plugins/Hurad2013/', 'atkrad/Hurad2013'],
            ['imagecms-template', 'templates/my_template/', 'shama/my_template'],
            ['imagecms-module', 'application/modules/my_module/', 'shama/my_module'],
            ['imagecms-library', 'application/libraries/my_library/', 'shama/my_library'],
            ['itop-extension', 'extensions/my_extension/', 'shama/my_extension'],
            ['kanboard-plugin', 'plugins/my_plugin/', 'shama/my_plugin'],
            ['known-plugin', 'IdnoPlugins/SamplePlugin/', 'known/SamplePlugin'],
            ['known-theme', 'Themes/SampleTheme/', 'known/SampleTheme'],
            ['known-console', 'ConsolePlugins/SampleConsolePlugin/', 'known/SampleConsolePlugin'],
            ['kohana-module', 'modules/my_package/', 'shama/my_package'],
            ['lms-plugin', 'plugins/MyPackage/', 'shama/MyPackage'],
            ['lms-plugin', 'plugins/MyPackage/', 'shama/my_package'],
            ['lms-template', 'templates/MyPackage/', 'shama/MyPackage'],
            ['lms-template', 'templates/MyPackage/', 'shama/my_package'],
            ['lms-document-template', 'documents/templates/MyPackage/', 'shama/MyPackage'],
            ['lms-document-template', 'documents/templates/MyPackage/', 'shama/my_package'],
            ['lms-userpanel-module', 'userpanel/modules/MyPackage/', 'shama/MyPackage'],
            ['lms-userpanel-module', 'userpanel/modules/MyPackage/', 'shama/my_package'],
            ['laravel-library', 'libraries/my_package/', 'shama/my_package'],
            ['lavalite-theme', 'public/themes/my_theme/', 'shama/my_theme'],
            ['lavalite-package', 'packages/my_group/my_package/', 'my_group/my_package'],
            ['lithium-library', 'libraries/li3_test/', 'user/li3_test'],
            ['magento-library', 'lib/foo/', 'test/foo'],
            ['majima-plugin', 'plugins/MyPlugin/', 'shama/my-plugin'],
            ['modx-extra', 'core/packages/extra/', 'vendor/extra'],
            ['modxevo-snippet', 'assets/snippets/my_snippet/', 'shama/my_snippet'],
            ['modxevo-plugin', 'assets/plugins/my_plugin/', 'shama/my_plugin'],
            ['modxevo-module', 'assets/modules/my_module/', 'shama/my_module'],
            ['modxevo-template', 'assets/templates/my_template/', 'shama/my_template'],
            ['modxevo-lib', 'assets/lib/my_lib/', 'shama/my_lib'],
            ['mako-package', 'app/packages/my_package/', 'shama/my_package'],
            ['mantisbt-plugin', 'plugins/MyPlugin/', 'shama/my_plugin'],
            ['matomo-plugin', 'plugins/VisitSummary/', 'shama/visit-summary'],
            ['mediawiki-extension', 'extensions/APC/', 'author/APC'],
            ['mediawiki-extension', 'extensions/APC/', 'author/APC-extension'],
            ['mediawiki-extension', 'extensions/UploadWizard/', 'author/upload-wizard'],
            ['mediawiki-extension', 'extensions/SyntaxHighlight_GeSHi/', 'author/syntax-highlight_GeSHi'],
            ['mediawiki-skin', 'skins/someskin/', 'author/someskin-skin'],
            ['mediawiki-skin', 'skins/someskin/', 'author/someskin'],
            ['miaoxing-plugin', 'plugins/plugin/', 'shama/plugin'],
            ['miaoxing-plugin', 'plugins/my-plugin/', 'shama/my-plugin'],
            ['miaoxing-plugin', 'plugins/MyPlugin/', 'shama/MyPlugin'],
            ['miaoxing-plugin', 'plugins/my_plugin/', 'shama/my_plugin'],
            ['microweber-module', 'userfiles/modules/my-thing/', 'author/my-thing-module'],
            ['modulework-module', 'modules/my_package/', 'shama/my_package'],
            ['moodle-mod', 'mod/my_package/', 'shama/my_package'],
            ['october-module', 'modules/my_plugin/', 'shama/my_plugin'],
            ['october-plugin', 'plugins/shama/my_plugin/', 'shama/my_plugin'],
            ['october-theme', 'themes/shama-my_theme/', 'shama/my_theme'],
            ['piwik-plugin', 'plugins/VisitSummary/', 'shama/visit-summary'],
            ['prestashop-module', 'modules/a-module/', 'vendor/a-module'],
            ['prestashop-theme', 'themes/a-theme/', 'vendor/a-theme'],
            ['pxcms-module', 'app/Modules/Foo/', 'vendor/module-foo'],
            ['pxcms-module', 'app/Modules/Foo/', 'vendor/pxcms-foo'],
            ['pxcms-theme', 'themes/Foo/', 'vendor/theme-foo'],
            ['pxcms-theme', 'themes/Foo/', 'vendor/pxcms-foo'],
            ['phpbb-extension', 'ext/test/foo/', 'test/foo'],
            ['phpbb-style', 'styles/foo/', 'test/foo'],
            ['phpbb-language', 'language/foo/', 'test/foo'],
            ['plentymarkets-plugin', 'HelloWorld/', 'plugin-hello-world'],
            ['ppi-module', 'modules/foo/', 'test/foo'],
            ['puppet-module', 'modules/puppet-name/', 'puppet/puppet-name'],
            ['porto-container', 'app/Containers/container-name/', 'test/container-name'],
            ['radphp-bundle', 'src/Migration/', 'atkrad/migration'],
            ['processwire-module', 'site/modules/HelloWorld/', 'test/hello-world'],
            ['quicksilver-script', 'web/private/scripts/quicksilver/quicksilver-script', 'shama/quicksilver-script'],
            ['quicksilver-module', 'web/private/scripts/quicksilver/quicksilver-module', 'shama/quicksilver-module'],
            ['redaxo-addon', 'redaxo/include/addons/my_plugin/', 'shama/my_plugin'],
            ['redaxo-bestyle-plugin', 'redaxo/include/addons/be_style/plugins/my_plugin/', 'shama/my_plugin'],
            ['redaxo5-addon', 'redaxo/src/addons/my_plugin/', 'shama/my_plugin'],
            ['redaxo5-bestyle-plugin', 'redaxo/src/addons/be_style/plugins/my_plugin/', 'shama/my_plugin'],
            ['reindex-theme', 'themes/my_module/', 'author/my_module'],
            ['reindex-plugin', 'plugins/my_module/', 'author/my_module'],
            ['roundcube-plugin', 'plugins/base/', 'test/base'],
            ['roundcube-plugin', 'plugins/replace_dash/', 'test/replace-dash'],
            ['shopware-backend-plugin', 'engine/Shopware/Plugins/Local/Backend/ShamaMyBackendPlugin/', 'shama/my-backend-plugin'],
            ['shopware-core-plugin', 'engine/Shopware/Plugins/Local/Core/ShamaMyCorePlugin/', 'shama/my-core-plugin'],
            ['shopware-frontend-plugin', 'engine/Shopware/Plugins/Local/Frontend/ShamaMyFrontendPlugin/', 'shama/my-frontend-plugin'],
            ['shopware-theme', 'templates/my_theme/', 'shama/my-theme'],
            ['shopware-frontend-theme', 'themes/Frontend/ShamaMyFrontendTheme/', 'shama/my-frontend-theme'],
            ['shopware-plugin', 'custom/plugins/ShamaMyPlugin/', 'shama/my-plugin'],
            ['silverstripe-module', 'my_module/', 'shama/my_module'],
            ['silverstripe-module', 'sapphire/', 'silverstripe/framework', '2.4.0'],
            ['silverstripe-module', 'framework/', 'silverstripe/framework', '3.0.0'],
            ['silverstripe-module', 'framework/', 'silverstripe/framework', '3.0.0-rc1'],
            ['silverstripe-module', 'framework/', 'silverstripe/framework', 'my/branch'],
            ['silverstripe-theme', 'themes/my_theme/', 'shama/my_theme'],
            ['smf-module', 'Sources/my_module/', 'shama/my_module'],
            ['smf-theme', 'Themes/my_theme/', 'shama/my_theme'],
            ['starbug-module', 'modules/my_module/', 'shama/my_module'],
            ['starbug-theme', 'themes/my_theme/', 'shama/my_theme'],
            ['starbug-custom-module', 'app/modules/my_module/', 'shama/my_module'],
            ['starbug-custom-theme', 'app/themes/my_theme/', 'shama/my_theme'],
            ['sylius-theme', 'themes/my_theme/', 'shama/my_theme'],
            ['tastyigniter-extension', 'extensions/shama/my_extension/', 'shama/my_extension'],
            ['tastyigniter-theme', 'themes/my_theme/', 'shama/my_theme'],
            ['thelia-module', 'local/modules/my_module/', 'shama/my_module'],
            ['thelia-frontoffice-template', 'templates/frontOffice/my_template_fo/', 'shama/my_template_fo'],
            ['thelia-backoffice-template', 'templates/backOffice/my_template_bo/', 'shama/my_template_bo'],
            ['thelia-email-template', 'templates/email/my_template_email/', 'shama/my_template_email'],
            ['tusk-task', '.tusk/tasks/my_task/', 'shama/my_task'],
            ['userfrosting-sprinkle', 'app/sprinkles/my_sprinkle/', 'shama/my_sprinkle'],
            ['vanilla-plugin', 'plugins/my_plugin/', 'shama/my_plugin'],
            ['vanilla-theme', 'themes/my_theme/', 'shama/my_theme'],
            ['whmcs-addons', 'modules/addons/vendor_addon_name/', 'vendor/addon_name'],
            ['whmcs-fraud', 'modules/fraud/vendor_fraud_name/', 'vendor/fraud_name'],
            ['whmcs-gateways', 'modules/gateways/vendor_gateway_name/', 'vendor/gateway_name'],
            ['whmcs-notifications', 'modules/notifications/vendor_notification_name/', 'vendor/notification_name'],
            ['whmcs-registrars', 'modules/registrars/vendor_registrar_name/', 'vendor/registrar_name'],
            ['whmcs-reports', 'modules/reports/vendor_report_name/', 'vendor/report_name'],
            ['whmcs-security', 'modules/security/vendor_security_name/', 'vendor/security_name'],
            ['whmcs-servers', 'modules/servers/vendor_server_name/', 'vendor/server_name'],
            ['whmcs-social', 'modules/social/vendor_social_name/', 'vendor/social_name'],
            ['whmcs-support', 'modules/support/vendor_support_name/', 'vendor/support_name'],
            ['whmcs-templates', 'templates/vendor_template_name/', 'vendor/template_name'],
            ['whmcs-includes', 'includes/vendor_include_name/', 'vendor/include_name'],
            ['wolfcms-plugin', 'wolf/plugins/my_plugin/', 'shama/my_plugin'],
            ['wordpress-plugin', 'wp-content/plugins/my_plugin/', 'shama/my_plugin'],
            ['wordpress-muplugin', 'wp-content/mu-plugins/my_plugin/', 'shama/my_plugin'],
            ['zend-extra', 'extras/library/zend_test/', 'shama/zend_test'],
            ['zikula-module', 'modules/my-test_module/', 'my/test_module'],
            ['zikula-theme', 'themes/my-test_theme/', 'my/test_theme'],
            ['kodicms-media', 'cms/media/vendor/my_media/', 'shama/my_media'],
            ['kodicms-plugin', 'cms/plugins/my_plugin/', 'shama/my_plugin'],
            ['phifty-bundle', 'bundles/core/', 'shama/core'],
            ['phifty-library', 'libraries/my-lib/', 'shama/my-lib'],
            ['phifty-framework', 'frameworks/my-framework/', 'shama/my-framework'],
            ['yawik-module', 'module/MyModule/', 'shama/my_module'],
            ['osclass-plugin', 'oc-content/plugins/sample_plugin/', 'test/sample_plugin'],
            ['osclass-theme', 'oc-content/themes/sample_theme/', 'test/sample_theme'],
            ['osclass-language', 'oc-content/languages/sample_lang/', 'test/sample_lang'],
        ];
    }

    public function testGetCakePHPInstallPathException(): void
    {
        $this->expectException('InvalidArgumentException');
        $installer = new Installer($this->io, $this->composer);
        $package = new Package('shama/ftp', '1.0.0', '1.0.0');

        $package->setType('cakephp-whoops');
        $result = $installer->getInstallPath($package);
    }

    public function testCustomInstallPath(): void
    {
        $installer = new Installer($this->io, $this->composer);
        $package = new Package('shama/ftp', '1.0.0', '1.0.0');
        $package->setType('cakephp-plugin');
        $this->composer->getPackage()->setExtra([
            'installer-paths' => [
                'my/custom/path/{$name}/' => [
                    'shama/ftp',
                    'foo/bar',
                ],
            ],
        ]);
        $result = $installer->getInstallPath($package);
        $this->assertEquals(getcwd() . '/my/custom/path/Ftp/', $result);
    }

    public function testCustomInstallerName(): void
    {
        $installer = new Installer($this->io, $this->composer);
        $package = new Package('shama/cakephp-ftp-plugin', '1.0.0', '1.0.0');
        $package->setType('cakephp-plugin');
        $package->setExtra([
            'installer-name' => 'FTP',
        ]);
        $result = $installer->getInstallPath($package);
        $this->assertEquals(getcwd() . '/Plugin/FTP/', $result);
    }

    public function testCustomTypePath(): void
    {
        $installer = new Installer($this->io, $this->composer);
        $package = new Package('slbmeh/my_plugin', '1.0.0', '1.0.0');
        $package->setType('wordpress-plugin');
        $this->composer->getPackage()->setExtra([
            'installer-paths' => [
                'my/custom/path/{$name}/' => [
                    'type:wordpress-plugin',
                ],
            ],
        ]);
        $result = $installer->getInstallPath($package);
        $this->assertEquals(getcwd() . '/my/custom/path/my_plugin/', $result);
    }

    public function testVendorPath(): void
    {
        $installer = new Installer($this->io, $this->composer);
        $package = new Package('penyaskito/my_module', '1.0.0', '1.0.0');
        $package->setType('drupal-module');
        $this->composer->getPackage()->setExtra([
          'installer-paths' => [
            'modules/custom/{$name}/' => [
              'vendor:penyaskito',
            ],
          ],
        ]);
        $result = $installer->getInstallPath($package);
        $this->assertEquals(getcwd() . '/modules/custom/my_module/', $result);
    }

    public function testStringPath(): void
    {
        $installer = new Installer($this->io, $this->composer);
        $package = new Package('penyaskito/my_module', '1.0.0', '1.0.0');
        $package->setType('drupal-module');
        $this->composer->getPackage()->setExtra([
          'installer-paths' => [
            'modules/custom/{$name}/' => 'vendor:penyaskito',
          ],
        ]);
        $result = $installer->getInstallPath($package);
        $this->assertEquals(getcwd() . '/modules/custom/my_module/', $result);
    }

    public function testNoVendorName(): void
    {
        $installer = new Installer($this->io, $this->composer);
        $package = new Package('vanillaPlugin', '1.0.0', '1.0.0');

        $package->setType('vanilla-plugin');
        $result = $installer->getInstallPath($package);
        $this->assertEquals(getcwd() . '/plugins/vanillaPlugin/', $result);
    }

    public function testUninstallAndDeletePackageFromLocalRepo(): void
    {
        $package = new Package('foo', '1.0.0', '1.0.0');

        $installer = $this->getMockBuilder(Installer::class)
            ->setMethods(['getInstallPath', 'removeCode'])
            ->setConstructorArgs([$this->io, $this->composer])
            ->getMock();
        $installer->expects($this->atLeastOnce())->method('getInstallPath')->with($package)->will($this->returnValue(sys_get_temp_dir().'/foo'));
        $installer->expects($this->atLeastOnce())->method('removeCode')->with($package)->will($this->returnValue(null));

        $repo = $this->repository;
        $repo->expects($this->once())->method('hasPackage')->with($package)->will($this->returnValue(true));
        $repo->expects($this->once())->method('removePackage')->with($package);

        $installer->uninstall($repo, $package);
    }

    /**
     * @dataProvider disabledInstallersProvider
     * @param mixed $disabled
     */
    public function testDisabledInstallers($disabled, string $type, bool $expected): void
    {
        $this->composer->getPackage()->setExtra([
            'installer-disable' => $disabled,
        ]);
        $this->testSupports($type, $expected);
    }

    public function disabledInstallersProvider(): array
    {
        return [
            [false, 'drupal-module', true],
            [true, 'drupal-module', false],
            ['true', 'drupal-module', true],
            ['all', 'drupal-module', false],
            ['*', 'drupal-module', false],
            ['cakephp', 'drupal-module', true],
            ['drupal', 'cakephp-plugin', true],
            ['cakephp', 'cakephp-plugin', false],
            ['drupal', 'drupal-module', false],
            [['drupal', 'cakephp'], 'cakephp-plugin', false],
            [['drupal', 'cakephp'], 'drupal-module', false],
            [['cakephp', true], 'drupal-module', false],
            [['cakephp', 'all'], 'drupal-module', false],
            [['cakephp', '*'], 'drupal-module', false],
            [['cakephp', 'true'], 'drupal-module', true],
            [['drupal', 'true'], 'cakephp-plugin', true],
        ];
    }
}
