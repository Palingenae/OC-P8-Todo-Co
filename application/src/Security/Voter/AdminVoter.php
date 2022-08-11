<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class AdminVoter extends Voter
{
    public const PERSIST = 'PERSIST';
    public const VIEW = 'VIEW';

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::PERSIST, self::VIEW])
            && $subject instanceof User;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $admin = $token->getUser();

        if (!$admin instanceof UserInterface) {
            return false;
        }

        $condition = ['ROLE_ADMIN', 'ROLE_USER'] === $admin->getRoles();

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
