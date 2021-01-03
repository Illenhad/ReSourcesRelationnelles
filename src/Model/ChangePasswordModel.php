<?php

namespace App\Model;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ChangePasswordModel {

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param EntityManagerInterface $manager
     * @param string $username
     * @param $data
     * @return string
     */
    public function changePassword(EntityManagerInterface $manager, string $username, $data): string {
        $user = $manager->getRepository(User::class)->findOneBy([
            'username' => $username
        ]);

        if(!$this->passwordEncoder->isPasswordValid($user, $data['old_password'])) {
            return "L'ancien mot de passe n'est pas valide";
        }

        if ($data['new_password'] == $data['new_password_confirm']) {
            $user->setPassword($this->passwordEncoder->encodePassword($user, $data['new_password']));
            $manager->persist($user);
            $manager->flush();
        } else {
            return "Saisie incorrecte : vous devez saisir deux fois le même mot de passe pour le confirmer";
        }

        return "";
    }
}