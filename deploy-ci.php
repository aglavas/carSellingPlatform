<?php

namespace Deployer;

require 'recipe/laravel.php';

// Configuration

set('repository', 'https://'.getenv('COMPOSER_CREDENTIALS').'@git.emilfreydigital.hr/efdi/nova-carmarket-europe.git');
set('git_tty', false); // [Optional] Allocate tty for git on first deployment
set('bin/php', '/usr/bin/php74');
set('ssh_multiplexing', false);
add('shared_files', ['public/.htaccess']);
add('shared_dirs', []);
add('writable_dirs', []);
set('allow_anonymous_stats', false);
set('composer_options',
    '{{composer_action}} --verbose --prefer-dist --no-progress --no-interaction --optimize-autoloader');

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

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');

after('artisan:migrate', 'artisan:queue:restart');

task('artisan:optimize', function () {
});

task('authenticate_repository:nova.laravel.com', function () {
   run('cd {{release_path}} && {{bin/composer}} config http-basic.nova.laravel.com '.getenv('NOVA_USER').' '.getenv('NOVA_PASSWORD'));
});

before('deploy:vendors', 'authenticate_repository:nova.laravel.com');
