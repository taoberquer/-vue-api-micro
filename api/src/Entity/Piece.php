<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\CreateMediaObjectAction;
use App\Controller\CreatePieceAction;
use App\Repository\PieceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use ApiPlatform\Core\Annotation\ApiProperty;


#[ORM\Entity(repositoryClass: PieceRepository::class)]
#[Vich\Uploadable]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['pieces:read']],
        ],
        'post' => [
            'input_formats' => [
                'multipart' => ['multipart/form-data'],
            ],
            'controller' => CreatePieceAction::class,
            'security' => 'is_granted("ROLE_ADMIN")',
            'denormalization_context' => ['groups' => ['piece:write']],
            'normalization_context' => ['groups' => ['piece:read']]
        ]
    ],
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['piece:read']]
        ],
        'put' => [
            'security' => 'is_granted("ROLE_ADMIN")',
            'denormalization_context' => ['groups' => ['piece:write']],
            'normalization_context' => ['groups' => ['piece:read']]
        ],
        'delete' => [
            'security' => 'is_granted("ROLE_ADMIN")'
        ]
    ],
    denormalizationContext: ['groups' => ['piece:write']],
    normalizationContext: ['groups' => ['piece:read', 'pieces:read']],
)]
/**
 * @Vich\Uploadable
 */
class Piece
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    /**
     * @Groups({"piece:read", "pieces:read", "category:read"})
     */
    private $id;

    #[ORM\Column(type: 'integer')]
    /**
     * @Groups({"piece:read", "piece:write"})
     */
    private $quality;

    #[ORM\Column(type: 'string', length: 255)]
    /**
     * @Groups({"piece:read", "piece:write"})
     */
    private $color;

    #[ORM\Column(type: 'string', length: 255)]
    /**
     * @Groups({"piece:read", "pieces:read", "piece:write"})
     */
    private $size;

    #[ORM\Column(type: 'string', length: 255)]
    /**
     * @Groups({"piece:read", "piece:write"})
     */
    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    /**
     * @Groups({"piece:read", "piece:write", "pieces:read", "category:read"})
     */
    private $title;

    #[ORM\Column(type: 'string', length: 255)]
    /**
     * @Groups({"piece:read", "piece:write"})
     */
    private $damage;

    #[ORM\Column(type: 'boolean')]
    /**
     * @Groups({"piece:read", "piece:write", "pieces:read", "category:read"})
     */
    private $sold;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'pieces')]
    #[ORM\JoinColumn(nullable: false)]
    /**
     * @Groups({"piece:read", "piece:write"})
     */
    private $category;

    /**
     * @Groups ({"piece:read", "category:read"})
     */
    public ?string $contentUrl = null;

    /**
     * @Vich\UploadableField(mapping="media_object", fileNameProperty="filePath")
     */
    #[Vich\UploadableField(mapping: "media_object", fileNameProperty: "filePath")]
    #[Assert\NotNull(groups: ['piece:write'])]
    /**
     * @Groups ({"piece:write"})
     */
    public ?File $file = null;

    /**
     * @ORM\Column(nullable=true)
     */
    #[ORM\Column(nullable: true)]
    public ?string $filePath = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuality(): ?int
    {
        return $this->quality;
    }

    public function setQuality(int $quality): self
    {
        $this->quality = $quality;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDamage(): ?string
    {
        return $this->damage;
    }

    public function setDamage(string $damage): self
    {
        $this->damage = $damage;

        return $this;
    }

    public function getSold(): ?bool
    {
        return $this->sold;
    }

    public function setSold(bool $sold): self
    {
        $this->sold = $sold;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
