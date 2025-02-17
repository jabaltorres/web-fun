<?php
declare(strict_types=1);

namespace Fivetwofive\KrateCMS\Controllers;

use Exception;

/**
 * Class AdminController
 * 
 * Handles administrative tasks and user management within the admin area.
 */
class AdminController
{
    private $urlHelper;
    private $htmlHelper;
    private $sessionHelper;
    private $requestHelper;
    private $userManager;
    private $settingsManager;
    private $config;
    private $socialLinksService;

    /**
     * AdminController constructor.
     *
     * @param array $app Application services and helpers.
     */
    public function __construct(array $app)
    {
        $this->urlHelper = $app['urlHelper'];
        $this->htmlHelper = $app['htmlHelper'];
        $this->sessionHelper = $app['sessionHelper'];
        $this->requestHelper = $app['requestHelper'];
        $this->userManager = $app['userManager'];
        $this->settingsManager = $app['settingsManager'];
        $this->config = $app['config'];
        $this->socialLinksService = $app['socialLinksService'];
    }

    /**
     * Extracts view services for template rendering.
     *
     * @return array An associative array of services for the view.
     */
    private function extractViewServices(): array
    {
        return [
            'settingsManager' => $this->settingsManager,
            'sessionHelper' => $this->sessionHelper,
            'userManager' => $this->userManager,
            'urlHelper' => $this->urlHelper,
            'htmlHelper' => $this->htmlHelper,
            'config' => $this->config,
            'socialLinksService' => $this->socialLinksService
        ];
    }

    /**
     * Handles incoming requests to the admin dashboard.
     *
     * @return void
     * @throws Exception If an error occurs during request handling.
     */
    public function handleRequest(): void
    {
        try {
            // Enforce login and admin access
            if (!$this->sessionHelper->isLoggedIn()) {
                $this->sessionHelper->setMessage('Please login to access admin area');
                $this->urlHelper->redirect('/users/login.php');
            }

            // Get user status
            $loggedIn = $this->sessionHelper->isLoggedIn();
            $userId = $this->sessionHelper->getCurrentUserId();
            $isAdmin = $userId ? $this->userManager->isAdmin($userId) : false;

            // If not admin, redirect to regular dashboard
            if (!$isAdmin) {
                $this->sessionHelper->setMessage('Access denied. Admin privileges required.');
                $this->urlHelper->redirect('/dashboard');
            }

            // Fetch users only if admin (with error handling)
            $users = null;
            if ($isAdmin) {
                $result = $this->userManager->getAllUsers();
                $users = $result ?: null;
            }

            // Fetch all settings
            $settings = $this->settingsManager->getAllSettings($isAdmin);

            // Handle POST requests
            if ($this->requestHelper->isPost() && $this->requestHelper->post('action')) {
                $this->handlePostRequest($userId);
            }

            // Page metadata
            $pageTitle = 'Admin Dashboard | ' . $this->config['site']['name'];
            $pageDescription = 'Administrative dashboard for ' . $this->config['site']['name'];

            // Extract variables for templates
            $viewData = $this->extractViewServices();
            extract($viewData);

            // Make variables explicitly available for each template
            require(ROOT_PATH . '/src/Views/templates/header.php');
            require(ROOT_PATH . '/src/Views/admin/dashboard.php');
            require(ROOT_PATH . '/src/Views/templates/footer.php');

        } catch (Exception $e) {
            // Log the error
            error_log("Admin Dashboard Error: " . $e->getMessage());
            
            // Set error message and redirect
            $this->sessionHelper->setMessage("An error occurred: " . $e->getMessage());
            $this->urlHelper->redirect('/index.php');
        }
    }

    /**
     * Handles POST requests for admin actions.
     *
     * @param int $userId The ID of the currently logged-in user.
     * @return void
     */
    private function handlePostRequest(int $userId): void
    {
        $action = $this->requestHelper->post('action');
        
        try {
            switch ($action) {
                case 'edit_setting':
                    $this->updateSetting($userId);
                    break;
                    
                case 'delete_setting':
                    $this->deleteSetting();
                    break;

                case 'add_setting':
                    $this->addSetting($userId);
                    break;
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            $this->sessionHelper->setMessage("Error: {$error}");
        }
    }

    /**
     * Updates a specific setting.
     *
     * @param int $userId The ID of the user making the update.
     * @return void
     * @throws Exception If the update fails.
     */
    private function updateSetting(int $userId): void
    {
        $success = $this->settingsManager->setSetting(
            $this->requestHelper->post('setting_key'),
            $this->requestHelper->post('setting_value'),
            $this->requestHelper->post('setting_type'),
            $this->requestHelper->post('category'),
            $this->requestHelper->post('description'),
            (bool)$this->requestHelper->post('is_private'),
            $userId
        );

        if (!$success) {
            throw new Exception('Failed to update setting');
        }

        $this->sessionHelper->setMessage('Setting updated successfully');
        $this->urlHelper->redirect($_SERVER['PHP_SELF']);
    }

    /**
     * Deletes a specific setting.
     *
     * @return void
     * @throws Exception If the deletion fails.
     */
    private function deleteSetting(): void
    {
        if ($this->settingsManager->deleteSetting($this->requestHelper->post('setting_key'))) {
            $this->sessionHelper->setMessage('Setting deleted successfully');
            $this->urlHelper->redirect($_SERVER['PHP_SELF']);
        }
        throw new Exception('Failed to delete setting');
    }

    /**
     * Adds a new setting.
     *
     * @param int $userId The ID of the user adding the setting.
     * @return void
     * @throws Exception If the addition fails.
     */
    private function addSetting(int $userId): void
    {
        $success = $this->settingsManager->setSetting(
            $this->requestHelper->post('setting_key'),
            $this->requestHelper->post('setting_value'),
            $this->requestHelper->post('setting_type'),
            $this->requestHelper->post('category'),
            $this->requestHelper->post('description'),
            (bool)$this->requestHelper->post('is_private'),
            $userId
        );

        if (!$success) {
            throw new Exception('Failed to add setting');
        }

        $this->sessionHelper->setMessage('Setting added successfully');
        $this->urlHelper->redirect($_SERVER['PHP_SELF']);
    }
}
