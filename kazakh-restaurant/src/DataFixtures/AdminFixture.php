<?php

namespace App\DataFixtures;

use App\Entity\Employe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixture extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new Employe();
        $admin->setEmail('admin@example.com');
        $admin->setRoles(['ROLE_ADMIN']);
        
        // Hashage du mot de passe
        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            'test'
        );
        $admin->setPassword($hashedPassword);
        
        // Ajoutez d'autres champs si nécessaire
        $admin->setNom('Admin');
        $admin->setPrenom('Super');
        $admin->setTelephone('0124567892');


        $manager->persist($admin);
        $manager->flush();
    }
}