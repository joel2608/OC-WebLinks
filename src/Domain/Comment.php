<?php

namespace WebLinks\Domain;



class Comment
{
    /**
     * Comment id.
     * @var integer
     */
    private $id;

    /**
     * Comment author
     * @var \WebLinks\Domain\User
     */
    private $author;

    /**
     * Comment content
     * @var string
     */
    private $content;

    /**
     * Associated Link
     * @var \WebLinks\Domain\Link
     */
    private $link;



    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function setAuthor(User $author) {
        $this->author = $author;
        return $this;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function getLink() {
        return $this->link;
    }

    public function setLink(Link $link) {
        $this->link = $link;
        return $this;
    }



}

