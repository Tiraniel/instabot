<?php

namespace Core {

    use Model\ParserModel as parser;

    class App {

        public static function Run() {
            $db = \Core\Database::getInstance();
            $parser = new parser();
            $parser->parsePage('https://instagram.com/accounts/login/ajax/bz', 'coockie', 'username=serg.gray.kovalchuk&password=132456ti', 1);
            $result = $parser->parsePage('https://instagram.com/cypherkun/', 'coockie', 0, 1);

            $doc = new \DOMDocument();
            $doc->loadHTML($result);
            
            $js = $doc->getElementsByTagName('script');
            $data;
            
            foreach($js as $e)
            {             
                if(strpos($e->textContent, 'window._sharedData') !== FALSE) {
                    $data = str_replace('window._sharedData = ', '', $e->textContent);
                    break;
                }                               
            }                        
            
            $data = substr_replace($data, '', -1);
            
            var_dump(json_decode($data));
        }

    }

}

