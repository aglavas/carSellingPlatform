<?php

namespace Deployer;

require 'recipe/laravel.php';

// Configuration
set('repository', 'https://git.emilfreydigital.hr/efdi/nova-carmarket-europe.git');
set('git_tty', true); // [Optional] Allocate tty for git on first deployment
set('bin/php', '/usr/bin/php74');
add('shared_files', ['public/.htaccess']);
set('allow_anonymous_stats', false);
set('composer_options', '{{composer_action}} --verbose --prefer-dist --no-progress --no-interaction --optimize-autoloader');

// Hosts

host('production')
    ->hostname('dedi2340.your-server.de')
    ->user('emilcarm')
    ->stage('production')
    ->set('branch', 'master')
    ->port(222)
    ->set('http_user', 'emilcarm')
    ->set('deploy_path', '~/public_html');

host('stage')
    ->hostname('dedi1754.your-server.de')
    ->user('stageq')
    ->set('branch', 'stage')
    ->stage('stage')
    ->port(222)
    ->set('http_user', 'stageq')
    ->set('deploy_path', '~/public_html');


host('develop')
    ->hostname('dedi5836.your-server.de')
    ->user('vdvhdg')
    ->stage('develop')
    ->set('branch', 'develop')
    ->port(222)
    ->set('http_user', 'vdvhdg')
    ->set('deploy_path', '~/public_html');

require_once __DIR__ . '/vendor/betacoding/deploy/v6/laravel.multiple.stages.php';
