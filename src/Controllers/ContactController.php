<?php

declare(strict_types=1);

namespace Fivetwofive\KrateCMS\Controllers;

use Fivetwofive\KrateCMS\Services\ContactManager;
use Exception;

class ContactController
{
    private ContactManager $contactManager;
    
    public function __construct(ContactManager $contactManager)
    {
        $this->contactManager = $contactManager;
    }
    
    public function index(): array
    {
        // Get search and sort parameters with validation
        $searchTerm = $_GET['search'] ?? '';
        $sort = $this->validateSortColumn($_GET['sort'] ?? 'id');
        $direction = $this->validateSortDirection($_GET['direction'] ?? 'asc');

        // Fetch contacts based on search term
        $contact_set = empty($searchTerm) 
            ? $this->contactManager->findAllContacts($sort, $direction)
            : $this->contactManager->searchContacts($searchTerm, $sort, $direction);

        return [
            'title' => "Contact Page",
            'page_heading' => "Contact Management",
            'page_subheading' => "View and manage your contacts",
            'custom_class' => "contacts-page",
            'searchTerm' => $searchTerm,
            'sort' => $sort,
            'direction' => $direction,
            'contact_set' => $contact_set
        ];
    }

    private function validateSortColumn(?string $sort): string
    {
        $validColumns = ['id', 'first_name', 'last_name', 'email', 'favorite'];
        return in_array($sort, $validColumns, true) ? $sort : 'id';
    }

    private function validateSortDirection(?string $direction): string
    {
        return strtolower($direction) === 'desc' ? 'desc' : 'asc';
    }
}

