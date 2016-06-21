<?php

define(ROOTDIR, __DIR__);

spl_autoload_extensions(".php");

spl_autoload_register();

Core\App::Run();