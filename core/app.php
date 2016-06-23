<?php

namespace Core {

    use Model\ReaderBot as readBot;

    class App {

        public static function Run() {
            $db = \Core\Database::getInstance();
            $bot = new readBot();
            $bot->getNewCommentsFromPhoto();
        }

    }

}

