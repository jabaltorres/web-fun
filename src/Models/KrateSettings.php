<?php
declare(strict_types=1);

namespace Fivetwofive\KrateCMS\Models;

use Fivetwofive\KrateCMS\Core\Database\DatabaseConnection;

class KrateSettings {
    private DatabaseConnection $db;
    private static ?self $instance = null;
    private array $settings = [];
    
    /**
     * Constructor - establishes database connection
     * 
     * @param \mysqli $db Database connection
     */
    private function __construct(DatabaseConnection $db) {
        $this->db = $db;
        $this->loadSettings();
    }
    
    /**
     * Get singleton instance
     * 
     * @param \mysqli $db Database connection
     * @return self
     */
    public static function getInstance(DatabaseConnection $db): self {
        if (self::$instance === null) {
            self::$instance = new self($db);
        }
        return self::$instance;
    }
    
    /**
     * Load all settings from database
     */
    private function loadSettings(): void {
        $result = $this->db->query("SELECT * FROM settings");
        
        while ($row = $result->fetch_assoc()) {
            $this->settings[$row['setting_key']] = [
                'value' => $row['setting_value'],
                'type' => $row['setting_type']
            ];
        }
    }
    
    /**
     * Get a setting value
     * 
     * @param string $key Setting key
     * @param mixed $default Default value if setting not found
     * @return mixed
     */
    public function getSetting(string $key, $default = null) {
        if (!isset($this->settings[$key])) {
            return $default;
        }
        
        $setting = $this->settings[$key];
        
        // Convert value based on type
        switch ($setting['type']) {
            case 'boolean':
                return $setting['value'] === '1';
            case 'integer':
                return (int)$setting['value'];
            case 'float':
                return (float)$setting['value'];
            case 'json':
            case 'array':
                return json_decode($setting['value'], true);
            default:
                return $setting['value'];
        }
    }
    
    /**
     * Set a setting value
     * 
     * @param string $key Setting key
     * @param mixed $value Setting value
     * @param string $type Value type
     * @param string $category Setting category
     * @param string $description Setting description
     * @param bool $isPrivate Whether setting is private
     * @param int $userId User ID making the change
     * @return bool
     */
    public function setSetting(
        string $key,
        $value,
        string $type = 'string',
        string $category = 'general',
        string $description = '',
        bool $isPrivate = false,
        int $userId = 0
    ): bool {
        // Validate and format value based on type
        switch($type) {
            case 'boolean':
                $value = filter_var($value, FILTER_VALIDATE_BOOLEAN) ? '1' : '0';
                break;
            case 'integer':
                if (!filter_var($value, FILTER_VALIDATE_INT)) {
                    throw new \InvalidArgumentException('Invalid integer value');
                }
                break;
            case 'float':
                if (!filter_var($value, FILTER_VALIDATE_FLOAT)) {
                    throw new \InvalidArgumentException('Invalid float value');
                }
                break;
            case 'json':
                if (!is_string($value)) {
                    $value = json_encode($value);
                } elseif (!json_decode($value)) {
                    throw new \InvalidArgumentException('Invalid JSON value');
                }
                break;
            case 'array':
                $value = is_array($value) ? json_encode($value) : $value;
                if (!json_decode($value)) {
                    throw new \InvalidArgumentException('Invalid array value');
                }
                break;
        }
        
        $sql = "INSERT INTO settings (
                    setting_key, setting_value, setting_type, category, 
                    description, is_private, created_by, updated_by
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE 
                    setting_value = VALUES(setting_value),
                    setting_type = VALUES(setting_type),
                    category = VALUES(category),
                    description = VALUES(description),
                    is_private = VALUES(is_private),
                    updated_by = VALUES(updated_by),
                    updated_at = CURRENT_TIMESTAMP";
        
        $stmt = $this->db->prepare($sql);
        $isPrivateInt = $isPrivate ? 1 : 0;
        
        $stmt->bind_param(
            'sssssiis',
            $key,
            $value,
            $type,
            $category,
            $description,
            $isPrivateInt,
            $userId,
            $userId
        );
        
        $success = $stmt->execute();
        
        if ($success) {
            // Update local cache
            $this->settings[$key] = [
                'value' => $value,
                'type' => $type
            ];
        }
        
        return $success;
    }
    
    /**
     * Delete a setting
     * 
     * @param string $key Setting key
     * @return bool
     */
    public function deleteSetting(string $key): bool {
        $sql = "DELETE FROM settings WHERE setting_key = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s', $key);
        
        $success = $stmt->execute();
        
        if ($success) {
            unset($this->settings[$key]);
        }
        
        return $success;
    }
    
    /**
     * Get all settings
     * 
     * @param bool $includePrivate Whether to include private settings
     * @return array
     */
    public function getAllSettings(bool $includePrivate = false): array {
        $sql = "SELECT * FROM settings";
        if (!$includePrivate) {
            $sql .= " WHERE is_private = 0";
        }
        $sql .= " ORDER BY category, setting_key";
        
        $result = $this->db->query($sql);
        $settings = [];
        
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $settings[] = $row;
            }
        }
        
        return $settings;
    }
    
    /**
     * Get the description of a setting by its key
     *
     * @param string $key The setting key
     * @return string The setting description or empty string if not found
     */
    public function getSettingDescription(string $key): string
    {
        $sql = "SELECT description FROM settings WHERE setting_key = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s', $key);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            return $row['description'];
        }
        
        return '';
    }
} 