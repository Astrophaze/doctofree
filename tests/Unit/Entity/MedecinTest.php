<?php
// tests/Unit/Entity/MedecinTest.php

namespace App\Tests\Unit\Entity;

use App\Entity\Cabinet;
use App\Entity\Medecin;
use App\Entity\Rendezvous;
use App\Entity\Specialite;
use PHPUnit\Framework\TestCase;

class MedecinTest extends TestCase
{
    private Medecin $medecin;

    protected function setUp(): void
    {
        $this->medecin = new Medecin();
    }

    public function testNomGetterAndSetter(): void
    {
        $this->medecin->setNom('Dupont');

        $this->assertSame('Dupont', $this->medecin->getNom());
    }

    public function testPrenomGetterAndSetter(): void
    {
        $this->medecin->setPrenom('Jean');

        $this->assertSame('Jean', $this->medecin->getPrenom());
    }

    public function testRppsGetterAndSetter(): void
    {
        $this->medecin->setRpps('10003456789');

        $this->assertSame('10003456789', $this->medecin->getRpps());
    }

    public function testTelephoneGetterAndSetter(): void
    {
        $this->medecin->setTelephone('0123456789');

        $this->assertSame('0123456789', $this->medecin->getTelephone());
    }

    public function testEmailGetterAndSetter(): void
    {
        $this->medecin->setEmail('jean.dupont@example.com');

        $this->assertSame('jean.dupont@example.com', $this->medecin->getEmail());
    }

    // --- Specialite ---

    public function testSpecialiteCollectionIsEmptyOnConstruct(): void
    {
        $this->assertCount(0, $this->medecin->getSpecialite());
    }

    public function testAddSpecialiteAddsToCollection(): void
    {
        $specialite = $this->createMock(Specialite::class);

        $this->medecin->addSpecialite($specialite);

        $this->assertCount(1, $this->medecin->getSpecialite());
        $this->assertTrue($this->medecin->getSpecialite()->contains($specialite));
    }

    public function testAddSpecialiteDoesNotAddDuplicate(): void
    {
        $specialite = $this->createMock(Specialite::class);

        $this->medecin->addSpecialite($specialite);
        $this->medecin->addSpecialite($specialite);

        $this->assertCount(1, $this->medecin->getSpecialite());
    }

    public function testRemoveSpecialiteRemovesFromCollection(): void
    {
        $specialite = $this->createMock(Specialite::class);

        $this->medecin->addSpecialite($specialite);
        $this->medecin->removeSpecialite($specialite);

        $this->assertCount(0, $this->medecin->getSpecialite());
    }

    // --- Cabinets ---

    public function testCabinetsCollectionIsEmptyOnConstruct(): void
    {
        $this->assertCount(0, $this->medecin->getCabinets());
    }

    public function testAddCabinetAddsToCollection(): void
    {
        $cabinet = $this->createMock(Cabinet::class);

        $this->medecin->addCabinet($cabinet);

        $this->assertCount(1, $this->medecin->getCabinets());
        $this->assertTrue($this->medecin->getCabinets()->contains($cabinet));
    }

    public function testAddCabinetDoesNotAddDuplicate(): void
    {
        $cabinet = $this->createMock(Cabinet::class);

        $this->medecin->addCabinet($cabinet);
        $this->medecin->addCabinet($cabinet);

        $this->assertCount(1, $this->medecin->getCabinets());
    }

    public function testRemoveCabinetRemovesFromCollection(): void
    {
        $cabinet = $this->createMock(Cabinet::class);

        $this->medecin->addCabinet($cabinet);
        $this->medecin->removeCabinet($cabinet);

        $this->assertCount(0, $this->medecin->getCabinets());
    }

    // --- RendezVous ---

    public function testRendezVousCollectionIsEmptyOnConstruct(): void
    {
        $this->assertCount(0, $this->medecin->getRendezVous());
    }

    public function testAddRendezVousAddsToCollection(): void
    {
        $rdv = $this->createMock(Rendezvous::class);
        // On indique à PHPUnit que setMedecin() peut être appelé
        $rdv->method('setMedecin')->willReturnSelf();

        $this->medecin->addRendezVous($rdv);

        $this->assertCount(1, $this->medecin->getRendezVous());
        $this->assertTrue($this->medecin->getRendezVous()->contains($rdv));
    }

    public function testAddRendezVousDoesNotAddDuplicate(): void
    {
        $rdv = $this->createMock(Rendezvous::class);
        $rdv->method('setMedecin')->willReturnSelf();

        $this->medecin->addRendezVous($rdv);
        $this->medecin->addRendezVous($rdv);

        $this->assertCount(1, $this->medecin->getRendezVous());
    }

    public function testRemoveRendezVousRemovesFromCollection(): void
    {
        $rdv = $this->createMock(Rendezvous::class);
        $rdv->method('setMedecin')->willReturnSelf();
        $rdv->method('getMedecin')->willReturn($this->medecin);

        $this->medecin->addRendezVous($rdv);
        $this->medecin->removeRendezVous($rdv);

        $this->assertCount(0, $this->medecin->getRendezVous());
    }

    public function testToStringReturnsNom(): void
    {
        $this->medecin->setNom('Dupont');

        $this->assertSame('Dupont', (string) $this->medecin);
    }

    public function testIdIsNullByDefault(): void
    {
        // L'id est géré par Doctrine, il doit être null avant persistance
        $this->assertNull($this->medecin->getId());
    }
}
