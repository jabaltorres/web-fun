<?php

declare(strict_types=1);

namespace Fivetwofive\KrateCMS\Controllers;

use Exception;

class JabalController
{
    private string $title;
    private string $description;
    private string $bodyClass;
    private string $user_first_name; 
    private string $user_last_name;
    private string $user_email;
    private string $user_phone;
    private string $user_message;
    private \Twig\Environment $twig;
    
    public function __construct(array $jabal_data, \Twig\Environment $twig, array $page_data)
    {
        $this->user_first_name = $jabal_data['first_name'];
        $this->user_last_name = $jabal_data['last_name'];
        $this->user_email = $jabal_data['email'];
        $this->user_phone = $jabal_data['phone'];
        $this->user_message = $jabal_data['message'];
        $this->title = $page_data['title'];
        $this->description = $page_data['description'];
        $this->bodyClass = $page_data['bodyClass'];
        $this->twig = $twig;
    }

    private function getViewData(): array
    {
        return [
            'user_first_name' => $this->user_first_name,
            'user_last_name' => $this->user_last_name,
            'user_email' => $this->user_email,
            'user_phone' => $this->user_phone,
            'user_message' => $this->user_message,
            'title' => $this->title,
            'description' => $this->description,
            'bodyClass' => $this->bodyClass,
            'twig' => $this->twig,
        ];
    }

    public function index(): void
    {
        try {
            $viewData = $this->getViewData();
            // Use the relative path to render the template
            echo $this->twig->render('page/jabal.twig', $viewData);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage(); // Optionally display the error message
        }
    }
} 