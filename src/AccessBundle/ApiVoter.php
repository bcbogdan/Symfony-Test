<?php
namespace AccessBundle;
use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;
use Symfony\Component\Security\Core\User\UserInterface;
class ApiVoter extends AbstractVoter
{
    /**
     *
     * @var UserService
     */
    private $userService;
    protected function getSupportedAttributes() {
        return array();
    }
    public function supportsAttribute($attribute)
    {
        return true;
    }
    protected function getSupportedClasses() {
        return array('JsonRpcBundle\Server');
    }
    protected function isGranted($attribute, $object, $user = null) {
        if (!$user instanceof UserInterface) {
            return false;
        }
        $role = sprintf('ROLE_API_%s', strtoupper($attribute));
        return in_array($role, $user->getRoles());
    }
}