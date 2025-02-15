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
        $this->ensureTableExists();
    }
    
    public function getDb(): DatabaseConnection
    {
        return $this->db;
    }
    
    /**
     * @param string|null $searchTerm
     * @return Record[]
     */
    public function findAll(?string $searchTerm = null): array
    {
        try {
            if ($searchTerm) {
                $stmt = $this->db->prepare(
                    "SELECT * FROM vinyl_records 
                    WHERE title LIKE ? OR artist LIKE ? 
                    ORDER BY created_at DESC"
                );
                if (!$stmt) {
                    return [];
                }
                $searchPattern = '%' . $searchTerm . '%';
                $stmt->bind_param('ss', $searchPattern, $searchPattern);
                $stmt->execute();
                $result = $stmt->get_result();
            } else {
                $result = $this->db->query(
                    "SELECT * FROM vinyl_records ORDER BY created_at DESC"
                );
                
                if ($result === false) {
                    return [];
                }
            }
            
            $records = [];
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $records[] = Record::fromArray($row);
                }
            }
            
            return $records;
        } catch (\Exception $e) {
            return [];
        }
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
            throw new \Exception("Failed to prepare statement: " . $this->db->getConnection()->error);
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

    private function ensureTableExists(): void
    {
        try {
            // Check if table exists
            $result = $this->db->query("SHOW TABLES LIKE 'vinyl_records'");
            
            if ($result->num_rows === 0) {
                error_log("Creating vinyl_records table...");
                
                // Create the table
                $sql = "CREATE TABLE vinyl_records (
                    record_id INT AUTO_INCREMENT PRIMARY KEY,
                    title VARCHAR(255) NOT NULL,
                    artist VARCHAR(255) NOT NULL,
                    release_year INT,
                    genre VARCHAR(100),
                    label VARCHAR(255),
                    catalog_number VARCHAR(100),
                    format VARCHAR(50),
                    speed VARCHAR(20),
                    `condition` VARCHAR(50),
                    purchase_date DATE,
                    purchase_price DECIMAL(10,2),
                    notes TEXT,
                    front_image VARCHAR(255),
                    back_image VARCHAR(255),
                    purchase_link VARCHAR(255),
                    audio_file_url VARCHAR(255),
                    bpm INT,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                )";
                
                $this->db->query($sql);
                error_log("Table created successfully");
                
                // Insert test data
                $this->insertTestData();
            }
        } catch (\Exception $e) {
            error_log("Error ensuring table exists: " . $e->getMessage());
            throw $e;
        }
    }

    private function insertTestData(): void
    {
        try {
            $sql = "INSERT INTO vinyl_records (title, artist, release_year) VALUES 
                ('Test Album 1', 'Test Artist 1', 2023),
                ('Test Album 2', 'Test Artist 2', 2022)";
            
            $this->db->query($sql);
            error_log("Test data inserted successfully");
        } catch (\Exception $e) {
            error_log("Error inserting test data: " . $e->getMessage());
            throw $e;
        }
    }
} 