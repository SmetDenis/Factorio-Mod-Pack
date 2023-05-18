<?php

require_once __DIR__ . '/vendor/autoload.php';

define('MOD_BASICS', 'basics');
define('MOD_OPTIONAL', 'optional');
define('MOD_REQ', 'req');
define('MOD_NOT_RECOMMENDED', 'not-recommended');

function getActiveMods()
{
    $list = json_decode(file_get_contents(__DIR__ . '/mod-list.json'), true, 512, JSON_THROW_ON_ERROR);

    $exclude = [
        "flib",
        "smetdenis-mod-pack",
        "stdlib",
    ];

    $activeMods = [];
    foreach ($list['mods'] as $mod) {
        if ($mod['enabled'] && !in_array($mod['name'], $exclude, true)) {
            $activeMods[] = $mod['name'];
        }
    }
    return $activeMods;
}

$myMods = [
    // Basic dependencies
    'base'                                => MOD_BASICS,

    // Quality of Life & UI
    'EvoGUI'                              => MOD_REQ,
    'extended-descriptions'               => MOD_REQ,
    'far-reach'                           => MOD_REQ,
    'AutoDeconstruct'                     => MOD_REQ,
    'QuickbarTemplates'                   => MOD_REQ,
    'PickerDollies'                       => MOD_REQ,
    'Fill4Me'                             => MOD_REQ,
    'GhostInHand'                         => MOD_REQ,
    'logistics_requests_sorted'           => MOD_REQ,
    'UltimateResearchQueue'               => MOD_REQ,
    'Squeak Through'                      => MOD_REQ,
    'WhereIsMyBody'                       => MOD_REQ,
    'WireShortcuts'                       => MOD_REQ,
    'ModuleInserter'                      => MOD_OPTIONAL,
    'Enhanced_Map_Colors'                 => MOD_OPTIONAL,
    'some-zoom'                           => MOD_REQ,
    'zoom-out'                            => MOD_NOT_RECOMMENDED,
    'Shortcuts-ick'                       => MOD_OPTIONAL,

    // Analysis
    'assemblyanalyst'                     => MOD_REQ,
    'Bottleneck'                          => MOD_REQ,
    '? MaxRateCalculator'                 => MOD_REQ,
    'production-potential'                => MOD_REQ,
    'production-monitor'                  => MOD_NOT_RECOMMENDED,
    'RecipeBook'                          => MOD_REQ,
    'Fluid-level-indicator'               => MOD_REQ,
    'RateCalculator'                      => MOD_REQ,
    'factoryplanner'                      => MOD_REQ,
    'tiny-production-ui'                  => MOD_REQ,
    'YARM'                                => MOD_REQ,
    'what-is-it-really-used-for'          => MOD_OPTIONAL,
    'helmod'                              => MOD_NOT_RECOMMENDED,

    // Railways
    'automatic-station-painter-continued' => MOD_REQ,
    'Automatic_Train_Painter'             => MOD_REQ,
    'auto_manual_mode'                    => MOD_REQ,
    'FluidWagonColorMask'                 => MOD_REQ,
    'SchallRailwayController'             => MOD_REQ,

    // Railways - LTN
    'LogisticTrainNetwork'                => MOD_REQ,
    'LTN_Language_Pack'                   => MOD_REQ,
    'LtnManager'                          => MOD_REQ,
    'cybersyn'                            => MOD_OPTIONAL,

    // Sandbox
    'blueprint-sandboxes'                 => MOD_REQ,

    // Transport & Equipment
    'jetpack'                             => MOD_REQ,
    'Nanobots'                            => MOD_REQ,
    'VehicleSnap'                         => MOD_REQ,
    'MyQuickStart'                        => MOD_REQ,
    'Power Armor MK3'                     => MOD_OPTIONAL,

    // Other (Adding new mechanics and items)
    'AfraidOfTheDark'                     => MOD_OPTIONAL,
    'reverse-factory'                     => MOD_OPTIONAL,
    'Big_Brother'                         => MOD_OPTIONAL,
    'LightedPolesPlus'                    => MOD_OPTIONAL,
    'TaskList'                            => MOD_OPTIONAL,

    // Decorations (Just for fun)
    'textplates'                          => MOD_OPTIONAL,
    'Dectorio'                            => MOD_OPTIONAL,
    'EvenMoreTextPlates'                  => MOD_OPTIONAL,
    'SantasNixieTubeDisplay'              => MOD_OPTIONAL,
];

$diff = array_diff(getActiveMods(), array_keys($myMods));
if ($diff) {
    echo 'Difference with my mods: ' . implode(', ', $diff) . PHP_EOL;
} else {
    echo 'No difference with my mods' . PHP_EOL;
}

ksort($myMods, SORT_NATURAL);

$dependencies = [];
foreach ($myMods as $modName => $type) {
    if ($type === MOD_OPTIONAL) {
        $dependencies[] = '? ' . $modName;
    }

    if ($type === MOD_REQ) {
        $dependencies[] = $modName;
    }

    if ($type === MOD_NOT_RECOMMENDED) {
        $dependencies[] = '! ' . $modName;
    }
}

foreach ($myMods as $modName => $type) {
    if ($type === MOD_BASICS) {
        array_unshift($dependencies, $modName);
    }
}


$infoPath = __DIR__ . '/info.json';

$modPackInfo = json_decode(file_get_contents($infoPath), true, 512, JSON_THROW_ON_ERROR);
$modPackInfo['dependencies'] = $dependencies;
$modPackInfo = file_put_contents($infoPath, json_encode($modPackInfo, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT));
