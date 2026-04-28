<?php
// tests/Unit/Entity/CabinetTest.php

namespace App\Tests\Unit\Entity;

use App\Entity\Cabinet;
use App\Entity\Medecin;
use PHPUnit\Framework\TestCase;

class CabinetTest extends TestCase
{
    private Cabinet $cabinet;

    protected function setUp(): void
    {
        $this->cabinet = new Cabinet();
    }

    public function testNomGetterAndSetter(): void
    {
        $this->cabinet->setNom('Cabinet du Parc');

        $this->assertSame('Cabinet du Parc', $this->cabinet->getNom());
    }

    public function testAdresseGetterAndSetter(): void
    {
        $this->cabinet->setAdresse('12 rue de la Paix, Paris');

        $this->assertSame('12 rue de la Paix, Paris', $this->cabinet->getAdresse());
    }

    public function testTelephoneGetterAndSetter(): void
    {
        $this->cabinet->setTelephone('0123456789');

        $this->assertSame('0123456789', $this->cabinet->getTelephone());
    }

    public function testMedecinsCollectionIsEmptyOnConstruct(): void
    {
        $this->assertCount(0, $this->cabinet->getMedecins());
    }

    public function testAddMedecinAddsToCollection(): void
    {
        $medecin = $this->createMock(Medecin::class);
        // On indique à PHPUnit que addCabinet() peut être appelé
        $medecin->method('addCabinet')->willReturnSelf();

        $this->cabinet->addMedecin($medecin);

        $this->assertCount(1, $this->cabinet->getMedecins());
        $this->assertTrue($this->cabinet->getMedecins()->contains($medecin));
    }

    public function testAddMedecinDoesNotAddDuplicate(): void
    {
        $medecin = $this->createMock(Medecin::class);
        $medecin->method('addCabinet')->willReturnSelf();

        // On ajoute deux fois le même médecin
        $this->cabinet->addMedecin($medecin);
        $this->cabinet->addMedecin($medecin);

        // Il ne doit apparaître qu'une seule fois
        $this->assertCount(1, $this->cabinet->getMedecins());
    }

    public function testRemoveMedecinRemovesFromCollection(): void
    {
        $medecin = $this->createMock(Medecin::class);
        $medecin->method('addCabinet')->willReturnSelf();

        $this->cabinet->addMedecin($medecin);
        $this->cabinet->removeMedecin($medecin);

        $this->assertCount(0, $this->cabinet->getMedecins());
    }

    public function testToStringReturnsNom(): void
    {
        $this->cabinet->setNom('Cabinet Saint-Louis');

        $this->assertSame('Cabinet Saint-Louis', (string) $this->cabinet);
    }

    public function testIdIsNullByDefault(): void
    {
        // L'id est géré par Doctrine, il doit être null avant persistance
        $this->assertNull($this->cabinet->getId());
    }
}
