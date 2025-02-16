<?php
declare(strict_types=1);
// src/Http/Controllers/RecordController.php

namespace Fivetwofive\KrateCMS\Controllers;

use Fivetwofive\KrateCMS\Services\RecordService;
use Fivetwofive\KrateCMS\Core\Helpers\RequestHelper;
use Fivetwofive\KrateCMS\Core\Helpers\SessionHelper;
use Fivetwofive\KrateCMS\Core\Helpers\HtmlHelper;
use Fivetwofive\KrateCMS\Core\Helpers\UrlHelper;

class RecordController
{
    private RecordService $recordService;
    private RequestHelper $requestHelper;
    private SessionHelper $sessionHelper;
    private HtmlHelper $htmlHelper;
    private $settingsManager;
    private $socialLinksService;
    private UrlHelper $urlHelper;
    private $userManager;
    private array $config;

    public function __construct(
        RecordService $recordService,
        RequestHelper $requestHelper,
        SessionHelper $sessionHelper,
        HtmlHelper $htmlHelper,
        $settingsManager,
        $socialLinksService,
        UrlHelper $urlHelper,
        $userManager,
        array $config
    ) {
        $this->recordService = $recordService;
        $this->requestHelper = $requestHelper;
        $this->sessionHelper = $sessionHelper;
        $this->htmlHelper = $htmlHelper;
        $this->settingsManager = $settingsManager;
        $this->socialLinksService = $socialLinksService;
        $this->urlHelper = $urlHelper;
        $this->userManager = $userManager;
        $this->config = $config;
    }

    /**
     * Display the index page with all records
     */
    public function index(): void
    {
        // Retrieve the search term from the request
        $searchTerm = $this->requestHelper->get('search');
        
        // Fetch all records based on the search term
        $records = $this->recordService->findAll($searchTerm);
        
        // Check if the user is logged in
        $loggedIn = $this->sessionHelper->isLoggedIn();

        // Make helpers available to the view
        $htmlHelper = $this->htmlHelper;
        $settingsManager = $this->settingsManager;
        $socialLinksService = $this->socialLinksService;
        $urlHelper = $this->urlHelper;
        $sessionHelper = $this->sessionHelper;
        $userManager = $this->userManager;
        $config = $this->config;

        // Include the view file to render the records
        include(ROOT_PATH . '/src/Views/records/index.php');
    }
}