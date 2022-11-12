<?php

system("git pull origin main 2>&1");
system("git status 2>&1");
system("composer update 2>&1");
