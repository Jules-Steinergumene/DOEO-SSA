<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;

#[ORM\Entity(repositoryClass: MissionRepository::class)]
#[ApiResource(normalizationContext: ["enable_max_depth" => true])]
#[Get(normalizationContext: ['groups' => [

]])]
#[GetCollection(normalizationContext: [
    'mission:preview',

])]
#[Post(denormalizationContext: ['groups' => [Mission::MISSION_POST_SERIALIZE_GROUP]])]
class Mission
{

    const MISSION_PREVIEW_SERIALIZE_GROUP = 'mission:preview';
    const MISSION_DETAILS_SERIALIZE_GROUP = 'mission:details';
    const MISSION_POST_SERIALIZE_GROUP = 'mission:details';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        Mission::MISSION_DETAILS_SERIALIZE_GROUP,
        Mission::MISSION_PREVIEW_SERIALIZE_GROUP,
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        Mission::MISSION_DETAILS_SERIALIZE_GROUP,
        Mission::MISSION_PREVIEW_SERIALIZE_GROUP,
    ])]
    private ?string $name = null;

    #[ORM\Column(type: 'string', enumType: DangerLevelEnum::class)]
    #[Groups([
        Mission::MISSION_DETAILS_SERIALIZE_GROUP,
        Mission::MISSION_PREVIEW_SERIALIZE_GROUP,
        Mission::MISSION_POST_SERIALIZE_GROUP,
    ])]
    private ?DangerLevelEnum $danger = null;

    #[ORM\Column(enumType: MissionStatusEnum::class, nullable: true)]
    #[Groups([
        Mission::MISSION_DETAILS_SERIALIZE_GROUP,
    ])]
    private ?MissionStatusEnum $status = null;

    #[Groups([
        Mission::MISSION_DETAILS_SERIALIZE_GROUP,
        Mission::MISSION_PREVIEW_SERIALIZE_GROUP,
        Mission::MISSION_POST_SERIALIZE_GROUP,
    ])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups([
        Mission::MISSION_DETAILS_SERIALIZE_GROUP,
        Mission::MISSION_POST_SERIALIZE_GROUP,
    ])]
    private ?string $objectives = null;

    #[Groups([
        Mission::MISSION_DETAILS_SERIALIZE_GROUP,
        Mission::MISSION_POST_SERIALIZE_GROUP,
    ])]
    private ?\DateTimeImmutable $startDate = null;

    #[ORM\Column(nullable: true)]
    #[Groups([
        Mission::MISSION_DETAILS_SERIALIZE_GROUP,
    ])]
    private ?\DateTimeImmutable $endDate = null;

    #[ORM\ManyToOne(inversedBy: 'missions')]
    #[ORM\JoinColumn(onDelete: 'SET NULL')]
    #[Groups([
        Mission::MISSION_DETAILS_SERIALIZE_GROUP,
        Mission::MISSION_PREVIEW_SERIALIZE_GROUP,
        Mission::MISSION_POST_SERIALIZE_GROUP,
    ])]
    #[MaxDepth(1)]
    private ?Country $Country = null;

    /**
     * @var Collection<int, Agent>
     */
    #[ORM\ManyToMany(targetEntity: Agent::class, mappedBy: 'missions')]
    #[Groups([
        Mission::MISSION_DETAILS_SERIALIZE_GROUP,
        Mission::MISSION_POST_SERIALIZE_GROUP,
    ])]
    #[MaxDepth(1)]
    private Collection $agents;
    function __tostring(): string
    {
        return $this->name ?? '';
    }
    public function __construct()
    {
        $this->agents = new ArrayCollection();
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

    public function getDanger(): ?DangerLevelEnum
    {
        return $this->danger;
    }

    public function setDanger(DangerLevelEnum $danger): static
    {
        $this->danger = $danger;

        return $this;
    }

    public function getStatus(): ?MissionStatusEnum
    {
        return $this->status;
    }

    public function setStatus(MissionStatusEnum $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getObjectives(): ?string
    {
        return $this->objectives;
    }

    public function setObjectives(string $objectives): static
    {
        $this->objectives = $objectives;

        return $this;
    }

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeImmutable $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeImmutable $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->Country;
    }

    public function setCountry(?Country $Country): static
    {
        $this->Country = $Country;

        return $this;
    }
    function isCurrent(): bool
    {
        return is_null($this->getStatus());
    }

    /**
     * @return Collection<int, Agent>
     */
    public function getAgents(): Collection
    {
        return $this->agents;
    }

    #[Groups([
        Mission::MISSION_PREVIEW_SERIALIZE_GROUP,
    ])]
    public function getAgentsCount(): int
    {
        return count($this->getAgents());
    }

    public function addAgent(Agent $agent): static
    {
        if ($this->isCurrent() && $agent->getInfiltratedCountry()->getId() !== $this->getCountry()->getId()) {
            throw new \InvalidArgumentException(
                "L\'agent $agent est infiltré dans " . $agent->getInfiltratedCountry() . ". Pour être assigné à la mission " . $this->getName() . " il doit être infiltré dans " . $this->getCountry() . '.'
            );
        }
        if (!$this->agents->contains($agent)) {
            $this->agents->add($agent);
            $agent->addMission($this);
        }
        return $this;
    }

    public function removeAgent(Agent $agent): static
    {
        if ($this->agents->removeElement($agent)) {
            $agent->removeMission($this);
        }
        return $this;
    }
}
