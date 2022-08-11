<?php

namespace App\Security\Voter;

use App\Entity\Task;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class TaskVoter extends Voter
{
    public const PERSIST = 'PERSIST';
    public const VIEW = 'VIEW';
    public const DELETE = 'DELETE';

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::PERSIST, self::VIEW])
            && $subject instanceof Task;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        /** @var Task $subject */
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::PERSIST:
                if (['ROLE_ADMIN'] == $user->getRoles() || $user === $subject->getUser()) {
                    return true;
                }
                break;
            case self::VIEW:
                if (['ROLE_ADMIN'] == $user->getRoles() || $user === $subject->getUser()) {
                    return true;
                }
                break;
            case self::DELETE:
                if (['ROLE_ADMIN'] == $user->getRoles() && null === $subject->getUser()) {
                    return true;
                }
                break;
        }

        return false;
    }
}
