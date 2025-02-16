<?php

declare(strict_types=1);

namespace Fivetwofive\KrateCMS\Controllers;

use Fivetwofive\KrateCMS\Services\UserManager;
use mysqli_result;
use Exception;
use InvalidArgumentException;

/**
 * Controller handling user-related operations
 */
class UserController
{
    /** @var UserManager */
    private UserManager $userManager;

    /**
     * @param UserManager $userManager
     */
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * Handle the users index page
     * 
     * @return array<string, mixed>
     */
    public function index(): array
    {
        // Check authentication
        $this->userManager->checkLoggedIn();
        $loggedIn = $this->userManager->isLoggedIn();
        $isAdmin = isset($_SESSION['user_id']) ? $this->userManager->isAdmin($_SESSION['user_id']) : false;

        // Get search, filter, and sort parameters
        $search = $_GET['search'] ?? '';
        $roleFilter = $_GET['role'] ?? '';
        $sortField = $this->validateSortField($_GET['sort'] ?? 'user_id');
        $sortOrder = strtoupper($_GET['order'] ?? 'ASC') === 'DESC' ? 'DESC' : 'ASC';

        // Fetch filtered users if admin
        $users = null;
        if ($isAdmin) {
            $users = $this->userManager->getFilteredUsers($search, $roleFilter, $sortField, $sortOrder);
        }

        return [
            'loggedIn' => $loggedIn,
            'isAdmin' => $isAdmin,
            'users' => $users,
            'search' => $search,
            'roleFilter' => $roleFilter,
            'sortField' => $sortField,
            'sortOrder' => $sortOrder,
            'validRoles' => UserManager::VALID_ROLES
        ];
    }

    /**
     * Generate URL for sorting
     */
    public function getSortUrl(string $field, string $currentSort, string $currentOrder, string $search, string $roleFilter): string
    {
        $newOrder = ($field === $currentSort && $currentOrder === 'ASC') ? 'DESC' : 'ASC';
        $params = [
            'sort' => $field,
            'order' => $newOrder
        ];
        if ($search) $params['search'] = $search;
        if ($roleFilter) $params['role'] = $roleFilter;
        return 'index.php?' . http_build_query($params);
    }

    /**
     * Get sort indicator symbol
     */
    public function getSortIndicator(string $field, string $currentSort, string $currentOrder): string
    {
        if ($field !== $currentSort) return '↕';
        return $currentOrder === 'ASC' ? '↑' : '↓';
    }

    /**
     * Validate sort field to prevent SQL injection
     */
    private function validateSortField(string $field): string
    {
        $validSortFields = ['user_id', 'first_name', 'last_name', 'email', 'username', 'role'];
        return in_array($field, $validSortFields) ? $field : 'user_id';
    }

    /**
     * Handle the user edit page
     * 
     * @param int|null $userId
     * @return array<string, mixed>
     * @throws Exception If user not found or permission denied
     */
    public function edit(?int $userId): array
    {
        // Ensure the user is logged in and is an admin
        $this->userManager->checkLoggedIn();
        if (!isset($_SESSION['user_id']) || !$this->userManager->isAdmin($_SESSION['user_id'])) {
            throw new Exception("You do not have permission to edit users.");
        }

        // Validate user ID
        if (!$userId) {
            throw new Exception("Invalid user ID.");
        }

        // Get the user details
        $userDetails = $this->userManager->getUserDetails($userId);
        if (!$userDetails) {
            throw new Exception("User not found.");
        }

        $error = '';
        $success = '';

        // Handle form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            try {
                // Handle profile update
                if (!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['email'])) {
                    if ($this->userManager->updateUserProfile($userId, [
                        'first_name' => $_POST['first_name'],
                        'last_name' => $_POST['last_name'],
                        'email' => $_POST['email'],
                        'role' => $_POST['role']
                    ])) {
                        $success = "User profile updated successfully!";
                        $userDetails = $this->userManager->getUserDetails($userId);
                    }
                } else {
                    throw new InvalidArgumentException("All fields are required.");
                }

                // Handle password change if requested
                if (!empty($_POST['new_password'])) {
                    if ($_POST['new_password'] !== $_POST['confirm_password']) {
                        throw new InvalidArgumentException("New passwords do not match.");
                    }
                    
                    if ($this->userManager->adminChangeUserPassword($userId, $_POST['new_password'])) {
                        $success = empty($success) ? 
                            "Password updated successfully!" : 
                            "Profile and password updated successfully!";
                    }
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }

        return [
            'userDetails' => $userDetails,
            'validRoles' => UserManager::VALID_ROLES,
            'error' => $error,
            'success' => $success,
            'userId' => $userId
        ];
    }

    /**
     * Handle user login
     * 
     * @return array<string, mixed>
     */
    public function login(): array
    {
        $error = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $username = $_POST['username'] ?? '';
                $password = $_POST['password'] ?? '';
                
                if ($this->userManager->login($username, $password)) {
                    header('Location: /users');
                    exit;
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
        
        return [
            'error' => $error
        ];
    }

    /**
     * Handle user logout
     * 
     * @return void
     */
    public function logout(): void
    {
        $this->userManager->logout();
        header('Location: /users/login');
        exit;
    }

    /**
     * Handle user profile view/edit
     * 
     * @return array<string, mixed>
     * @throws Exception If user is not logged in
     */
    public function myProfile(): array
    {
        $this->userManager->checkLoggedIn();
        
        if (!isset($_SESSION['user_id'])) {
            throw new Exception('Not logged in');
        }
        
        return $this->edit($_SESSION['user_id']);
    }

    /**
     * Handle adding a new user
     * 
     * @return array<string, mixed>
     * @throws Exception If user lacks permission or validation fails
     */
    public function add(): array
    {
        // Ensure the user is logged in and is an admin
        $this->userManager->checkLoggedIn();
        if (!isset($_SESSION['user_id']) || !$this->userManager->isAdmin($_SESSION['user_id'])) {
            throw new Exception("You do not have permission to add users.");
        }

        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $userData = [
                    'username' => $_POST['username'] ?? '',
                    'password' => $_POST['password'] ?? '',
                    'email' => $_POST['email'] ?? '',
                    'first_name' => $_POST['first_name'] ?? '',
                    'last_name' => $_POST['last_name'] ?? '',
                    'role' => $_POST['role'] ?? 'user'
                ];

                if ($this->userManager->createUser($userData)) {
                    $success = "User created successfully!";
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }

        return [
            'error' => $error,
            'success' => $success,
            'validRoles' => UserManager::VALID_ROLES
        ];
    }
} 