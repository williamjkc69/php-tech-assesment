<?php

namespace Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManager;
use Domain\Model\User\User;
use Domain\Model\User\UserId;
use Domain\Model\User\Email;
use Domain\Repository\UserRepositoryInterface;

class DoctrineUserRepository implements UserRepositoryInterface
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function findById(UserId $id): ?User
    {
        return $this->entityManager->find(User::class, $id->value());
    }

    public function findByEmail(Email $email): ?User
    {
        var_dump($email->value(), '1111');
        $test = $this->entityManager->getRepository(User::class)
            ->findOneBy(['email.value' => $email->value()]);
        var_dump('hereA');
        var_dump($test);
        return $test;
    }

    public function delete(UserId $id): void
    {
        $user = $this->findById($id);
        if ($user) {
            $this->entityManager->remove($user);
            $this->entityManager->flush();
        }
    }
}
