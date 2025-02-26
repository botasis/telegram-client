<?php
declare(strict_types=1);

use ShipMonk\ComposerDependencyAnalyser\Config\Configuration;
use ShipMonk\ComposerDependencyAnalyser\Config\ErrorType;

return (new Configuration())
    // TODO Remove in version 2
    ->ignoreErrorsOnPath(
        __DIR__ . '/src/Client/Exception/TelegramRequestException.php',
        [ErrorType::SHADOW_DEPENDENCY]
    );
