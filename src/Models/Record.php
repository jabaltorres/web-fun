<?php
declare(strict_types=1);

namespace Fivetwofive\KrateCMS\Models;

class Record
{
    // Properties representing the attributes of a record
    private int $id; // Unique identifier for the record
    private string $title; // Title of the record
    private string $artist; // Artist of the record
    private int $releaseYear; // Year the record was released
    private ?string $description; // Description of the record (nullable)
    private ?string $frontImage; // URL of the front image (nullable)
    private ?string $backImage; // URL of the back image (nullable)
    private ?string $audioFileUrl; // URL of the audio file (nullable)
    private ?string $purchaseLink; // Link to purchase the record (nullable)
    private ?string $genre; // Genre of the record (nullable)
    private ?string $label; // Record label (nullable)
    private ?string $catalogNumber; // Catalog number (nullable)
    private ?string $format; // Format of the record (e.g., vinyl, CD) (nullable)
    private ?string $speed; // Speed of the record (e.g., 33 RPM) (nullable)
    private ?int $bpm; // Beats per minute (nullable)
    private ?string $condition; // Condition of the record (nullable)
    private ?string $purchaseDate; // Date of purchase (nullable)
    private ?float $purchasePrice; // Price at which the record was purchased (nullable)
    private ?string $notes; // Additional notes about the record (nullable)
    private string $createdAt; // Timestamp of when the record was created
    private ?string $updatedAt; // Timestamp of when the record was last updated (nullable)

    // Constructor to initialize the record properties
    public function __construct(
        int $id = 0,
        string $title = '',
        string $artist = '',
        int $releaseYear = 0,
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
        // Assign values to the properties
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

    // Getters for accessing private properties

    /**
     * Get the ID of the record
     * 
     * @return int The ID of the record
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the title of the record
     * 
     * @return string The title of the record
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Get the artist of the record
     * 
     * @return string The artist of the record
     */
    public function getArtist(): string
    {
        return $this->artist;
    }

    /**
     * Get the release year of the record
     * 
     * @return int The release year of the record
     */
    public function getReleaseYear(): int
    {
        return $this->releaseYear;
    }

    /**
     * Get the front image URL of the record
     * 
     * @return string|null The front image URL or null if not set
     */
    public function getFrontImage(): ?string
    {
        return $this->frontImage;
    }

    /**
     * Get the back image URL of the record
     * 
     * @return string|null The back image URL or null if not set
     */
    public function getBackImage(): ?string
    {
        return $this->backImage;
    }

    /**
     * Get the audio file URL of the record
     * 
     * @return string|null The audio file URL or null if not set
     */
    public function getAudioFileUrl(): ?string
    {
        return $this->audioFileUrl;
    }

    /**
     * Get the purchase link of the record
     * 
     * @return string|null The purchase link or null if not set
     */
    public function getPurchaseLink(): ?string
    {
        return $this->purchaseLink;
    }

    /**
     * Get the genre of the record
     * 
     * @return string|null The genre or null if not set
     */
    public function getGenre(): ?string
    {
        return $this->genre;
    }

    /**
     * Get the label of the record
     * 
     * @return string|null The label or null if not set
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * Get the catalog number of the record
     * 
     * @return string|null The catalog number or null if not set
     */
    public function getCatalogNumber(): ?string
    {
        return $this->catalogNumber;
    }

    /**
     * Get the format of the record
     * 
     * @return string|null The format or null if not set
     */
    public function getFormat(): ?string
    {
        return $this->format;
    }

    /**
     * Get the speed of the record
     * 
     * @return string|null The speed or null if not set
     */
    public function getSpeed(): ?string
    {
        return $this->speed;
    }

    /**
     * Get the BPM of the record
     * 
     * @return int|null The BPM or null if not set
     */
    public function getBpm(): ?int
    {
        return $this->bpm;
    }

    /**
     * Get the condition of the record
     * 
     * @return string|null The condition or null if not set
     */
    public function getCondition(): ?string
    {
        return $this->condition;
    }

    /**
     * Get the purchase date of the record
     * 
     * @return string|null The purchase date or null if not set
     */
    public function getPurchaseDate(): ?string
    {
        return $this->purchaseDate;
    }

    /**
     * Get the purchase price of the record
     * 
     * @return float|null The purchase price or null if not set
     */
    public function getPurchasePrice(): ?float
    {
        return $this->purchasePrice;
    }

    /**
     * Get additional notes about the record
     * 
     * @return string|null The notes or null if not set
     */
    public function getNotes(): ?string
    {
        return $this->notes;
    }

    /**
     * Get the creation timestamp of the record
     * 
     * @return string The creation timestamp
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * Get the last updated timestamp of the record
     * 
     * @return string|null The last updated timestamp or null if not set
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    // Setters for modifying private properties

    /**
     * Set the title of the record
     * 
     * @param string $title The title to set
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Set the artist of the record
     * 
     * @param string $artist The artist to set
     */
    public function setArtist(string $artist): void
    {
        $this->artist = $artist;
    }

    /**
     * Set the release year of the record
     * 
     * @param int $releaseYear The release year to set
     */
    public function setReleaseYear(int $releaseYear): void
    {
        $this->releaseYear = $releaseYear;
    }

    /**
     * Set the description of the record
     * 
     * @param string|null $description The description to set (nullable)
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * Set the front image URL of the record
     * 
     * @param string|null $frontImage The front image URL to set (nullable)
     */
    public function setFrontImage(?string $frontImage): void
    {
        $this->frontImage = $frontImage;
    }

    /**
     * Set the back image URL of the record
     * 
     * @param string|null $backImage The back image URL to set (nullable)
     */
    public function setBackImage(?string $backImage): void
    {
        $this->backImage = $backImage;
    }

    /**
     * Set the audio file URL of the record
     * 
     * @param string|null $audioFileUrl The audio file URL to set (nullable)
     */
    public function setAudioFileUrl(?string $audioFileUrl): void
    {
        $this->audioFileUrl = $audioFileUrl;
    }

    /**
     * Set the purchase link of the record
     * 
     * @param string|null $purchaseLink The purchase link to set (nullable)
     */
    public function setPurchaseLink(?string $purchaseLink): void
    {
        $this->purchaseLink = $purchaseLink;
    }

    /**
     * Set the genre of the record
     * 
     * @param string|null $genre The genre to set (nullable)
     */
    public function setGenre(?string $genre): void
    {
        $this->genre = $genre;
    }

    /**
     * Set the label of the record
     * 
     * @param string|null $label The label to set (nullable)
     */
    public function setLabel(?string $label): void
    {
        $this->label = $label;
    }

    /**
     * Set the catalog number of the record
     * 
     * @param string|null $catalogNumber The catalog number to set (nullable)
     */
    public function setCatalogNumber(?string $catalogNumber): void
    {
        $this->catalogNumber = $catalogNumber;
    }

    /**
     * Set the format of the record
     * 
     * @param string|null $format The format to set (nullable)
     */
    public function setFormat(?string $format): void
    {
        $this->format = $format;
    }

    /**
     * Set the speed of the record
     * 
     * @param string|null $speed The speed to set (nullable)
     */
    public function setSpeed(?string $speed): void
    {
        $this->speed = $speed;
    }

    /**
     * Set the BPM of the record
     * 
     * @param int|null $bpm The BPM to set (nullable)
     */
    public function setBpm(?int $bpm): void
    {
        $this->bpm = $bpm;
    }

    /**
     * Set the condition of the record
     * 
     * @param string|null $condition The condition to set (nullable)
     */
    public function setCondition(?string $condition): void
    {
        $this->condition = $condition;
    }

    /**
     * Set the purchase date of the record
     * 
     * @param string|null $purchaseDate The purchase date to set (nullable)
     */
    public function setPurchaseDate(?string $purchaseDate): void
    {
        $this->purchaseDate = $purchaseDate;
    }

    /**
     * Set the purchase price of the record
     * 
     * @param float|null $purchasePrice The purchase price to set (nullable)
     */
    public function setPurchasePrice(?float $purchasePrice): void
    {
        $this->purchasePrice = $purchasePrice;
    }

    /**
     * Set additional notes about the record
     * 
     * @param string|null $notes The notes to set (nullable)
     */
    public function setNotes(?string $notes): void
    {
        $this->notes = $notes;
    }

    /**
     * Set the last updated timestamp of the record
     * 
     * @param string|null $updatedAt The updated timestamp to set (nullable)
     */
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
        // Create a new Record instance using data from the array
        $record = new self(
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
        
        return $record; // Return the newly created Record instance
    }

    /**
     * Converts the record to an array representation
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        // Convert the Record object properties to an associative array
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

    /**
     * Find all records, optionally filtered by a search term
     * 
     * @param string|null $searchTerm Optional search term for filtering records
     * @return Record[] Array of Record objects
     */
    public function findAll(?string $searchTerm = null): array
    {
        // Implementation of findAll method
        // This method should return an array of records matching the search term
        return [];
    }
} 