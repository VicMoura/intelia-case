<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $full_name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birth_date = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Address::class, orphanRemoval: true)]
    private Collection $addresses;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Phones::class, orphanRemoval: true)]
    private Collection $phones;

    #[ORM\OneToOne(mappedBy: 'user_id', cascade: ['persist', 'remove'])]
    private ?UserStep $userStep = null;

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
        $this->phones = new ArrayCollection();
    }

    public function detail(): array
    {
        return [
            'id' => $this->getId(),
            'full_name' => $this->getFullName(),
            'birth_date' => $this->getBirthDate()?->format('Y-m-d'),
            'created_at' => $this->getCreatedAt()?->format('Y-m-d H:i:s'),
            'updated_at' => $this->getUpdatedAt()?->format('Y-m-d H:i:s'),
            'addresses' => $this->getAddresses()->map(function ($address) {
                return $address->toArray(); // Certifique-se de que Address também tenha o método toArray()
            })->toArray(),
            'phones' => $this->getPhones()->map(function ($phone) {
                return $phone->toArray(); // Certifique-se de que Phones também tenha o método toArray()
            })->toArray(),
        ];
    
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->full_name;
    }

    public function setFullName(string $full_name): static
    {
        $this->full_name = $full_name;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birth_date;
    }

    public function setBirthDate(\DateTimeInterface $birth_date): static
    {
        $this->birth_date = $birth_date;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection<int, Address>
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    public function addAddress(Address $address): static
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses->add($address);
            $address->setUserId($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): static
    {
        if ($this->addresses->removeElement($address)) {
            if ($address->getUserId() === $this) {
                $address->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Phones>
     */
    public function getPhones(): Collection
    {
        return $this->phones;
    }

    public function addPhone(Phones $phone): static
    {
        if (!$this->phones->contains($phone)) {
            $this->phones->add($phone);
            $phone->setUserId($this);
        }

        return $this;
    }

    public function removePhone(Phones $phone): static
    {
        if ($this->phones->removeElement($phone)) {
            // set the owning side to null (unless already changed)
            if ($phone->getUserId() === $this) {
                $phone->setUserId(null);
            }
        }

        return $this;
    }

    public function getUserStep(): ?UserStep
    {
        return $this->userStep;
    }

    public function setUserStep(?UserStep $userStep): static
    {
        // unset the owning side of the relation if necessary
        if ($userStep === null && $this->userStep !== null) {
            $this->userStep->setUserId(null);
        }

        // set the owning side of the relation if necessary
        if ($userStep !== null && $userStep->getUserId() !== $this) {
            $userStep->setUserId($this);
        }

        $this->userStep = $userStep;

        return $this;
    }
}
