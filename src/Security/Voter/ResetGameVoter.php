<?php

namespace App\Security\Voter;

use App\Game\Game;
use App\Game\Runner;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ResetGameVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        return $subject instanceof Game && in_array($attribute, ['GAME_RESET']);
    }

    /**
     * @param string $attribute
     * @param Game $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        switch ($attribute) {
            case 'GAME_RESET':
                return $subject->getAttempts() < 2;
        }
        return false;
    }
}
