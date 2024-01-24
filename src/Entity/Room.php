<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(
        message: 'You should enter a title.'
    )]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'The address must be at least {{ limit }} characters long',
        maxMessage: 'The address cannot be longer than {{ limit }} characters',
    )]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'The city must be at least {{ limit }} characters long',
        maxMessage: 'The city cannot be longer than {{ limit }} characters',
    )]
    #[ORM\Column(length: 50, nullable: true)]
    private ?string $city = null;

    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'The country must be at least {{ limit }} characters long',
        maxMessage: 'The country cannot be longer than {{ limit }} characters',
    )]
    #[ORM\Column(length: 50, nullable: true)]
    private ?string $country = null;

    #[Assert\Positive(
        message: 'The price cannot be negative or free.'
    )]
    #[Assert\NotBlank(
        message: 'You should enter a price.'
    )]
    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cover = '/images/room-cover.jpg';

    #[ORM\ManyToOne(inversedBy: 'rooms')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $host = null;

    #[ORM\OneToMany(mappedBy: 'rooms', targetEntity: Review::class, orphanRemoval: true)]
    private Collection $reviews;

    #[ORM\ManyToMany(targetEntity: Equipment::class, mappedBy: 'rooms')]
    private Collection $equipment;

    #[ORM\OneToMany(mappedBy: 'room', targetEntity: Booking::class, orphanRemoval: true)]
    private Collection $bookings;

    #[ORM\ManyToMany(targetEntity: Favorite::class, mappedBy: 'rooms')]
    private Collection $favorites;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->equipment = new ArrayCollection();
        $this->bookings = new ArrayCollection();
        $this->favorites = new ArrayCollection();
    }

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(?string $cover): static
    {
        $this->cover = $cover;

        return $this;
    }

    public function getHost(): ?User
    {
        return $this->host;
    }

    public function setHost(?User $host): static
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): static
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setRooms($this);
        }

        return $this;
    }

    public function removeReview(Review $review): static
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getRooms() === $this) {
                $review->setRooms(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Equipment>
     */
    public function getEquipment(): Collection
    {
        return $this->equipment;
    }

    public function addEquipment(Equipment $equipment): static
    {
        if (!$this->equipment->contains($equipment)) {
            $this->equipment->add($equipment);
            $equipment->addRoom($this);
        }

        return $this;
    }

    public function removeEquipment(Equipment $equipment): static
    {
        if ($this->equipment->removeElement($equipment)) {
            $equipment->removeRoom($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): static
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->setRoom($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): static
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getRoom() === $this) {
                $booking->setRoom(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Favorite>
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(Favorite $favorite): static
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites->add($favorite);
            $favorite->addRoom($this);
        }

        return $this;
    }

    public function removeFavorite(Favorite $favorite): static
    {
        if ($this->favorites->removeElement($favorite)) {
            $favorite->removeRoom($this);
        }

        return $this;
    }

    // Check if the room is already in the user's favorites
    public function isFavorite(User $user): bool
    {
        foreach ($this->favorites as $favorite) {
            if ($favorite->getTraveler() === $user) {
                return true;
            }
        }

        return false;
        // return $this->favorites->exists(fn (int $key, Favorite $favorite) => $favorite->getTraveler() === $user);
    }
}
