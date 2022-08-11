<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class UserPersisterVoter extends Voter
{
    /**
     * Persist is both for creating an user and updating it.
     */
    public const PERSIST = 'PERSIST';
    public const VIEW = 'VIEW';

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::PERSIST, self::VIEW])
            && $subject instanceof User;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        /** @var User $subject */
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        $condition = ['ROLE_ADMIN'] == $user->getRoles() || $subject->getUsername() == $user;

        switch ($attribute) {
            case self::PERSIST:
                if ($condition) {
                    return true;
                }
                break;
            case self::VIEW:
                if ($condition) {
                    return true;
                }
                break;
        }

        return false;
    }
}
