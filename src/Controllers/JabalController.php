<?php

declare(strict_types=1);

namespace Fivetwofive\KrateCMS\Controllers;

use Exception;

class JabalController
{
    private string $title;
    private string $description;
    private string $bodyClass;
    private string $first_name; 
    private string $last_name;
    private string $email;
    private string $phone;
    private string $message;
    private \Twig\Environment $twig;
    
    public function __construct(string $first_name, string $last_name, string $email, string $phone, string $message, \Twig\Environment $twig, string $title, string $description, string $bodyClass)
    {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->phone = $phone;
        $this->message = $message;
        $this->title = $title;
        $this->description = $description;
        $this->bodyClass = $bodyClass;
        $this->twig = $twig;
    }

    private function getViewData(): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'message' => $this->message,
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