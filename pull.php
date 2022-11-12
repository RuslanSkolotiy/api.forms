<?php
function command($command, $title = false)
{
    echo "<pre>";
    echo "<b>" . ($title ?: $command) . "</b>" . PHP_EOL;
    system($command . ' 2>&1');
    echo PHP_EOL;
    echo "</pre>";
}

$composerHome = __DIR__ . "/../buzzz_forms_vendor/";

command("git fetch origin");
command("git pull origin main");
command("git status");
command("export COMPOSER_HOME=$composerHome && composer update", "composer update");
