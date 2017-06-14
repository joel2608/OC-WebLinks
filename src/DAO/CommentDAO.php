<?php

namespace WebLinks\DAO;

use WebLinks\Domain\Comment;

class CommentDAO extends DAO
{
    /**
     * @var \WebLinks\DAO\LinkDAO
     */
    private $linkDAO;

    /**
     * @var \WebLinks\DAO\UserDAO
     */
    private $userDAO;

    public function setLinkDAO(LinkDAO $linkDAO) {
        $this->linkDAO = $linkDAO;
    }
    public function setUserDAO(UserDAO $userDAO) {
        $this->userDAO = $userDAO;
    }

    /**
     * Removes all comments for a user
     *
     * @param integer $userId The id of the user
     */
    public function deleteAllByUser($userId) {
        $this->getDb()->delete('t_comment', array('user_id' => $userId));
    }

    /**
     * Returns a comment matching the supplied id.
     *
     * @param integer $id The comment id
     *
     * @return \WebLinks\Domain\Comment|throws an exception if no matching comment is found
     */
    public function find($id) {
        $sql = "select * from t_comment where com_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No comment matching id " . $id);
    }

    // ...

    /**
     * Removes a comment from the database.
     *
     * @param @param integer $id The comment id
     */
    public function delete($id) {
        // Delete the comment
        $this->getDb()->delete('t_comment', array('com_id' => $id));
    }

    /**
     * Removes all comments for an billet
     *
     * @param $billetId The id of the billet
     */
    public function deleteAllByLink($linkId) {
        $this->getDb()->delete('t_comment', array('link_id' => $linkId));
    }

    /**
     * Returns a list of all comments, sorted by date (most recent first)
     * @return array A list of all comments
     */
    public function findAll() {
        $sql = "SELECT * FROM t_comment ORDER BY com_id DESC";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $entities = array();
        foreach($result as $row) {
            $comId = $row['com_id'];
            $entities[$comId] = $this->buildDomainObject($row);
        }
        return $entities;
    }

    /**
     * Saves a comment into the database
     * @param \WebLinks\Domain\Comment $comment The comment to save
     */
    public function save(Comment $comment) {
        $commentData = array(
            'link_id' => $comment->getLink()->getId(),
            'user_id' => $comment->getAuthor()->getId(),
            'com_content' => $comment->getContent()
        );

        if ($comment->getId()) {
            // The comment has already been saved : update it
            $this->getDb()->update('t_comment', $commentData, array('com_id' => $comment->getId()));
        } else {
            // The comment has never been saved : insert it
            $this->getDb()->insert('t_comment', $commentData);
            // Get the id of the newly created comment and set it on the entity
            $id = $this->getDb()->lastInsertId();
            $comment->setId($id);
        }
    }


    /**
     * Return a list of all comments for an link, sorted by date (most recent first)
     * @param integer $linkId The link id
     * @return array A list of all comments for the link
     */
    public function findAllByLink($linkId) {
        // The associated link is retrieved only once
        $link = $this->linkDAO->find($linkId);

        // bil_id is not selected by the SQL query
        $sql = "SELECT com_id, com_content, user_id FROM t_comment WHERE link_id=? ORDER BY com_id";
        $result = $this->getDb()->fetchAll($sql, array($linkId));

        // Convert query result to an array of domain object
        $comments = array();
        foreach($result as $row) {
            $comId = $row['com_id'];
            $comment = $this->buildDomainObject($row);
            // The associated link is defined for the constructed comment
            $comment->setLink($link);
            $comments[$comId] = $comment;
        }
        return $comments;
    }

    /**
     * Creates an Comment object based on a DB row
     * @param array $row The DB row containing Comment data
     * @return \WebLinks\Domain\Comment
     */
    protected function buildDomainObject(array $row)
    {
        $comment = new Comment();
        $comment->setId($row['com_id']);
        $comment->setContent($row['com_content']);

        if (array_key_exists('link_id', $row)) {
            // Find and set the associated link
            $linkId = $row['link_id'];
            $link = $this->linkDAO->find($linkId);
            $comment->setLink($link);
        }
        if (array_key_exists('user_id', $row)) {
//             Find and set the associated user
            $userId = $row['user_id'];
            $user = $this->userDAO->find($userId);
            $comment->setAuthor($user);
        }
        return $comment;
    }
}