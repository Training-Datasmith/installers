<?php

declare(strict_types=1);

namespace Composer\Installers;

class ExpressionEngineInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    private $ee2Locations = [
        'addon'   => 'system/expressionengine/third_party/{$name}/',
        'theme'   => 'themes/third_party/{$name}/',
    ];

    /** @var array<string, string> */
    private $ee3Locations = [
        'addon'   => 'system/user/addons/{$name}/',
        'theme'   => 'themes/user/{$name}/',
    ];

    public function getLocations(string $frameworkType): array
    {
        if ($frameworkType === 'ee2') {
            $this->locations = $this->ee2Locations;
        } else {
            $this->locations = $this->ee3Locations;
        }

        return $this->locations;
    }
}
