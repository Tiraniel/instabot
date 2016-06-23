<?php

namespace Model {

    class ParserModel {

        public function parsePage($url, $cookie = 'coockie', $post = '', $xhr = '') {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . DIRECTORY_SEPARATOR . $cookie . ".txt");
            curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . DIRECTORY_SEPARATOR . $cookie . ".txt");
            curl_setopt($ch, CURLOPT_REFERER, $url);
            curl_setopt($ch, CURLOPT_AUTOREFERER, true);
            if ($post) {
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            }
            if ($xhr) {
                preg_match('|csrftoken(.*)|', file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . $cookie . ".txt"), $csrf);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-CSRFToken:' . trim($csrf[1]), 'X-Instagram-AJAX:1', 'X-Requested-With:XMLHttpRequest'));
            }
            $file = curl_exec($ch);

            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $header = substr($file, 0, $header_size);
            $body = substr($file, $header_size);

            curl_close($ch);

            $doc = new \DOMDocument();
            $doc->loadHTML($body);
            
            return json_decode($doc->textContent);
        }

    }

}

