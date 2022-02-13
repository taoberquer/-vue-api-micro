<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['categories:read']],
        ],
        'post' => [
            'security' => 'is_granted("ROLE_ADMIN")',
            'denormalization_context' => ['groups' => ['category:write']],
            'normalization_context' => ['groups' => ['category:read']],
        ],
    ],
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => 'category:read'],
        ],
        'put' => [
            'security' => 'is_granted("ROLE_ADMIN")',
            'normalization_context' => ['groups' => 'category:read'],
            'denormalization_context' => ['groups' => 'category:write'],
        ],
        'delete' => ['security' => 'is_granted("ROLE_ADMIN")'],
    ],
    denormalizationContext: [
        "groups" => ["category:write"]
    ],
    normalizationContext: [
        "groups" => ["category:read", "categories:read"]
    ]
)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    /**
     * @Groups ({"category:read", "categories:read"})
     */
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    /**
     * @Groups ({"category:read", "category:write", "categories:read"})
     */
    private $name;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Piece::class)]
    /**
     * @Groups ({"category:read"})
     */
    private $pieces;

    public function __construct()
    {
        $this->pieces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Piece[]
     */
    public function getPieces(): Collection
    {
        return $this->pieces;
    }

    public function addPiece(Piece $piece): self
    {
        if (!$this->pieces->contains($piece)) {
            $this->pieces[] = $piece;
            $piece->setCategory($this);
        }

        return $this;
    }

    public function removePiece(Piece $piece): self
    {
        if ($this->pieces->removeElement($piece)) {
            // set the owning side to null (unless already changed)
            if ($piece->getCategory() === $this) {
                $piece->setCategory(null);
            }
        }

        return $this;
    }
}
