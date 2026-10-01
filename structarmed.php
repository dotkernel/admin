<?php

declare(strict_types=1);

use Boundwize\StructArmed\Architecture;
use Boundwize\StructArmed\Preset\Preset;

return Architecture::define()
    ->withPresets(Preset::PSR4(), Preset::CODEQUALITY())
    ->layer('CoreApp', 'src/Core/src/App/src', 'src/Core/src/App/src/Fixture')
    ->layer('CoreFixture', 'src/Core/src/App/src/Fixture')
    ->layer('CoreSetting', 'src/Core/src/Setting/src')
    ->layer('CoreAdmin', 'src/Core/src/Admin/src')
    ->layer('CoreSecurity', 'src/Core/src/Security/src')
    ->layer('CoreUser', 'src/Core/src/User/src')
    ->layer('App', 'src/App/src')
    ->layer('Admin', 'src/Admin/src')
    ->layer('Dashboard', 'src/Dashboard/src')
    ->layer('Page', 'src/Page/src')
    ->layer('Setting', 'src/Setting/src')
    ->layer('User', 'src/User/src')
    ->ruleset([
        'CoreApp'      => ['CoreUser'],
        'CoreSetting'  => ['+CoreApp', 'CoreAdmin'],
        'CoreAdmin'    => ['+CoreSetting'],
        'CoreSecurity' => ['+CoreAdmin'],
        'CoreUser'     => ['+CoreSecurity'],
        'CoreFixture'  => ['+CoreUser'],
        'App'          => ['+CoreUser'],
        'Admin'        => ['+App'],
        'Dashboard'    => ['+App'],
        'Page'         => ['+App'],
        'Setting'      => ['+Admin'],
        'User'         => ['+App'],
    ]);
