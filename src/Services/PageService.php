<?php
declare(strict_types=1);

namespace Fivetwofive\KrateCMS\Services;

use Fivetwofive\KrateCMS\Core\Database\DatabaseConnection;
use Fivetwofive\KrateCMS\Core\Helpers\ValidationHelper;
/**
 * Service class for handling page-related database operations and utilities
 */
class PageService {
    /** @var DatabaseConnection Database connection instance */
    private DatabaseConnection $db;
    
    /**
     * Constructor that injects database dependency
     * @param DatabaseConnection $db Database connection instance
     */
    public function __construct(DatabaseConnection $db) {
        $this->db = $db;
    }

    /**
     * Retrieves all pages ordered by subject ID and position
     * @return array Array of all pages
     */
    public function findAllPages(): array {
        $sql = "SELECT * FROM pages ORDER BY subject_id ASC, position ASC";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Finds a page by its ID
     * @param int $id Page ID to search for
     * @return array|null Page data array or null if not found
     */
    public function findPageById(int $id): ?array {
        if ($id <= 0) {
            return null;
        }
        
        $stmt = $this->db->prepare("SELECT * FROM pages WHERE id = ? LIMIT 1");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * Checks if the current page is being previewed
     * @return bool True if page is in preview mode
     */
    public function is_preview(): bool
    {
        $preview = false;
        if (isset($_GET['preview'])) {
            // Previewing should require admin to be logged in
            $preview = $_GET['preview'] === 'true';
        }
        return $preview;
    }

    /**
     * Displays a warning alert when page is in preview mode
     */
    public function show_preview_alert()
    {
        $previewAlertMessage = '<div class="container">';
        $previewAlertMessage .= '<div class="alert alert-warning" role="alert">You are previewing the page</div>';
        $previewAlertMessage .= '</div>';
        echo $previewAlertMessage;
    }

    /**
     * Retrieves all subjects ordered by position
     * @return array Array of all subjects
     */
    // Removed subject-related methods

    /**
     * Finds all pages belonging to a specific subject
     * @param int $subjectId Subject ID to find pages for
     * @param array $options Additional options (e.g. visibility filter)
     * @return \mysqli_result Result set of pages belonging to the subject
     */
    public function findPagesBySubjectId(int $subjectId, array $options = []): \mysqli_result {
        // Build the SQL query with proper visibility handling
        $sql = "SELECT * FROM pages WHERE subject_id = ?";
        
        // Convert visibility to integer for SQL
        $visible = isset($options['visible']) ? (int)$options['visible'] : 1;
        $sql .= " AND visible = ?";
        
        $sql .= " ORDER BY position ASC";
        
        // Debug the SQL query
        error_log("SQL Query for pages: " . $sql . " [subject_id: $subjectId, visible: $visible]");
        
        $stmt = $this->db->prepare($sql);
        if ($stmt === false) {
            throw new \Exception("Failed to prepare statement: " . $this->db->getConnection()->error);
        }
        
        $stmt->bind_param('ii', $subjectId, $visible);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $count = $result->num_rows;
        error_log("Found $count pages for subject $subjectId");
        
        return $result;
    }

    /**
     * Finds a subject by its ID
     * @param int $id Subject ID to search for
     * @param array $options Additional options (e.g. visibility filter)
     * @return array|null Subject data array or null if not found
     */
    public function findSubjectById(int $id, array $options = []): ?array {
        $sql = "SELECT * FROM subjects WHERE id = ?";
        
        // Check if visibility filter should be applied
        $visible = $options['visible'] ?? null;
        if ($visible !== null) {
            $sql .= " AND visible = ?";
        }
        
        $sql .= " LIMIT 1";
        
        $stmt = $this->db->prepare($sql);
        if ($stmt === false) {
            throw new \Exception("Failed to prepare statement: " . $this->db->getConnection()->error);
        }
        
        // Bind parameters based on whether visibility filter is included
        if ($visible !== null) {
            $stmt->bind_param('ii', $id, $visible);
        } else {
            $stmt->bind_param('i', $id);
        }
        
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function validatePage($page)
    {
        $errors = [];

        // menu_name
        if (ValidationHelper::is_blank($page['menu_name'])) {
            $errors[] = "Menu name cannot be blank.";
        }
    }
    
    public function updatePage(array $page): bool {
        // Escape the input values, casting to string where necessary
        $subject_id = $this->db->escape((string)$page['subject_id']);
        $menu_name = $this->db->escape($page['menu_name']);
        
        // Validate position
        $position = !empty($page['position']) ? (int)$page['position'] : 0; // Set default to 0 if empty
        $visible = $this->db->escape((string)$page['visible']);
        $content = str_replace(array("\r\n", "\r"), "\n", $page['content']);
        $id = $this->db->escape((string)$page['id']);

        $stmt = $this->db->prepare("UPDATE pages SET subject_id = ?, menu_name = ?, position = ?, visible = ?, content = ? WHERE id = ?");
        
        if ($stmt === false) {
            throw new \Exception("Prepare failed: " . $this->db->getConnection()->error);
        }

        $stmt->bind_param('issisi', $subject_id, $menu_name, $position, $visible, $content, $id);
        
        $result = $stmt->execute();
        
        if ($result === false) {
            throw new \Exception("Update failed: " . $this->db->getConnection()->error);
        }

        return true; // Return true if the update was successful
    }
} 