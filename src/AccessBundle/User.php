<?php
namespace AccessBundle;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;
class User implements UserInterface, EquatableInterface
{
    private $username;
    private $password;
    private $salt;
    private $roles;

    public function __construct(
        $username, $password, array $roles = array(), $salt = null
    ) {
        $this->username = $username;
        $this->password = $password;
        $this->salt = $salt;
        $this->roles = $roles;
    }
    function getUsername() {
        return $this->username;
    }function getPassword() {
    return $this->password;
}
    function getSalt() {
        return $this->salt;
    }
    function getRoles() {
        return $this->roles;
    }
    function setUsername($username) {
        $this->username = $username;
    }
    function setPassword($password) {
        $this->password = $password;
    }
    function setSalt($salt) {
        $this->salt = $salt;
    }
    function setRoles($roles) {
        $this->roles = $roles;
    }
    public function eraseCredentials() {
    }
    public function isEqualTo(UserInterface $user) {
        if (!$user instanceof User) {
            return false;
        }
        if ($this->password !== $user->getPassword()) {
            return false;
        }
        if ($this->salt !== $user->getSalt()) {
            return false;
        }
        if ($this->username !== $user->getUsername()) {
            return false;
        }
        return true;
    }
}