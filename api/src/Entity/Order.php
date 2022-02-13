<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\OrderController;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'security' => 'is_granted("ROLE_ADMIN")',
            'normalization_context' => ['groups' => ['orders:read']],
        ],
        'post' => [
            'denormalization_context' => ['groups' => ['order:write']],
            'normalization_context' => ['groups' => ['order:read']],
        ],
        'mine' => [
            'method' => 'GET',
            'path' => '/orders/mine',
            'controller' => OrderController::class,
            'security' => 'is_granted("ROLE_USER")',
            'normalization_context' => ['groups' => ['orders:read']],
        ],
        'confirm' => [
            'method' => 'POST',
            'path' => '/orders/confirm',
            'denormalization_context' => ['groups' => ['order:write']],
            'normalization_context' => ['groups' => ['order:read']],
        ],
    ],
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['order:read']],
        ],
        'put' => [
            'security' => 'is_granted("ROLE_ADMIN")',
            'denormalization_context' => ['groups' => ['order:write']],
            'normalization_context' => ['groups' => ['order:read']],
        ],
        'delete' => [
            'security' => 'is_granted("ROLE_ADMIN")',
        ],
    ],
    denormalizationContext: [
        'groups' => ['order:write']
    ],
    normalizationContext: [
        'groups' => ['order:read', 'orders:read']
    ]
)]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    /**
     * @Groups ({"order:read", "orders:read"})
     */
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    /**
     * @Groups ({"order:read", "order:write", "orders:read"})
     */
    private $status;

    #[ORM\Column(type: 'string', length: 255)]
    /**
     * @Groups ({"order:read", "order:write"})
     */
    private $address;

    #[ORM\Column(type: 'string', length: 255)]
    /**
     * @Groups ({"order:read", "order:write"})
     */
    private $zip_code;

    #[ORM\Column(type: 'string', length: 255)]
    /**
     * @Groups ({"order:read", "order:write"})
     */
    private $city;

    #[ORM\OneToMany(mappedBy: 'order_from', targetEntity: Piece::class)]
    /**
     * @Groups ({"order:read", "order:write"})
     */
    private $pieces;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    public function __construct()
    {
        $this->pieces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zip_code;
    }

    public function setZipCode(string $zip_code): self
    {
        $this->zip_code = $zip_code;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

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
            $piece->setOrderFrom($this);
        }

        return $this;
    }

    public function removePiece(Piece $piece): self
    {
        if ($this->pieces->removeElement($piece)) {
            // set the owning side to null (unless already changed)
            if ($piece->getOrderFrom() === $this) {
                $piece->setOrderFrom(null);
            }
        }

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
}
