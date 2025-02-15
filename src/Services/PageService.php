<?php
declare(strict_types=1);

namespace Fivetwofive\KrateCMS\Services;

use Fivetwofive\KrateCMS\Core\Database\DatabaseConnection;

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
        return $result ? $result->fetch_assoc() : null;
    }

    /**
     * Finds a subject by its ID
     * @param int $id Subject ID to search for
     * @return array|null Subject data array or null if not found
     */
    public function findSubjectById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM subjects WHERE id = ? LIMIT 1");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
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
    public function findAllSubjects(): array {
        $sql = "SELECT * FROM subjects ORDER BY position ASC";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Finds all pages belonging to a specific subject
     * @param int $subjectId Subject ID to find pages for
     * @param array $options Additional options (e.g. visibility filter)
     * @return array Array of pages belonging to the subject
     */
    public function findPagesBySubjectId(int $subjectId, array $options = []): array {
        $visible = $options['visible'] ?? true;
        
        $sql = "SELECT * FROM pages WHERE subject_id = ?";
        if ($visible) {
            $sql .= " AND visible = 1";
        }
        $sql .= " ORDER BY position ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $subjectId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
} 