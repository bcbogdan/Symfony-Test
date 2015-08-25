<?php
namespace AccessBundle\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
/**
 * @MongoDB\Document(db="security", collection="users")
 */
class User
{
    const REPOSITORY = 'AccessBundle:User';
    /**
     * @MongoDB\Id
     */
    private $id;
    /**
     * @MongoDB\String
     */
    private $username;
    /**
     * @MongoDB\String
     */
    private $password;
    /**
     * @MongoDB\Collection
     */
    private $roles = array();
    public function getId() {
        return $this->id;
    }
    public function getUsername() {
        return $this->username;
    }
    public function getPassword() {
        return $this->password;
    }
    public function getRoles() {
        return $this->roles;
    }public function setUsername($username) {
    $this->username = $username;
    return $this;
}
    public function setPassword($password) {
        $this->password = bin2hex(hash('sha512', $password, true));
        return $this;
    }
    public function setRoles(array $roles) {
        $this->roles = $roles;
        return $this;
    }
    public function addRole($role) {
        $this->roles[] = $role;
    }
}