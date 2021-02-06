<?php

namespace App\Security\Voter;

use App\Entity\Feedback;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class FeedbackVoter extends Voter
{
    const FEEDBACK_EDIT = "FEEDBACK_EDIT";
    private $security;

    public function __construct(Security $security){
        $this->security = $security;
    }

    protected function supports($attribute, $feedback)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::FEEDBACK_EDIT])
            && $feedback instanceof \App\Entity\Feedback;
    }

    protected function voteOnAttribute($attribute, $feedback, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::FEEDBACK_EDIT:
                return ($feedback->getAuthor() == $user) || ($this->security->isGranted('ROLE_MODO'));      //booléen
        }

        return false;
    }
}
