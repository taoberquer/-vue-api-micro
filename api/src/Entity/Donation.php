<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DonationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DonationRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['donations:read']],
            'security' => 'is_granted("ROLE_ADMIN")',
        ],
        'post' => [
            'denormalization_context' => ['groups' => ['donation:write']],
            'normalization_context' => ['groups' => ['donation:read']],
        ],
        'mine' => [
            'method' => 'GET',
            'path' => '/donations/mine',
            'controller' => DonationController::class,
            'security' => 'is_granted("ROLE_USER")',
        ],
    ],
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['donation:read']],
        ],
        'patch' => [
            'denormalization_context' => ['groups' => ['donation:write']],
            'normalization_context' => ['groups' => ['donation:read']],
        ],
        'delete' => [
            'security' => 'is_granted("ROLE_ADMIN")',
        ]
    ],
    denormalizationContext: ['groups' => ['donation:write']],
    normalizationContext: ['groups' => ['donation:read', 'donations:read']],
)]
class Donation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    /**
     * @Groups ({"donation:read", "donations:read"})
     */
    private $id;

    #[ORM\ManyToMany(targetEntity: Category::class)]
    /**
     * @Groups ({"donation:read"})
     */
    private $Categories;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'donations')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\Column(type: 'string', length: 255)]
    /**
     * @Groups ({"donation:read", "donations:read"})
     */
    private $status;

    public function __construct()
    {
        $this->Categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->Categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->Categories->contains($category)) {
            $this->Categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->Categories->removeElement($category);

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
