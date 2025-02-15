<?php
declare(strict_types=1);

namespace Fivetwofive\KrateCMS\Controllers;

use Fivetwofive\KrateCMS\Services\PageService;
use Fivetwofive\KrateCMS\Services\SubjectService;

/**
 * Class PageController
 * Handles page-related requests and responses.
 */
class PageController
{
    private PageService $pageService; // Service for handling page-related operations
    private SubjectService $subjectService; // Service for handling subject-related operations
    
    /**
     * PageController constructor.
     *
     * @param PageService $pageService
     * @param SubjectService $subjectService
     */
    public function __construct(PageService $pageService, SubjectService $subjectService)
    {
        $this->pageService = $pageService; // Dependency injection of PageService
        $this->subjectService = $subjectService; // Dependency injection of SubjectService
    }
    
    /**
     * Show the page based on the request parameters.
     *
     * @return array The view data for the page.
     */
    public function show(): array
    {
        $loggedIn = isset($_SESSION['user_id']); // Check if user is logged in
        $visible = !$this->pageService->is_preview(); // Determine if the page is visible
        
        // Initialize view data
        $viewData = [
            'page' => null,
            'subject' => null,
            'subject_id' => '',
            'page_id' => null,
            'loggedIn' => $loggedIn,
            'visible' => $visible,
            'isPreview' => $this->pageService->is_preview() // Check if the page is in preview mode
        ];
        
        // Handle page ID request
        if (isset($_GET['id'])) {
            $viewData = $this->handlePageRequest((int)$_GET['id'], $visible, $viewData);
        }
        // Handle subject ID request
        elseif (isset($_GET['subject_id'])) {
            $viewData = $this->handleSubjectRequest($_GET['subject_id'], $visible, $viewData);
        }
        // Default case
        else {
            $viewData = $this->handleDefaultCase($visible, $viewData);
        }
        
        return $viewData; // Return the prepared view data
    }
    
    /**
     * Handle the request for a specific page.
     *
     * @param int $pageId The ID of the page.
     * @param bool $visible Whether the page is visible.
     * @param array $viewData The current view data.
     * @return array Updated view data.
     */
    private function handlePageRequest(int $pageId, bool $visible, array $viewData): array
    {
        $page = $this->pageService->findPageById($pageId); // Find the page by ID
        if (!$page) {
            $this->redirect('/page.php'); // Redirect if the page is not found
        }
        
        $subjectId = (string)$page['subject_id']; // Get the subject ID from the page
        $subject = $this->subjectService->findSubjectById((int)$subjectId, ['visible' => $visible]); // Find the subject
        
        if (!$subject) {
            $this->redirect('/page.php'); // Redirect if the subject is not found
        }
        
        return array_merge($viewData, [
            'page' => $page,
            'subject' => $subject,
            'subject_id' => $subjectId,
            'page_id' => $pageId
        ]); // Merge and return updated view data
    }
    
    /**
     * Handle the request for a specific subject.
     *
     * @param string $subjectId The ID of the subject.
     * @param bool $visible Whether the subject is visible.
     * @param array $viewData The current view data.
     * @return array Updated view data.
     */
    private function handleSubjectRequest(string $subjectId, bool $visible, array $viewData): array
    {
        $subject = $this->subjectService->findSubjectById((int)$subjectId, ['visible' => $visible]); // Find the subject by ID
        if (!$subject) {
            $this->redirect('/page.php'); // Redirect if the subject is not found
        }
        
        $pageSet = $this->pageService->findPagesBySubjectId((int)$subjectId, ['visible' => $visible]); // Find pages by subject ID
        if ($pageSet->num_rows === 0) {
            $this->redirect('/page.php'); // Redirect if no pages are found
        }
        
        $pages = $pageSet->fetch_all(MYSQLI_ASSOC); // Fetch all pages as an associative array
        $page = $pages[0]; // Get the first page
        
        return array_merge($viewData, [
            'page' => $page,
            'subject' => $subject,
            'subject_id' => $subjectId,
            'page_id' => $page['id']
        ]); // Merge and return updated view data
    }
    
    /**
     * Handle the default case when no specific page or subject is requested.
     *
     * @param bool $visible Whether the page is visible.
     * @param array $viewData The current view data.
     * @return array Updated view data.
     */
    private function handleDefaultCase(bool $visible, array $viewData): array
    {
        $page = $this->pageService->findPageById(DEFAULT_PAGE_ID); // Find the default page
        if ($page) {
            $subjectId = (string)$page['subject_id']; // Get the subject ID from the page
            $subject = $this->subjectService->findSubjectById((int)$subjectId, ['visible' => $visible]); // Find the subject
            
            return array_merge($viewData, [
                'page' => $page,
                'subject' => $subject,
                'subject_id' => $subjectId,
                'page_id' => DEFAULT_PAGE_ID
            ]); // Merge and return updated view data
        }
        
        return $viewData; // Return the original view data if no page is found
    }
    
    /**
     * Redirect to a specified path.
     *
     * @param string $path The path to redirect to.
     */
    private function redirect(string $path): void
    {
        redirect_to(url_for($path)); // Redirect to the specified path
        exit; // Terminate the script
    }
} 