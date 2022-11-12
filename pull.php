<?php
$composerHome = __DIR__ . "/../buzzz_forms_vendor/";
echo "<pre>";
system("git pull origin main 2>&1");
system("git status 2>&1");
system("export COMPOSER_HOME=$composerHome && composer update 2>&1");
echo "</pre>";