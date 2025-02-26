<?php

namespace Domain\Repository;

use Domain\Model\User\User;
use Domain\Model\User\UserId;
use Domain\Model\User\Email;

interface UserRepositoryInterface
{
    public function save(User $user): void;
    public function findById(UserId $id): ?User;
    public function findByEmail(Email $email): ?User;
    public function delete(UserId $id): void;
}
