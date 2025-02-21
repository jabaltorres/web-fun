<?php

declare(strict_types=1);

namespace Fivetwofive\KrateCMS\Services;

use Fivetwofive\KrateCMS\Core\Database\DatabaseConnection;
use mysqli_result;
use mysqli_stmt;
use RuntimeException;
use InvalidArgumentException;
use Exception;

/**
 * Manages contact-related operations in the system
 */
class ContactManager
{
    private DatabaseConnection $db;

    public function __construct(DatabaseConnection $db)
    {
        $this->db = $db;
    }
    
    /**
     * Retrieves all contacts with optional sorting
     *
     * @param string $sort Column to sort by
     * @param string $direction Sort direction ('asc' or 'desc')
     * @return mysqli_result
     * @throws RuntimeException if query fails
     */
    public function findAllContacts(string $sort = 'id', string $direction = 'asc'): mysqli_result
    {
        $validSortColumns = ['id', 'first_name', 'last_name', 'email', 'favorite'];
        
        if (!in_array($sort, $validSortColumns, true)) {
            $sort = 'id';
        }

        $direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';
        
        // Add secondary sort for consistent ordering
        $secondarySort = $sort === 'id' ? '' : ', id ASC';
        
        $sql = "SELECT * FROM contact_list ORDER BY {$sort} {$direction}{$secondarySort}";

        $result = $this->db->query($sql);
        
        if (!$result) {
            throw new RuntimeException('Failed to fetch contacts');
        }
        
        return $result;
    }

    public function findContactById(int $id): ?array
    {
        $sql = "SELECT contact_list.*, rankings.rank_description 
                FROM contact_list 
                LEFT JOIN rankings ON contact_list.rank_id = rankings.rank_id 
                WHERE contact_list.id = ? 
                LIMIT 1";
                
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            
            $result = $stmt->get_result();
            $contact = $result->fetch_assoc();
            
            // Debug output
            error_log('Contact data retrieved: ' . print_r($contact, true));
            
            $stmt->close();
            return $contact ?: null;
        } catch (Exception $e) {
            error_log('Error in findContactById: ' . $e->getMessage());
            throw new RuntimeException('Failed to fetch contact: ' . $e->getMessage());
        }
    }

    public function validateContact(array $contact): array
    {
        $errors = [];

        // first_name
        if (empty($contact['first_name'])) {
            $errors[] = "First name cannot be blank.";
        } elseif (strlen($contact['first_name']) < 2 || strlen($contact['first_name']) > 255) {
            $errors[] = "First name must be between 2 and 255 characters.";
        }

        // last_name
        if (empty($contact['last_name'])) {
            $errors[] = "Last name cannot be blank.";
        } elseif (strlen($contact['last_name']) < 2 || strlen($contact['last_name']) > 255) {
            $errors[] = "Last name must be between 2 and 255 characters.";
        }

        // email
        if (!filter_var($contact['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email address must be valid.";
        }

        return $errors;
    }

    public function insertContact(array $contact): bool
    {
        $errors = $this->validateContact($contact);
        if (!empty($errors)) {
            throw new InvalidArgumentException(implode(', ', $errors));
        }

        $sql = "INSERT INTO contact_list (first_name, last_name, email) VALUES (?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('sss', 
            $contact['first_name'],
            $contact['last_name'],
            $contact['email']
        );
        
        $result = $stmt->execute();
        $stmt->close();
        
        if (!$result) {
            throw new RuntimeException('Failed to insert contact');
        }
        
        return true;
    }

    public function updateContact(array $contact): bool
    {
        $errors = $this->validateContact($contact);
        if (!empty($errors)) {
            throw new InvalidArgumentException(implode(', ', $errors));
        }

        $sql = "UPDATE contact_list SET 
                first_name = ?,
                last_name = ?,
                email = ?,
                comments = ?,
                contact_number = ?,
                favorite = ?,
                rank_id = ?";
                
        // Add image field if present
        if (!empty($contact['image'])) {
            $sql .= ", image = ?";
        }
        
        $sql .= " WHERE id = ? LIMIT 1";

        $stmt = $this->db->prepare($sql);
        
        $rankId = empty($contact['rank_id']) ? null : $contact['rank_id'];
        $favorite = (int)($contact['favorite'] ?? 0);
        
        if (!empty($contact['image'])) {
            $stmt->bind_param('sssssiisi',
                $contact['first_name'],
                $contact['last_name'],
                $contact['email'],
                $contact['comments'],
                $contact['contact_number'],
                $favorite,
                $rankId,
                $contact['image'],
                $contact['id']
            );
        } else {
            $stmt->bind_param('sssssisi',
                $contact['first_name'],
                $contact['last_name'],
                $contact['email'],
                $contact['comments'],
                $contact['contact_number'],
                $favorite,
                $rankId,
                $contact['id']
            );
        }
        
        $result = $stmt->execute();
        $stmt->close();
        
        if (!$result) {
            throw new RuntimeException('Failed to update contact');
        }
        
        return true;
    }

    public function deleteContact(int $id): bool
    {
        $sql = "DELETE FROM contact_list WHERE id = ? LIMIT 1";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $id);
        
        $result = $stmt->execute();
        $stmt->close();
        
        if (!$result) {
            throw new RuntimeException('Failed to delete contact');
        }
        
        return true;
    }

    /**
     * Finds contacts matching the search criteria
     *
     * @param string $searchTerm The term to search for
     * @param string $sort Column to sort by
     * @param string $direction Sort direction ('asc' or 'desc')
     * @return mysqli_result
     * @throws RuntimeException if query fails
     */
    public function searchContacts(string $searchTerm = '', string $sort = 'id', string $direction = 'asc'): mysqli_result
    {
        $validSortColumns = ['id', 'first_name', 'last_name', 'email', 'favorite'];
        
        if (!in_array($sort, $validSortColumns, true)) {
            $sort = 'id';
        }

        $direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';
        $searchTerm = '%' . $searchTerm . '%';
        
        // Add secondary sort for consistent ordering
        $secondarySort = $sort === 'id' ? '' : ', id ASC';
        
        $sql = "SELECT * FROM contact_list 
                WHERE first_name LIKE ? 
                   OR last_name LIKE ? 
                   OR email LIKE ? 
                   OR contact_number LIKE ?
                ORDER BY {$sort} {$direction}{$secondarySort}";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('ssss', $searchTerm, $searchTerm, $searchTerm, $searchTerm);
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if (!$result) {
            throw new RuntimeException('Failed to search contacts');
        }
        
        return $result;
    }
}