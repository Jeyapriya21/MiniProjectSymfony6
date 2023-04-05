<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Proxies\__CG__\App\Entity\Users;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {
        $data= array(
            "lastname"=>array('UserMP','AdminMP'),
            "firstname"=>array('David','Lena'),
            "emails" =>array('user@mini-project.com','admin@mini-project.com'),
            "passwords"=>array('User123','Admin123'),
            "roles"=>array('ROLE_USER','ROLE_ADMIN'),
            );
        
            for ($i = 0; $i < 2; $i++) {
                $user = new Users();
                $user->setLastname($data['lastname'][$i]);
                $user->setFirstname($data['firstname'][$i]);
                $user->setEmail($data['emails'][$i]);
                $user->setPassword($this->hasher->hashPassword(
                    $user,
                    $data['passwords'][$i])
                );
                $user->setRoles([$data['roles'][$i]]);
                $manager->persist($user);
            }
            $manager->flush();
    }
}
