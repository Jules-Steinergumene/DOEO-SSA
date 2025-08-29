<?php

namespace App\DataFixtures;

use App\Entity\Agent;
use App\Entity\Country;
use App\Entity\DangerLevelEnum;
use App\Entity\Mission;
use App\Entity\MissionStatusEnum;
use App\Entity\AgentStatusEnum;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class AppFixtures extends Fixture
{
    public function load(ObjectManager $em): void
    {
        // Agents (dates fixées pour une démo reproductible)
        $alpha = (new Agent())
            ->setCodeName('ALPHA')
            ->setEnrolementDate(new DateTimeImmutable('-5 years'))
            ->setStatus(AgentStatusEnum::AVAILABLE);

        $bravo = (new Agent())
            ->setCodeName('BRAVO')
            ->setEnrolementDate(new DateTimeImmutable('-3 years'))
            ->setStatus(AgentStatusEnum::AVAILABLE);

        $charlie = (new Agent())
            ->setCodeName('CHARLIE')
            ->setEnrolementDate(enrolementDate: new DateTimeImmutable('-18 months'))
            ->setStatus(AgentStatusEnum::AVAILABLE);

        // Countries
        $grandeTerre = new Country()
            ->setName('Grande Terre')
            ->setCellLeader($alpha);

        $solaris = new Country()
            ->setName('Solaris')
            ->setCellLeader($bravo);
        
            $alpha->setInfiltratedCountry($grandeTerre);
            $bravo->setInfiltratedCountry($grandeTerre);
            $charlie->setInfiltratedCountry($solaris);




        $m1 = (new Mission())
            ->setName('Amnésie')
            ->setDanger(DangerLevelEnum::HIGH)
            ->setStatus(MissionStatusEnum::SUCCESS)
            ->setDescription('Saboter le data center de la région des plaines, vous avez carte blanche.')
            ->setObjectives('Descturction du data center')
            ->setStartDate(new DateTimeImmutable('-2 months'))
            ->setEndDate(new DateTimeImmutable('-6 weeks'))
            ->setCountry($grandeTerre)
            ->addAgent($bravo)
            ->addAgent($alpha);

        $m2 = (new Mission())
            ->setName('Délivrance')
            ->setDanger(DangerLevelEnum::CRITICAL)
            ->setDescription('Extraire M. Devoli de la prison haute securité de Moudan. VOus pouvez passer par les le systeme de canalisation, le chef de cellule possede les plans, Attention les gardes sont lourdement armée.')
            ->setObjectives('Extraire M. Devoli')
            ->setStartDate(new DateTimeImmutable('-1 month'))
            ->setCountry($grandeTerre)
            ->addAgent($bravo);

        $m3 = (new Mission())
            ->setName('Parasite')
            ->setDanger(DangerLevelEnum::LOW)
            ->setStatus(MissionStatusEnum::SUCCESS)
            ->setDescription('Rencontrer M Harrise et le convaincre de ce joindre à nous. C\'est lui qui nous a contacté et nos enquête indique qu\'il est sûr')
            ->setObjectives('Faire de Harrisse une taupe.')
            ->setStartDate(new DateTimeImmutable('-3 weeks'))
            ->setEndDate(new DateTimeImmutable('-1 week'))
            ->setCountry($solaris)
            ->addAgent($charlie);

        $em->persist($alpha);
        $em->persist($bravo);
        $em->persist($charlie);
        $em->persist($grandeTerre);
        $em->persist($solaris);
        $em->persist($m1);
        $em->persist($m2);
        $em->persist($m3);

        $em->flush();
    }
}


