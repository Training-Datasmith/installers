<?php

declare (strict_types=1);
namespace Composer\Installers;

class Microweber_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['module' => 'userfiles/modules/{$install_item_dir}/', 'module-skin' => 'userfiles/modules/{$install_item_dir}/templates/', 'template' => 'userfiles/templates/{$install_item_dir}/', 'element' => 'userfiles/elements/{$install_item_dir}/', 'vendor' => 'vendor/{$install_item_dir}/', 'components' => 'components/{$install_item_dir}/'];
    /**
     * Format package name.
     *
     * For package type microweber-module, cut off a trailing '-module' if present
     *
     * For package type microweber-template, cut off a trailing '-template' if present.
     */
    public function inflect_package_vars(array $vars): array
    {
        if ($this->package->get_target_dir() !== null && $this->package->get_target_dir() !== '') {
            $vars['install_item_dir'] = $this->package->get_target_dir();
        } else {
            $vars['install_item_dir'] = $vars['name'];
            if ($vars['type'] === 'microweber-template') {
                return $this->inflect_template_vars($vars);
            }
            if ($vars['type'] === 'microweber-templates') {
                return $this->inflect_templates_vars($vars);
            }
            if ($vars['type'] === 'microweber-core') {
                return $this->inflect_core_vars($vars);
            }
            if ($vars['type'] === 'microweber-adapter') {
                return $this->inflect_core_vars($vars);
            }
            if ($vars['type'] === 'microweber-module') {
                return $this->inflect_module_vars($vars);
            }
            if ($vars['type'] === 'microweber-modules') {
                return $this->inflect_modules_vars($vars);
            }
            if ($vars['type'] === 'microweber-skin') {
                return $this->inflect_skin_vars($vars);
            }
            if ($vars['type'] === 'microweber-element' or $vars['type'] === 'microweber-elements') {
                return $this->inflect_element_vars($vars);
            }
        }
        return $vars;
    }
    /**
     * @param array<string, string> $vars
     * @return array<string, string>
     */
    protected function inflect_template_vars(array $vars): array
    {
        $vars['install_item_dir'] = $this->preg_replace('/-template$/', '', $vars['install_item_dir']);
        $vars['install_item_dir'] = $this->preg_replace('/template-$/', '', $vars['install_item_dir']);
        return $vars;
    }
    /**
     * @param array<string, string> $vars
     * @return array<string, string>
     */
    protected function inflect_templates_vars(array $vars): array
    {
        $vars['install_item_dir'] = $this->preg_replace('/-templates$/', '', $vars['install_item_dir']);
        $vars['install_item_dir'] = $this->preg_replace('/templates-$/', '', $vars['install_item_dir']);
        return $vars;
    }
    /**
     * @param array<string, string> $vars
     * @return array<string, string>
     */
    protected function inflect_core_vars(array $vars): array
    {
        $vars['install_item_dir'] = $this->preg_replace('/-providers$/', '', $vars['install_item_dir']);
        $vars['install_item_dir'] = $this->preg_replace('/-provider$/', '', $vars['install_item_dir']);
        $vars['install_item_dir'] = $this->preg_replace('/-adapter$/', '', $vars['install_item_dir']);
        return $vars;
    }
    /**
     * @param array<string, string> $vars
     * @return array<string, string>
     */
    protected function inflect_module_vars(array $vars): array
    {
        $vars['install_item_dir'] = $this->preg_replace('/-module$/', '', $vars['install_item_dir']);
        $vars['install_item_dir'] = $this->preg_replace('/module-$/', '', $vars['install_item_dir']);
        return $vars;
    }
    /**
     * @param array<string, string> $vars
     * @return array<string, string>
     */
    protected function inflect_modules_vars(array $vars): array
    {
        $vars['install_item_dir'] = $this->preg_replace('/-modules$/', '', $vars['install_item_dir']);
        $vars['install_item_dir'] = $this->preg_replace('/modules-$/', '', $vars['install_item_dir']);
        return $vars;
    }
    /**
     * @param array<string, string> $vars
     * @return array<string, string>
     */
    protected function inflect_skin_vars(array $vars): array
    {
        $vars['install_item_dir'] = $this->preg_replace('/-skin$/', '', $vars['install_item_dir']);
        $vars['install_item_dir'] = $this->preg_replace('/skin-$/', '', $vars['install_item_dir']);
        return $vars;
    }
    /**
     * @param array<string, string> $vars
     * @return array<string, string>
     */
    protected function inflect_element_vars(array $vars): array
    {
        $vars['install_item_dir'] = $this->preg_replace('/-elements$/', '', $vars['install_item_dir']);
        $vars['install_item_dir'] = $this->preg_replace('/elements-$/', '', $vars['install_item_dir']);
        $vars['install_item_dir'] = $this->preg_replace('/-element$/', '', $vars['install_item_dir']);
        $vars['install_item_dir'] = $this->preg_replace('/element-$/', '', $vars['install_item_dir']);
        return $vars;
    }
}