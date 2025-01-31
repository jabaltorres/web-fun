<?php

declare(strict_types=1);

namespace Fivetwofive\KrateCMS;

class LoremCard
{
    private string $id;
    private string $classes;
    private string $content;
    private bool $dark_mode;

    public function __construct(array $args = [])
    {
        $this->id = $args['id'] ?? '';
        $this->classes = $args['classes'] ?? '';
        $this->content = $args['content'] ?? '';
        $this->dark_mode = $args['dark_mode'] ?? false;
    }

    public function setDarkMode(): string
    {
        if ($this->dark_mode === true) {
            return "<div class='bg-dark p-2 dark text-light'>Dark Mode</div>";
        }
        return "<div class='bg-light p-2 default'>Default Mode</div>";
    }

    public function render(): string
    {
        $html = "<div id=\"" . htmlspecialchars($this->id) . "\" class=\"" . htmlspecialchars($this->classes) . "\">";
        $html .= "Excuse me, Let me clear my throat. <br>";
        $html .= htmlspecialchars($this->content) . "<br>";
        $html .= $this->setDarkMode();
        $html .= "</div>";

        return $html;
    }
} 