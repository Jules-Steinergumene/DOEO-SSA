<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use App\Repository\AgentRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: AgentRepository::class)]
#[ApiResource(normalizationContext: ["enable_max_depth" => true])]
#[GetCollection(normalizationContext: ['groups' => [
    Agent::AGENT_PREVIEW_SERIALIZE_GROUP,
    Mission::MISSION_PREVIEW_SERIALIZE_GROUP,
    Country::COUNTRY_PREVIEW_SERIALIZE_GROUP]])]
#[Get(normalizationContext: ['groups' => [Agent::AGENT_DETAILS_SERIALIZE_GROUP, Mission::MISSION_PREVIEW_SERIALIZE_GROUP,Country::COUNTRY_PREVIEW_SERIALIZE_GROUP]])]
class Agent
{

    const AGENT_PREVIEW_SERIALIZE_GROUP = 'agent:preview';
    const AGENT_DETAILS_SERIALIZE_GROUP = 'agent:details';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        Agent::AGENT_DETAILS_SERIALIZE_GROUP,
        Agent::AGENT_PREVIEW_SERIALIZE_GROUP,
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        Agent::AGENT_DETAILS_SERIALIZE_GROUP,
        Agent::AGENT_PREVIEW_SERIALIZE_GROUP,
    ])]
    private ?string $codeName = null;

    #[ORM\Column]
    #[Groups([
        Agent::AGENT_DETAILS_SERIALIZE_GROUP,
    ])]

    private ?DateTimeImmutable $enrolementDate = null;

    function __tostring(): string
    {
        return $this->codeName ?? '';
    }

    #[ORM\Column(enumType: AgentStatusEnum::class)]
    #[Groups([
        Agent::AGENT_DETAILS_SERIALIZE_GROUP,
        Agent::AGENT_PREVIEW_SERIALIZE_GROUP,
    ])]
    private ?AgentStatusEnum $status = null;

    #[Groups([
        Agent::AGENT_DETAILS_SERIALIZE_GROUP,
    ])]
    #[ORM\ManyToOne(targetEntity: Country::class, inversedBy: 'infiltratedAgents')]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    #[MaxDepth(1)]
    private ?Country $infiltratedCountry = null;

    /**
     * @var Collection<int, Mission>
     */
    #[Groups([
        Agent::AGENT_DETAILS_SERIALIZE_GROUP,
    ])]
    #[ORM\ManyToMany(targetEntity: Mission::class, inversedBy: 'agents')]
    #[MaxDepth(1)]
    private Collection $missions;

    public function __construct()
    {
        $this->missions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeName(): ?string
    {
        return $this->codeName;
    }

    public function setCodeName(string $codeName): static
    {
        $this->codeName = $codeName;

        return $this;
    }

    #[Groups([
        Agent::AGENT_DETAILS_SERIALIZE_GROUP,
        Agent::AGENT_PREVIEW_SERIALIZE_GROUP,
    ])]
    public function getYearsOfExperience(): ?int
    {
        if ($this->enrolementDate === null) {
            return null;
        }
        return new DateTimeImmutable()
            ->diff($this->enrolementDate)
            ->y;
    }
    public function getStatus(): ?AgentStatusEnum
    {
        return $this->status;

    }

    public function setStatus(AgentStatusEnum $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getEnrolementDate(): ?DateTimeImmutable
    {
        return $this->enrolementDate;
    }

    public function setEnrolementDate(DateTimeImmutable $enrolementDate): static
    {
        $this->enrolementDate = $enrolementDate;

        return $this;
    }

    public function getInfiltratedCountry(): ?Country
    {
        return $this->infiltratedCountry;
    }

    public function setInfiltratedCountry(?Country $infiltratedCountry): static
    {
        $this->infiltratedCountry = $infiltratedCountry;

        return $this;
    }

    /**
     * @return Collection<int, Mission>
     */
    public function getMissions(): Collection
    {
        return $this->missions;
    }


    #[Groups([
        Agent::AGENT_DETAILS_SERIALIZE_GROUP,
    ])]
    public function getCurrentMission(): ?Mission
    {
        return array_find($this->getMissions()->toArray(), function (Mission $mission) {
            return $mission->isCurrent();
        });
    }

    public function addMission(Mission $mission): static
    {
        if ($mission->isCurrent() && $this->getStatus() !== AgentStatusEnum::AVAILABLE) {
            throw new \InvalidArgumentException(
                "L\'agent $this n'est pas disponnible, il ne peut pas être affecté à une nouvelle mission."
            );
        }

        if (!$this->missions->contains($mission)) {
            if ($mission->isCurrent()) {
                $this->setStatus(AgentStatusEnum::ON_MISSION);
            }
            $this->missions->add($mission);
        }

        return $this;
    }

    public function removeMission(Mission $mission): static
    {
        $this->missions->removeElement($mission);

        return $this;
    }
}
