<?php
namespace AccessBundle;
use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;
use Symfony\Component\Security\Core\User\UserInterface;
class OrderVoter extends AbstractVoter
{
    /**
     *
     * @var UserService
     */
    const CREATE = 'create';
    const EDIT   = 'edit';
    private $userService;
    protected function getSupportedAttributes() {
        return array(self::CREATE, self::EDIT);
    }
    public function supportsAttribute($attribute)
    {
        return true;
    }
    protected function getSupportedClasses() {
        return array('AppBundle\Entity\Order');
    }
    protected function isGranted($attribute, $object, $user = null) {
        if (!$user instanceof UserInterface) {
            return false;
        }
        $role = sprintf('ROLE_API_ORDER', strtoupper($attribute));
        return in_array($role, $user->getRoles());
    }
}