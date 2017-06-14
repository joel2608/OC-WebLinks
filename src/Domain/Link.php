<?php

namespace WebLinks\Domain;

class Link 
{
    /**
     * Link id.
     *
     * @var integer
     */
    private $id;

    /**
     * Link title.
     *
     * @var string
     */
    private $title;

    /**
     * Link url.
     *
     * @var string
     */
    private $url;

    /**
     * The link Author  = user_id
     * @var \WebLinks\Domain\User
     */
    private $author;

    /*****************************************************************************\
     *                                     GETTERS                               *
    \*****************************************************************************/
    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getAuthor() {
        return $this->author;
    }


    /*****************************************************************************\
     *                                     SETTERS                               *
    \*****************************************************************************/
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function setUrl($url) {
        $this->url = $url;
        return $this;
    }

    public function setAuthor(User $author) {
        $this->author = $author;
        return $this;
    }
}
