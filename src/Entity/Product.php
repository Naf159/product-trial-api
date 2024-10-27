<?php

namespace App\Entity;

use App\Enum\InventoryStatus;
use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Nullable;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['product:read'])]
    private int $id;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Groups(['product:read', 'product:write'])]
    private string $code;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Groups(['product:read', 'product:write'])]
    private string $name;

    #[ORM\Column(type: 'text')]
    #[Assert\Type('string')]
    #[Groups(['product:read', 'product:write'])]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Type('string')]
    #[Groups(['product:read', 'product:write'])]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Groups(['product:read', 'product:write'])]
    private string $category;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Type('float')]
    #[Groups(['product:read', 'product:write'])]
    private float $price;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    #[Groups(['product:read', 'product:write'])]
    private int $quantity;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Groups(['product:read', 'product:write'])]
    private string $internalReference;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    #[Groups(['product:read', 'product:write'])]
    private int $shellId;

    #[ORM\Column(enumType: InventoryStatus::class)]
    #[Assert\NotBlank]
    #[Assert\Type(InventoryStatus::class)]
    #[Groups(['product:read', 'product:write'])]
    private InventoryStatus $inventoryStatus;

    #[ORM\Column(nullable: true)]
    #[Assert\Type('integer')]
    #[Groups(['product:read', 'product:write'])]
    private ?int $rating = null;

    #[ORM\Column]
    #[Groups(['product:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['product:read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getInternalReference(): ?string
    {
        return $this->internalReference;
    }

    public function setInternalReference(string $internalReference): static
    {
        $this->internalReference = $internalReference;

        return $this;
    }

    public function getShellId(): ?int
    {
        return $this->shellId;
    }

    public function setShellId(int $shellId): static
    {
        $this->shellId = $shellId;

        return $this;
    }

    public function getInventoryStatus(): ?InventoryStatus
    {
        return $this->inventoryStatus;
    }

    public function setInventoryStatus(InventoryStatus $inventoryStatus): static
    {
        $this->inventoryStatus = $inventoryStatus;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
