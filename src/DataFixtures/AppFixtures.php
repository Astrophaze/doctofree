<?php

namespace App\DataFixtures;

use App\Entity\Cabinet;
use App\Entity\Consultation;
use App\Entity\Medecin;
use App\Entity\Medicament;
use App\Entity\Ordonnance;
use App\Entity\Patient;
use App\Entity\Prescription;
use App\Entity\Rendezvous;
use App\Entity\Specialite;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // ─── SPÉCIALITÉS ─────────────────────────────────────────────────
        $specialites = [];
        $specialitesData = [
            ['Médecine générale', 'Prise en charge globale du patient'],
            ['Cardiologie', 'Maladies du cœur et des vaisseaux'],
            ['Dermatologie', 'Maladies de la peau'],
            ['Pédiatrie', 'Médecine de l\'enfant'],
            ['Orthopédie', 'Maladies de l\'appareil locomoteur'],
        ];

        foreach ($specialitesData as [$libelle, $description]) {
            $s = new Specialite();
            $s->setLibelle($libelle);
            $s->setDescription($description);
            $manager->persist($s);
            $specialites[] = $s;
        }

        // ─── CABINETS ─────────────────────────────────────────────────────
        $cabinets = [];
        $cabinetsData = [
            ['Cabinet du Parc', '12 avenue du Parc, Lyon', '04 72 11 22 33'],
            ['Clinique Saint-Jean', '8 rue de la République, Villeurbanne', '04 78 44 55 66'],
            ['Cabinet Bellecour', '3 place Bellecour, Lyon', '04 72 77 88 99'],
        ];

        foreach ($cabinetsData as [$nom, $adresse, $telephone]) {
            $c = new Cabinet();
            $c->setNom($nom);
            $c->setAdresse($adresse);
            $c->setTelephone($telephone);
            $manager->persist($c);
            $cabinets[] = $c;
        }

        // ─── MÉDECINS ─────────────────────────────────────────────────────
        $medecins = [];
        $medecinsData = [
            ['Martin', 'Sophie', '12345678901', '06 11 22 33 44', 'sophie.martin@cabinet.fr'],
            ['Dubois', 'Pierre', '23456789012', '06 22 33 44 55', 'pierre.dubois@cabinet.fr'],
            ['Leroy', 'Claire', '34567890123', '06 33 44 55 66', 'claire.leroy@cabinet.fr'],
        ];

        foreach ($medecinsData as [$nom, $prenom, $rpps, $telephone, $email]) {
            $m = new Medecin();
            $m->setNom($nom);
            $m->setPrenom($prenom);
            $m->setRpps($rpps);
            $m->setTelephone($telephone);
            $m->setEmail($email);
            $manager->persist($m);
            $medecins[] = $m;
        }
        // ─── ASSOCIATIONS MÉDECINS ↔ SPÉCIALITÉS ─────────────────────────────
        // Martin Sophie — Médecine générale + Pédiatrie
        $medecins[0]->addSpecialite($specialites[0]);
        $medecins[0]->addSpecialite($specialites[3]);

        // Dubois Pierre — Cardiologie
        $medecins[1]->addSpecialite($specialites[1]);

        // Leroy Claire — Dermatologie + Orthopédie
        $medecins[2]->addSpecialite($specialites[2]);
        $medecins[2]->addSpecialite($specialites[4]);

        // ─── ASSOCIATIONS MÉDECINS ↔ CABINETS ────────────────────────────────
        // Martin Sophie exerce dans le Cabinet du Parc et Bellecour
        $cabinets[0]->addMedecin($medecins[0]);
        $cabinets[2]->addMedecin($medecins[0]);

        // Dubois Pierre exerce dans la Clinique Saint-Jean
        $cabinets[1]->addMedecin($medecins[1]);

        // Leroy Claire exerce dans tous les cabinets
        $cabinets[0]->addMedecin($medecins[2]);
        $cabinets[1]->addMedecin($medecins[2]);
        $cabinets[2]->addMedecin($medecins[2]);

        // ─── PATIENTS ─────────────────────────────────────────────────────
        $patientsData = [
            ['Dupont',    'Jean',      '1980-03-15', 'M', '14 rue des Fleurs, Lyon',          '06 10 20 30 40', 'jean.dupont@mail.fr',      '175 80 03 69 123 456 78'],
            ['Bernard',   'Marie',     '1992-07-22', 'F', '5 impasse des Lilas, Bron',         '06 20 30 40 50', 'marie.bernard@mail.fr',    '295 92 07 69 234 567 89'],
            ['Thomas',    'Lucas',     '1975-11-08', 'M', '22 boulevard Mermoz, Lyon',         '06 30 40 50 60', 'lucas.thomas@mail.fr',     '175 75 11 69 345 678 90'],
            ['Petit',     'Emma',      '2001-05-30', 'F', '3 rue Garibaldi, Villeurbanne',     '06 40 50 60 70', 'emma.petit@mail.fr',       '201 01 05 69 456 789 01'],
            ['Robert',    'Nicolas',   '1988-09-14', 'M', '18 avenue Berthelot, Lyon',         '06 50 60 70 80', 'nicolas.robert@mail.fr',   '188 88 09 69 567 890 12'],
            ['Richard',   'Camille',   '1995-02-28', 'F', '7 rue Chevreul, Lyon',              '06 60 70 80 90', 'camille.richard@mail.fr',  '295 95 02 69 678 901 23'],
            ['Moreau',    'Antoine',   '1970-12-03', 'M', '45 cours Lafayette, Lyon',          '06 70 80 90 01', 'antoine.moreau@mail.fr',   '170 70 12 69 789 012 34'],
            ['Simon',     'Léa',       '1983-06-19', 'F', '11 rue de Sèze, Lyon',              '06 80 90 01 02', 'lea.simon@mail.fr',        '283 83 06 69 890 123 45'],
            ['Laurent',   'Hugo',      '1999-04-07', 'M', '29 rue Passet, Lyon',               '06 90 01 02 03', 'hugo.laurent@mail.fr',     '199 99 04 69 901 234 56'],
            ['Lefebvre',  'Chloé',     '2005-08-25', 'F', '6 allée des Roses, Décines',        '07 01 02 03 04', 'chloe.lefebvre@mail.fr',   '205 05 08 69 012 345 67'],
            ['Michel',    'Théo',      '1968-01-17', 'M', '33 rue Vendôme, Lyon',              '07 02 03 04 05', 'theo.michel@mail.fr',      '168 68 01 69 123 456 78'],
            ['Garcia',    'Inès',      '1990-10-11', 'F', '2 rue Bossuet, Lyon',               '07 03 04 05 06', 'ines.garcia@mail.fr',      '290 90 10 69 234 567 89'],
            ['Martinez',  'Maxime',    '1978-07-04', 'M', '17 rue Francis de Pressensé, Bron', '07 04 05 06 07', 'maxime.martinez@mail.fr',  '178 78 07 69 345 678 90'],
            ['Fontaine',  'Manon',     '2003-03-21', 'F', '8 rue Waldeck-Rousseau, Lyon',      '07 05 06 07 08', 'manon.fontaine@mail.fr',   '203 03 03 69 456 789 01'],
            ['Rousseau',  'Baptiste',  '1985-11-30', 'M', '54 avenue Jean Jaurès, Lyon',       '07 06 07 08 09', 'baptiste.rousseau@mail.fr','185 85 11 69 567 890 12'],
        ];

        $patients = [];
        foreach ($patientsData as [$nom, $prenom, $naissance, $sexe, $adresse, $tel, $email, $secu]) {
            $p = new Patient();
            $p->setNom($nom);
            $p->setPrenom($prenom);
            $p->setDateNaissance(new \DateTimeImmutable($naissance));
            $p->setSexe($sexe);
            $p->setAdresse($adresse);
            $p->setTelephone($tel);
            $p->setEmail($email);
            $p->setNumeroSecu($secu);
            $p->setDateInscription(new \DateTimeImmutable('-' . rand(1, 730) . ' days'));
            $manager->persist($p);
            $patients[] = $p;
        }

        // ─── MÉDICAMENTS ──────────────────────────────────────────────────
        $medicaments = [];
        $medicamentsData = [
            ['Doliprane',    'Paracétamol',    'comprimé',  '1000mg'],
            ['Amoxicilline', 'Amoxicilline',   'gélule',    '500mg'],
            ['Ibuprofène',   'Ibuprofène',     'comprimé',  '400mg'],
            ['Oméprazole',   'Oméprazole',     'gélule',    '20mg'],
            ['Ventoline',    'Salbutamol',     'spray',     '100µg/dose'],
            ['Metformine',   'Metformine',     'comprimé',  '850mg'],
            ['Levothyrox',   'Lévothyroxine',  'comprimé',  '75µg'],
        ];

        foreach ($medicamentsData as [$nom, $dci, $forme, $dosage]) {
            $med = new Medicament();
            $med->setNom($nom);
            $med->setDci($dci);
            $med->setForme($forme);
            $med->setDosage($dosage);
            $manager->persist($med);
            $medicaments[] = $med;
        }

        $manager->flush(); // flush intermédiaire pour que les IDs soient disponibles

        // ─── RENDEZ-VOUS + CONSULTATIONS + ORDONNANCES ───────────────────
        $statuts = ['planifié', 'effectué', 'annulé'];
        $motifs = [
            'Douleurs dorsales', 'Fièvre persistante', 'Suivi tensionnel',
            'Renouvellement ordonnance', 'Bilan annuel', 'Toux chronique',
            'Fatigue intense', 'Contrôle post-opératoire',
        ];
        $diagnostics = [
            'Lombalgie aiguë', 'Rhinopharyngite virale', 'Hypertension artérielle stable',
            'Diabète de type 2 équilibré', 'Bronchite aiguë', 'Anxiété légère',
            'Hypothyroïdie compensée', 'Entorse bénigne',
        ];
        $anamneses = [
            'Patient se plaint de douleurs depuis 3 jours.',
            'Apparition des symptômes suite à un épisode grippal.',
            'Antécédents familiaux à prendre en compte.',
            'Symptômes récurrents depuis plusieurs semaines.',
            null, null, // certaines consultations sans anamnèse
        ];

        foreach ($patients as $i => $patient) {
            // Chaque patient a entre 1 et 3 rendez-vous
            $nbRdv = rand(1, 3);
            for ($j = 0; $j < $nbRdv; $j++) {

                $medecin = $medecins[$i % count($medecins)];
                $statut  = $statuts[array_rand($statuts)];
                $daysAgo = rand(1, 180);

                $rdv = new Rendezvous();
                $rdv->setDateHeure(new \DateTime('-' . $daysAgo . ' days'));
                $rdv->setDureeMinutes([15, 20, 30, 45][array_rand([15, 20, 30, 45])]);
                $rdv->setStatut($statut);
                $rdv->setMotif($motifs[array_rand($motifs)]);
                $rdv->setMedecin($medecin);
                $rdv->setPatient($patient);
                $manager->persist($rdv);

                // On crée une consultation uniquement si le RDV est effectué
                if ($statut === 'effectué') {
                    $consultation = new Consultation();
                    $consultation->setDateHeure(new \DateTime('-' . $daysAgo . ' days'));
                    $consultation->setDiagnostic($diagnostics[array_rand($diagnostics)]);
                    $consultation->setAnamnese($anamneses[array_rand($anamneses)]);
                    $consultation->setNotes(rand(0, 1) ? 'Contrôle dans 3 mois.' : null);
                    $consultation->setRendezVous($rdv);
                    $rdv->setConsultation($consultation);
                    $manager->persist($consultation);

                    // On crée une ordonnance pour 2 consultations sur 3
                    if (rand(0, 2) > 0) {
                        $dateEmission = new \DateTimeImmutable('-' . $daysAgo . ' days');

                        $ordonnance = new Ordonnance();
                        $ordonnance->setDateEmission($dateEmission);
                        $ordonnance->setDateValidite($dateEmission->modify('+3 months'));
                        $ordonnance->setInstructions('Prendre les médicaments au cours des repas. Consulter en cas d\'effets indésirables.');
                        $ordonnance->setConsultation($consultation);
                        $consultation->setOrdonnance($ordonnance); 
                        $manager->persist($ordonnance);

                        // 1 ou 2 prescriptions par ordonnance
                        $nbPrescriptions = rand(1, 2);
                        $medicamentsChoisis = array_rand($medicaments, $nbPrescriptions);
                        if (!is_array($medicamentsChoisis)) {
                            $medicamentsChoisis = [$medicamentsChoisis];
                        }

                        foreach ($medicamentsChoisis as $medIndex) {
                            $prescription = new Prescription();
                            $prescription->setPosologie('1 comprimé matin et soir');
                            $prescription->setDureeJours([5, 7, 10, 30][array_rand([5, 7, 10, 30])]);
                            $prescription->setFrequence('Toutes les 12 heures');
                            $prescription->setOrdonnance($ordonnance);
                            $prescription->setMedicament($medicaments[$medIndex]);
                            $manager->persist($prescription);
                        }
                    }
                }
            }
        }

        $manager->flush();
    }
}