<?php

namespace WebLinks\DAO;

use WebLinks\Domain\Link;
use Symfony\Component\HttpFoundation\Request;

class LinkDAO extends DAO 
{
    /**
     * @var \WebLinks\DAO\UserDAO
     */
    private $userDAO;

    public function setUserDAO(UserDAO $userDAO) {
        $this->userDAO = $userDAO;
    }

    /**
     * Saves an link into the database.
     * @param \WebLinks\Domain\Link $link The link to save
     */
    public function save(Link $link) {
        $linkData = array(
            'link_id' => $link->getId(),
            'link_title' => $link->getTitle(),
            'link_url'   => $link->getUrl(),
            'user_id'    => $link->getAuthor(),
        );

        if($link->getId()) {
            // The link has already been saved: update it
            $this->getDb()->update('t_link', $linkData, array(
                'link_id' => $link->getAuthor(),
            ));
        } else {
            // The link has never been saved : insert it
            $this->getDb()->insert('t_link', $linkData);
            // Get the id of the newly created link and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $link->setId($id);
        }
    }

    /**
     * Removes an link from the database.
     * @param integer $id The link id.
     */
    public function delete($id) {
        // Delete the link
        $this->getDb()->delete('t_link', array('link_id' => $id));
    }

    public function deleteAllByUser($userId) {
        $this->getDb()->delete('t_link', array('user_id' => $userId));
    }


    /**
     * Returns a list of all links, sorted by id.
     *
     * @return array A list of all links.
     */
    public function findAll() {
        $sql = "select * from t_link order by link_id desc";
        $result = $this->getDb()->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $entities = array();
        foreach ($result as $row) {
            $id = $row['link_id'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;
    }

    public function find($id) {
        $sql = "SELECT * FROM t_link WHERE link_id = ?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No comment matching id " . $id);

    }

    /**
     * Creates an Link object based on a DB row.
     *
     * @param array $row The DB row containing Link data.
     * @return \WebLinks\Domain\Link
     */
    protected function buildDomainObject(array $row) {
        $link = new Link();
        $link->setId($row['link_id']);
        $link->setUrl($row['link_url']);
        $link->setTitle($row['link_title']);

        if(array_key_exists('user_id', $row)) {
            // Find and set the associated author
            $userId = $row['user_id'];
//            $user = $this->userDAO->find($link->getId());
//            $link->setAuthor($user);
        }
        
        return $link;
    }
}
