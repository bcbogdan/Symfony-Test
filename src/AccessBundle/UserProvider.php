<?php
namespace AccessBundle;
use AccessBundle\Document\User as UserDocument;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;


class UserProvider implements UserProviderInterface
{
    const ID = 'access.user_provider';
    /**
     *
     * @var DocumentManager
     */
    private $manager;
    /**
     *
     * @var DocumentRepository
     */
    private $repository;
    public function __construct(ManagerRegistry $registry) {
        $this->manager = $registry->getManager();
        $this->repository = $this->manager
            ->getRepository(UserDocument::REPOSITORY);
    }
    public function loadUserByUsername($username) {
        /* @var $user UserDocument */
        $user = $this->repository->findOneByUsername($username);
        if (!$user) {
            throw new UsernameNotFoundException();
        }
        return new User(
            $user->getUsername(), $user->getPassword(), $user->getRoles()
        );
    }public function refreshUser(UserInterface $user) {
    if (!$user instanceof User) {
        throw new UnsupportedUserException(
            sprintf('Instances of "%s" are not supported.', get_class($user))
        );
    }
    return $this->loadUserByUsername($user->getUsername());
}
    public function supportsClass($class) {
        $className = '\AccessBundle\UserProvider';
        return $class === $className || is_subclass_of($class, $className);
    }
}