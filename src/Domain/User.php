<?php

namespace WebLinks\Domain;

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    /*****************************************************************************\
     *                                     VARIABLE                               *
    \*****************************************************************************/
    /**
     * User id
     * @var integer
     */
    private $id;

    /**
     * User name
     * @var string
     */
    private $username;

    /**
     * User password
     * @var string
     */
    private $password;

    /**
     * Salt that was originally used to encode the password
     * @var string
     */
    private $salt;

    /**
     * Role
     * Values : ROLE_USER or ROLE_ADMIN
     * @var string
     */
    private $role;


    /*****************************************************************************\
     *                                     GETTERS                               *
    \*****************************************************************************/

    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getSalt() {
        return $this->salt;
    }

    public function getRole() {
        return $this->role;
    }

    /*****************************************************************************\
     *                                     SETTERS                               *
    \*****************************************************************************/
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    public function setSalt($salt) {
        $this->salt = $salt;
        return $this;
    }

    public function setRole($role) {
        $this->role = $role;
        return $this;
    }

    /*****************************************************************************\
     *                                     METHODS                               *
    \*****************************************************************************/
    /**
     * @inheritDoc
     */
    public function getRoles() {
        return array($this->getRole());
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials() {
        // Nothing to do here
    }

}