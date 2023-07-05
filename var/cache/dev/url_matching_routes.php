<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/_profiler' => [[['_route' => '_profiler_home', '_controller' => 'web_profiler.controller.profiler::homeAction'], null, null, null, true, false, null]],
        '/_profiler/search' => [[['_route' => '_profiler_search', '_controller' => 'web_profiler.controller.profiler::searchAction'], null, null, null, false, false, null]],
        '/_profiler/search_bar' => [[['_route' => '_profiler_search_bar', '_controller' => 'web_profiler.controller.profiler::searchBarAction'], null, null, null, false, false, null]],
        '/_profiler/phpinfo' => [[['_route' => '_profiler_phpinfo', '_controller' => 'web_profiler.controller.profiler::phpinfoAction'], null, null, null, false, false, null]],
        '/_profiler/xdebug' => [[['_route' => '_profiler_xdebug', '_controller' => 'web_profiler.controller.profiler::xdebugAction'], null, null, null, false, false, null]],
        '/_profiler/open' => [[['_route' => '_profiler_open_file', '_controller' => 'web_profiler.controller.profiler::openAction'], null, null, null, false, false, null]],
        '/country' => [[['_route' => 'app_country_index', '_controller' => 'App\\Controller\\Admin\\CountryController::index'], null, ['GET' => 0], null, true, false, null]],
        '/country/new' => [[['_route' => 'app_country_new', '_controller' => 'App\\Controller\\Admin\\CountryController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/' => [[['_route' => 'app_index', '_controller' => 'App\\Controller\\Admin\\HomeController::index'], null, ['GET' => 0], null, false, false, null]],
        '/league' => [[['_route' => 'app_league_index', '_controller' => 'App\\Controller\\Admin\\LeagueController::index'], null, ['GET' => 0], null, true, false, null]],
        '/league/new' => [[['_route' => 'app_league_new', '_controller' => 'App\\Controller\\Admin\\LeagueController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/login' => [[['_route' => 'app_login', '_controller' => 'App\\Controller\\Admin\\LoginController::index'], null, null, null, false, false, null]],
        '/sport' => [[['_route' => 'app_sport_index', '_controller' => 'App\\Controller\\Admin\\SportController::index'], null, ['GET' => 0], null, true, false, null]],
        '/sport/new' => [[['_route' => 'app_sport_new', '_controller' => 'App\\Controller\\Admin\\SportController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/standing' => [[['_route' => 'app_standing_index', '_controller' => 'App\\Controller\\Admin\\StandingController::index'], null, ['GET' => 0], null, true, false, null]],
        '/standing/new' => [[['_route' => 'app_standing_new', '_controller' => 'App\\Controller\\Admin\\StandingController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/team' => [[['_route' => 'app_team_index', '_controller' => 'App\\Controller\\Admin\\TeamController::index'], null, ['GET' => 0], null, true, false, null]],
        '/team/new' => [[['_route' => 'app_team_new', '_controller' => 'App\\Controller\\Admin\\TeamController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/logout' => [[['_route' => 'app_logout'], null, ['GET' => 0], null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_(?'
                    .'|error/(\\d+)(?:\\.([^/]++))?(*:38)'
                    .'|wdt/([^/]++)(*:57)'
                    .'|profiler/([^/]++)(?'
                        .'|/(?'
                            .'|search/results(*:102)'
                            .'|router(*:116)'
                            .'|exception(?'
                                .'|(*:136)'
                                .'|\\.css(*:149)'
                            .')'
                        .')'
                        .'|(*:159)'
                    .')'
                .')'
                .'|/country/([^/]++)(?'
                    .'|(*:189)'
                    .'|/edit(*:202)'
                    .'|(*:210)'
                .')'
                .'|/l(?'
                    .'|eague/([^/]++)(?'
                        .'|(*:241)'
                        .'|/edit(*:254)'
                        .'|(*:262)'
                    .')'
                    .'|ottery/(\\d{4}-\\d{2})(?'
                        .'|(*:294)'
                        .'|/launch(*:309)'
                    .')'
                .')'
                .'|/s(?'
                    .'|port/([^/]++)(?'
                        .'|(*:340)'
                        .'|/edit(*:353)'
                        .'|(*:361)'
                    .')'
                    .'|tanding/([^/]++)(?'
                        .'|(*:389)'
                        .'|/edit(*:402)'
                        .'|(*:410)'
                    .')'
                .')'
                .'|/team/(?'
                    .'|([^/]++)(?'
                        .'|(*:440)'
                        .'|/edit(*:453)'
                        .'|(*:461)'
                    .')'
                    .'|a(?'
                        .'|ll(*:476)'
                        .'|ctual(*:489)'
                    .')'
                    .'|name(*:502)'
                    .'|([^/]++)/players(*:526)'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        38 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        57 => [[['_route' => '_wdt', '_controller' => 'web_profiler.controller.profiler::toolbarAction'], ['token'], null, null, false, true, null]],
        102 => [[['_route' => '_profiler_search_results', '_controller' => 'web_profiler.controller.profiler::searchResultsAction'], ['token'], null, null, false, false, null]],
        116 => [[['_route' => '_profiler_router', '_controller' => 'web_profiler.controller.router::panelAction'], ['token'], null, null, false, false, null]],
        136 => [[['_route' => '_profiler_exception', '_controller' => 'web_profiler.controller.exception_panel::body'], ['token'], null, null, false, false, null]],
        149 => [[['_route' => '_profiler_exception_css', '_controller' => 'web_profiler.controller.exception_panel::stylesheet'], ['token'], null, null, false, false, null]],
        159 => [[['_route' => '_profiler', '_controller' => 'web_profiler.controller.profiler::panelAction'], ['token'], null, null, false, true, null]],
        189 => [[['_route' => 'app_country_show', '_controller' => 'App\\Controller\\Admin\\CountryController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        202 => [[['_route' => 'app_country_edit', '_controller' => 'App\\Controller\\Admin\\CountryController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        210 => [[['_route' => 'app_country_delete', '_controller' => 'App\\Controller\\Admin\\CountryController::delete'], ['id'], ['POST' => 0], null, false, true, null]],
        241 => [[['_route' => 'app_league_show', '_controller' => 'App\\Controller\\Admin\\LeagueController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        254 => [[['_route' => 'app_league_edit', '_controller' => 'App\\Controller\\Admin\\LeagueController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        262 => [[['_route' => 'app_league_delete', '_controller' => 'App\\Controller\\Admin\\LeagueController::delete'], ['id'], ['POST' => 0], null, false, true, null]],
        294 => [[['_route' => 'app_lottery', '_controller' => 'App\\Controller\\Api\\LotteryController::index'], ['year'], ['GET' => 0], null, false, true, null]],
        309 => [[['_route' => 'app_lottery_launch', '_controller' => 'App\\Controller\\Api\\LotteryController::launch'], ['year'], ['POST' => 0], null, false, false, null]],
        340 => [[['_route' => 'app_sport_show', '_controller' => 'App\\Controller\\Admin\\SportController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        353 => [[['_route' => 'app_sport_edit', '_controller' => 'App\\Controller\\Admin\\SportController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        361 => [[['_route' => 'app_sport_delete', '_controller' => 'App\\Controller\\Admin\\SportController::delete'], ['id'], ['POST' => 0], null, false, true, null]],
        389 => [[['_route' => 'app_standing_show', '_controller' => 'App\\Controller\\Admin\\StandingController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        402 => [[['_route' => 'app_standing_edit', '_controller' => 'App\\Controller\\Admin\\StandingController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        410 => [[['_route' => 'app_standing_delete', '_controller' => 'App\\Controller\\Admin\\StandingController::delete'], ['id'], ['POST' => 0], null, false, true, null]],
        440 => [[['_route' => 'app_team_show', '_controller' => 'App\\Controller\\Admin\\TeamController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        453 => [[['_route' => 'app_team_edit', '_controller' => 'App\\Controller\\Admin\\TeamController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        461 => [[['_route' => 'app_team_delete', '_controller' => 'App\\Controller\\Admin\\TeamController::delete'], ['id'], ['POST' => 0], null, false, true, null]],
        476 => [[['_route' => 'api_team_all', '_controller' => 'App\\Controller\\Api\\TeamController::allTeams'], [], ['GET' => 0], null, false, false, null]],
        489 => [[['_route' => 'api_team_all_current', '_controller' => 'App\\Controller\\Api\\TeamController::actualTeams'], [], ['GET' => 0], null, false, false, null]],
        502 => [[['_route' => 'api_team_name', '_controller' => 'App\\Controller\\Api\\TeamController::teamsByOrderedByName'], [], ['GET' => 0], null, false, false, null]],
        526 => [
            [['_route' => 'api_team_players', '_controller' => 'App\\Controller\\Api\\TeamController::allPlayersFromTeam'], ['id'], ['GET' => 0], null, false, false, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
