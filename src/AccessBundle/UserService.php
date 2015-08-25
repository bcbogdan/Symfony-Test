<?php
namespace AccessBundle;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\DocumentRepository;
class UserService
{
    const ID = 'access.user';
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
            ->getRepository(Document\User::REPOSITORY);
    }
    public function find($username, $start = 0, $limit = 10) {
        $queryBuilder = $this->manager
            ->createQueryBuilder(Document\User::REPOSITORY);
        $queryBuilder->limit($limit)->skip($start);
        if ($username) {
            $queryBuilder->field("username") . equals($username);
        }
        return $queryBuilder->getQuery()->execute();
    }
    public function count() {
        $queryBuilder = $this->manager
            ->createQueryBuilder(Document\User::REPOSITORY);
        return $queryBuilder->getQuery()->count();
    }
    public function create($username, $password, $roles) {
    $user = new Document\User();
    $user->setUsername($username)
        ->setPassword($password)
        ->setRoles($roles);
    $this->manager->persist($user);
    $this->manager->flush();
}
}