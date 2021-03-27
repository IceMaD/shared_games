<?php

namespace Deployer;

require __DIR__.'/vendor/deployer/deployer/recipe/symfony4.php';
require __DIR__.'/vendor/deployer/recipes/recipe/yarn.php';

set('application', 'shared_games');
set('repository', 'git@github.com:IceMaD/shared_games.git');
set('git_tty', true);
set('current_path', './app');
add('shared_files', [
    '.env',
]);

host('scaleway-shared-user')
    ->configFile(getenv('HOME').'/.ssh/config')
    ->identityFile(getenv('HOME').'/.ssh/id_rsa')
    ->stage('production')
    ->set('writable_mode', 'chmod')
    ->set('deploy_path', '/var/www/shared_games');

task('yarn:build', function () {
    within('{{release_path}}', function () {
        run('yarn encore production --progress');
    });
});

before('deploy:vendors', 'deploy:copy_dirs');
after('deploy:vendors', 'yarn:install');
after('yarn:install', 'yarn:build');
before('deploy:symlink', 'database:migrate');

after('deploy:failed', 'deploy:unlock');
