<?php
declare(strict_types=1);

namespace Fivetwofive\KrateCMS\Models;

class Record
{
    private int $id;
    private string $title;
    private string $artist;
    private int $releaseYear;
    private ?string $description;
    private ?string $frontImage;
    private ?string $backImage;
    private ?string $audioFileUrl;
    private ?string $purchaseLink;
    private ?string $genre;
    private ?string $label;
    private ?string $catalogNumber;
    private ?string $format;
    private ?string $speed;
    private ?int $bpm;
    private ?string $condition;
    private ?string $purchaseDate;
    private ?float $purchasePrice;
    private ?string $notes;
    private string $createdAt;
    private ?string $updatedAt;

    public function __construct(
        int $id,
        string $title,
        string $artist,
        int $releaseYear,
        ?string $description = null,
        ?string $frontImage = null,
        ?string $backImage = null,
        ?string $audioFileUrl = null,
        ?string $purchaseLink = null,
        ?string $genre = null,
        ?string $label = null,
        ?string $catalogNumber = null,
        ?string $format = null,
        ?string $speed = null,
        ?int $bpm = null,
        ?string $condition = null,
        ?string $purchaseDate = null,
        ?float $purchasePrice = null,
        ?string $notes = null,
        string $createdAt = '',
        ?string $updatedAt = null
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->artist = $artist;
        $this->releaseYear = $releaseYear;
        $this->description = $description;
        $this->frontImage = $frontImage;
        $this->backImage = $backImage;
        $this->audioFileUrl = $audioFileUrl;
        $this->purchaseLink = $purchaseLink;
        $this->genre = $genre;
        $this->label = $label;
        $this->catalogNumber = $catalogNumber;
        $this->format = $format;
        $this->speed = $speed;
        $this->bpm = $bpm;
        $this->condition = $condition;
        $this->purchaseDate = $purchaseDate;
        $this->purchasePrice = $purchasePrice;
        $this->notes = $notes;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getArtist(): string
    {
        return $this->artist;
    }

    public function getReleaseYear(): int
    {
        return $this->releaseYear;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getFrontImage(): ?string
    {
        return $this->frontImage;
    }

    public function getBackImage(): ?string
    {
        return $this->backImage;
    }

    public function getAudioFileUrl(): ?string
    {
        return $this->audioFileUrl;
    }

    public function getPurchaseLink(): ?string
    {
        return $this->purchaseLink;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getCatalogNumber(): ?string
    {
        return $this->catalogNumber;
    }

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function getSpeed(): ?string
    {
        return $this->speed;
    }

    public function getBpm(): ?int
    {
        return $this->bpm;
    }

    public function getCondition(): ?string
    {
        return $this->condition;
    }

    public function getPurchaseDate(): ?string
    {
        return $this->purchaseDate;
    }

    public function getPurchasePrice(): ?float
    {
        return $this->purchasePrice;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setArtist(string $artist): void
    {
        $this->artist = $artist;
    }

    public function setReleaseYear(int $releaseYear): void
    {
        $this->releaseYear = $releaseYear;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setFrontImage(?string $frontImage): void
    {
        $this->frontImage = $frontImage;
    }

    public function setBackImage(?string $backImage): void
    {
        $this->backImage = $backImage;
    }

    public function setAudioFileUrl(?string $audioFileUrl): void
    {
        $this->audioFileUrl = $audioFileUrl;
    }

    public function setPurchaseLink(?string $purchaseLink): void
    {
        $this->purchaseLink = $purchaseLink;
    }

    public function setGenre(?string $genre): void
    {
        $this->genre = $genre;
    }

    public function setLabel(?string $label): void
    {
        $this->label = $label;
    }

    public function setCatalogNumber(?string $catalogNumber): void
    {
        $this->catalogNumber = $catalogNumber;
    }

    public function setFormat(?string $format): void
    {
        $this->format = $format;
    }

    public function setSpeed(?string $speed): void
    {
        $this->speed = $speed;
    }

    public function setBpm(?int $bpm): void
    {
        $this->bpm = $bpm;
    }

    public function setCondition(?string $condition): void
    {
        $this->condition = $condition;
    }

    public function setPurchaseDate(?string $purchaseDate): void
    {
        $this->purchaseDate = $purchaseDate;
    }

    public function setPurchasePrice(?float $purchasePrice): void
    {
        $this->purchasePrice = $purchasePrice;
    }

    public function setNotes(?string $notes): void
    {
        $this->notes = $notes;
    }

    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Creates a Record instance from an array of data
     *
     * @param array<string, mixed> $data Database record data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            (int) ($data['record_id'] ?? 0),
            (string) ($data['title'] ?? ''),
            (string) ($data['artist'] ?? ''),
            (int) ($data['release_year'] ?? 0),
            $data['description'] ?? null,
            $data['front_image'] ?? null,
            $data['back_image'] ?? null,
            $data['audio_file_url'] ?? null,
            $data['purchase_link'] ?? null,
            $data['genre'] ?? null,
            $data['label'] ?? null,
            $data['catalog_number'] ?? null,
            $data['format'] ?? null,
            $data['speed'] ?? null,
            isset($data['bpm']) ? (int) $data['bpm'] : null,
            $data['condition'] ?? null,
            $data['purchase_date'] ?? null,
            isset($data['purchase_price']) ? (float) $data['purchase_price'] : null,
            $data['notes'] ?? null,
            (string) ($data['created_at'] ?? date('Y-m-d H:i:s')),
            $data['updated_at'] ?? null
        );
    }

    /**
     * Converts the record to an array representation
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'record_id' => $this->id,
            'title' => $this->title,
            'artist' => $this->artist,
            'release_year' => $this->releaseYear,
            'description' => $this->description,
            'front_image' => $this->frontImage,
            'back_image' => $this->backImage,
            'audio_file_url' => $this->audioFileUrl,
            'purchase_link' => $this->purchaseLink,
            'genre' => $this->genre,
            'label' => $this->label,
            'catalog_number' => $this->catalogNumber,
            'format' => $this->format,
            'speed' => $this->speed,
            'bpm' => $this->bpm,
            'condition' => $this->condition,
            'purchase_date' => $this->purchaseDate,
            'purchase_price' => $this->purchasePrice,
            'notes' => $this->notes,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt
        ];
    }
} 