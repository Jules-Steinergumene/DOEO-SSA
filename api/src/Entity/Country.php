<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
#[ApiResource(normalizationContext: ["enable_max_depth" => true])]
#[Get(normalizationContext: ['groups' => [Country::COUNTRY_DETAILS_SERIALIZE_GROUP, Agent::AGENT_PREVIEW_SERIALIZE_GROUP, Mission::MISSION_PREVIEW_SERIALIZE_GROUP]])]
#[GetCollection(normalizationContext: ['groups' => [Country::COUNTRY_PREVIEW_SERIALIZE_GROUP, Agent::AGENT_PREVIEW_SERIALIZE_GROUP]])]
class Country
{

    const COUNTRY_PREVIEW_SERIALIZE_GROUP = 'country:preview';
    const COUNTRY_DETAILS_SERIALIZE_GROUP = 'country:details';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        Country::COUNTRY_DETAILS_SERIALIZE_GROUP,
        Country::COUNTRY_PREVIEW_SERIALIZE_GROUP,
    ])]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    #[Groups([
        Country::COUNTRY_DETAILS_SERIALIZE_GROUP,
        Country::COUNTRY_PREVIEW_SERIALIZE_GROUP,
    ])]
    private ?string $name = null;

    /**
     * @var Collection<int, Mission>
     */
    #[ORM\OneToMany(targetEntity: Mission::class, mappedBy: 'Country')]
    #[Groups([Country::COUNTRY_DETAILS_SERIALIZE_GROUP,])]
    #[MaxDepth(1)]
    private Collection $missions;

    /**
     * @var Collection<int, Agent>
     */
    #[ORM\OneToMany(targetEntity: Agent::class, mappedBy: 'infiltratedCountry')]
    #[Groups([Country::COUNTRY_DETAILS_SERIALIZE_GROUP,])]
    #[MaxDepth(1)]
    private Collection $infiltratedAgents;

    #[ORM\OneToOne]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    #[Groups([
        Country::COUNTRY_DETAILS_SERIALIZE_GROUP,
    ])]
    #[MaxDepth(1)]
    private ?Agent $cellLeader = null;

    function __tostring(): string
    {
        return $this->name ?? '';
    }
    public function __construct()
    {
        $this->missions = new ArrayCollection();
        $this->infiltratedAgents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    #[Groups([
        Country::COUNTRY_DETAILS_SERIALIZE_GROUP,
        Country::COUNTRY_PREVIEW_SERIALIZE_GROUP,
    ])]
    public function getDanger(): ?DangerLevelEnum
    {
        if ($this->missions->isEmpty()) {
            return null;
        }

        $max = null;
        foreach ($this->missions as $mission) {
            $missionDanger = $mission->getDanger();
            if ($missionDanger === null) {
                continue;
            }

            if ($max === null) {
                $max = $missionDanger;
                if ($max === DangerLevelEnum::CRITICAL) {
                    break;
                }
                continue;
            }

            $max = DangerLevelEnum::max($max, $missionDanger);

            if ($max === DangerLevelEnum::CRITICAL) {
                break;
            }
        }

        return $max;
    }

    /**
     * @return Collection<int, Mission>
     */
    public function getMissions(): Collection
    {
        return $this->missions;
    }

    /**
     * @return array<Mission>
     */
    public function getCurrentsMission(): array
    {
        return array_filter($this->getMissions()->toArray(), function (Mission $mission) {
            return $mission->isCurrent();
        });
    }

    #[Groups([Country::COUNTRY_PREVIEW_SERIALIZE_GROUP,])]
    public function getCurrentsMissionCount(): int
    {
        return count($this->getCurrentsMission());
    }

    public function addMission(Mission $mission): static
    {
        if (!$this->missions->contains($mission)) {
            $this->missions->add($mission);
            $mission->setCountry($this);
        }

        return $this;
    }

    public function removeMission(Mission $mission): static
    {
        if ($this->missions->removeElement($mission)) {
            // set the owning side to null (unless already changed)
            if ($mission->getCountry() === $this) {
                $mission->setCountry(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Agent>
     */
    public function getInfiltratedAgents(): Collection
    {
        return $this->infiltratedAgents;
    }

    #[Groups([Country::COUNTRY_PREVIEW_SERIALIZE_GROUP,])]
    public function getInfiltratedAgentsCount(): int
    {
        return count($this->getInfiltratedAgents());
    }

    public function getCellLeader(): ?Agent
    {
        return $this->cellLeader;
    }

    public function setCellLeader(?Agent $cellLeader): static
    {
        $this->cellLeader = $cellLeader;

        return $this;
    }

}
