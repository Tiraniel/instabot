<?php

namespace Model {

    use \Model\ParserModel as parser;

    class ReaderBot {

        private $_photoCount = 12;
        private $_mediaItemsCollection = array();

        public function getNewCommentsFromPhoto() {
            $parser = new parser();
            $result = $parser->parsePage('www.instagram.com/cypherkun/media', 'coockie', 0, 1);

            $mediaItemsQty = count($result->items);
            $photoQty = $mediaItemsQty > $this->_photoCount ? $this->_photoCount : $mediaItemsQty;

            for ($i = 0; $i < $photoQty; $i++) {
                $this->_mediaItemsCollection[] = $result->items[$i];
            }

            $this->AddNewComments();
        }

        private function AddNewComments() {
            $dataArray = array();

            foreach ($this->_mediaItemsCollection as $item) {
                if ($item->comments->count > 0) {

                    $dataArray = array(
                        'code' => $item->code,
                        'comment' => array_pop($item->comments->data)
                    );
                }

                if (!empty($dataArray)) {
                    $this->addCommentToDb($dataArray);
                }
            }
        }

        private function addCommentToDb($commentData) {

            if ($this->isAdded($commentData)) {
                return;
            }

            $db = \Core\Database::getInstance()->getConnection();
            $comment = $commentData["comment"];
            
            $query = $db->insert("comments", array(
                "photo_code" => $commentData["code"],
                "created_time" => $comment->created_time,
                "text" => $comment->text,
                "user_name" => $comment->from->username,
                "user_profile_picture" => $comment->from->profile_picture,
            ));
            
            $this->createTask($db->insertId());
        }

        private function isAdded($commentData) {
            $db = \Core\Database::getInstance()->getConnection();
            return (bool) $db->queryFirstField("SELECT * FROM comments WHERE photo_code = %s and created_time = %d", $commentData["code"], $commentData["comment"]->created_time);
        }
        
        private function createTask($commentId)
        {
            $db = \Core\Database::getInstance()->getConnection();
            $db->insert("tasks", array(
                "comment_id" => $commentId
            ));
        }
    }

}

