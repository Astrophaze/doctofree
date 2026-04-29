<?php
// src/DataFixtures/UserFixtures.php
namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {}
    public function load(ObjectManager $manager): void
    {
        // Utilisateur admin
        $admin = new User();
        $admin->setEmail('admin@doctofree.fr');
        $admin->setNom('Administrateur');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->hasher->hashPassword($admin, 'admin1234'));
        $manager->persist($admin);
        // Utilisateur standard
        $user = new User();
        $user->setEmail('user@doctofree.fr');
        $user->setNom('Utilisateur');
        $user->setRoles([]);
        $user->setPassword($this->hasher->hashPassword($admin, 'user1234'));
        $manager->persist($user);
        $manager->flush();
    }
}
