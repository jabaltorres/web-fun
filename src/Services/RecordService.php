<?php
declare(strict_types=1);

namespace Fivetwofive\KrateCMS\Services;

use Fivetwofive\KrateCMS\Core\Database\DatabaseConnection;
use Fivetwofive\KrateCMS\Models\Record;

class RecordService
{
    private DatabaseConnection $db;
    
    public function __construct(DatabaseConnection $db)
    {
        $this->db = $db;
    }
    
    /**
     * @param string|null $searchTerm
     * @return Record[]
     */
    public function findAll(?string $searchTerm = null): array
    {
        if ($searchTerm) {
            $stmt = $this->db->prepare(
                "SELECT * FROM vinyl_records 
                WHERE title LIKE ? OR artist LIKE ? 
                ORDER BY created_at DESC"
            );
            $searchPattern = '%' . $searchTerm . '%';
            $stmt->bind_param('ss', $searchPattern, $searchPattern);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            $result = $this->db->query(
                "SELECT * FROM vinyl_records ORDER BY created_at DESC"
            );
        }
        
        $records = [];
        while ($row = $result->fetch_assoc()) {
            $records[] = Record::fromArray($row);
        }
        
        return $records;
    }
    
    public function findById(int $id): ?Record
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM vinyl_records WHERE record_id = ? LIMIT 1"
        );
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            return Record::fromArray($row);
        }
        
        return null;
    }

    /**
     * Create a new record
     * 
     * @param array<string, mixed> $data Record data
     * @return Record
     * @throws \Exception if creation fails
     */
    public function create(array $data): Record
    {
        $sql = "INSERT INTO vinyl_records (
            title, artist, genre, release_year, label, 
            catalog_number, format, speed, `condition`, 
            purchase_date, purchase_price, notes, 
            front_image, back_image, purchase_link, 
            audio_file_url, bpm
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param(
            'ssssssssssdsssssi',
            $data['title'],
            $data['artist'],
            $data['genre'],
            $data['release_year'],
            $data['label'],
            $data['catalog_number'],
            $data['format'],
            $data['speed'],
            $data['condition'],
            $data['purchase_date'],
            $data['purchase_price'],
            $data['notes'],
            $data['front_image'],
            $data['back_image'],
            $data['purchase_link'],
            $data['audio_file_url'],
            $data['bpm']
        );

        if (!$stmt->execute()) {
            throw new \Exception("Failed to create record: " . $stmt->error);
        }

        $id = $stmt->insert_id;
        
        // Return the newly created record
        return $this->findById($id);
    }

    /**
     * Delete a record by ID
     * 
     * @param int $id Record ID to delete
     * @return bool True if deletion was successful
     * @throws \Exception if deletion fails
     */
    public function delete(int $id): bool
    {
        // First get the record to check if it exists and get image paths
        $record = $this->findById($id);
        if (!$record) {
            throw new \Exception("Record not found");
        }

        // Prepare and execute delete statement
        $stmt = $this->db->prepare("DELETE FROM vinyl_records WHERE record_id = ?");
        $stmt->bind_param('i', $id);

        if (!$stmt->execute()) {
            throw new \Exception("Failed to delete record: " . $stmt->error);
        }

        // Delete associated images if they exist
        if ($record->getFrontImage()) {
            $frontImagePath = __DIR__ . '/../../public/' . $record->getFrontImage();
            if (file_exists($frontImagePath)) {
                unlink($frontImagePath);
            }
        }

        if ($record->getBackImage()) {
            $backImagePath = __DIR__ . '/../../public/' . $record->getBackImage();
            if (file_exists($backImagePath)) {
                unlink($backImagePath);
            }
        }

        return true;
    }

    /**
     * Update a record
     * 
     * @param int $id Record ID to update
     * @param array<string, mixed> $data Updated record data
     * @return Record Updated record
     * @throws \Exception if update fails
     */
    public function update(int $id, array $data): Record
    {
        // First check if record exists
        $record = $this->findById($id);
        if (!$record) {
            throw new \Exception("Record not found");
        }

        $sql = "UPDATE vinyl_records SET 
            title = ?, artist = ?, genre = ?, release_year = ?, 
            label = ?, catalog_number = ?, format = ?, speed = ?, 
            `condition` = ?, purchase_date = ?, purchase_price = ?, 
            notes = ?, front_image = ?, back_image = ?, 
            purchase_link = ?, audio_file_url = ?, bpm = ?,
            updated_at = CURRENT_TIMESTAMP
            WHERE record_id = ?";

        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
        }

        // Required fields
        $title = $data['title'];
        $artist = $data['artist'];
        
        // Optional fields with defaults/null handling
        $genre = $data['genre'] ?? null;
        $releaseYear = $data['release_year'] ?? null;
        $label = $data['label'] ?? null;
        $catalogNumber = $data['catalog_number'] ?? null;
        $format = $data['format'] ?? null;
        $speed = $data['speed'] ?? null;
        $condition = $data['condition'] ?? null;
        $purchaseDate = $data['purchase_date'] ?? null;
        $purchasePrice = $data['purchase_price'] ?? null;
        $notes = $data['notes'] ?? null;
        $frontImage = $data['front_image'] ?? null;
        $backImage = $data['back_image'] ?? null;
        $purchaseLink = $data['purchase_link'] ?? null;
        $audioFileUrl = $data['audio_file_url'] ?? null;
        $bpm = isset($data['bpm']) ? (int)$data['bpm'] : null;

        // Bind all parameters
        if (!$stmt->bind_param(
            'ssssssssssdsssssii',  // Note the extra 'i' for the WHERE id
            $title,
            $artist,
            $genre,
            $releaseYear,
            $label,
            $catalogNumber,
            $format,
            $speed,
            $condition,
            $purchaseDate,
            $purchasePrice,
            $notes,
            $frontImage,
            $backImage,
            $purchaseLink,
            $audioFileUrl,
            $bpm,
            $id
        )) {
            throw new \Exception("Failed to bind parameters: " . $stmt->error);
        }

        if (!$stmt->execute()) {
            throw new \Exception("Failed to update record: " . $stmt->error);
        }

        // Handle image cleanup
        if (!empty($frontImage) && $record->getFrontImage() !== $frontImage) {
            $oldFrontImagePath = __DIR__ . '/../../public/' . $record->getFrontImage();
            if (file_exists($oldFrontImagePath)) {
                unlink($oldFrontImagePath);
            }
        }

        if (!empty($backImage) && $record->getBackImage() !== $backImage) {
            $oldBackImagePath = __DIR__ . '/../../public/' . $record->getBackImage();
            if (file_exists($oldBackImagePath)) {
                unlink($oldBackImagePath);
            }
        }

        // Return the updated record
        return $this->findById($id);
    }
} 