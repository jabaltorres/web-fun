<?php
declare(strict_types=1);

namespace Fivetwofive\KrateCMS\Services;

use Fivetwofive\KrateCMS\Core\Database\DatabaseConnection;
use Fivetwofive\KrateCMS\Core\Helpers\ValidationHelper;

class SubjectService {
    private DatabaseConnection $db;

    public function __construct(DatabaseConnection $db) {
        $this->db = $db;
    }

    /**
     * Finds a subject by its ID
     * @param int $id Subject ID to search for
     * @return array|null Subject data array or null if not found
     */
    public function findSubjectById(int $id): ?array {
        if ($id <= 0) {
            return null;
        }

        $stmt = $this->db->prepare("SELECT * FROM subjects WHERE id = ? LIMIT 1");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    /**
     * Retrieves all subjects ordered by position
     * @return array Array of all subjects
     */
    public function findAllSubjects(): array {
        $sql = "SELECT * FROM subjects ORDER BY position ASC";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function validate_subject($subject)
    {
        $errors = [];
    
        // menu_name
        if (ValidationHelper::is_blank($subject['menu_name'])) {
            $errors[] = "Name cannot be blank.";
        } elseif (!ValidationHelper::has_length($subject['menu_name'], ['min' => 2, 'max' => 255])) {
            $errors[] = "Name must be between 2 and 255 characters.";
        }
    
        // position
        // Make sure we are working with an integer
        $postion_int = (int)$subject['position'];
        if ($postion_int <= 0) {
            $errors[] = "Position must be greater than zero.";
        }
        if ($postion_int > 999) {
            $errors[] = "Position must be less than 999.";
        }
    
        // visible
        // Make sure we are working with a string
        $visible_str = (string)$subject['visible'];
        if (!ValidationHelper::has_inclusion_of($visible_str, ["0", "1"])) {
            $errors[] = "Visible must be true or false.";
        }
    
        return $errors;
    }
} 