<?php

use JetBrains\PhpStorm\Pure;

/**
 * This creates a new HTML card element
 */
class LoremCard
{

    private string $id;
    private string $classes;
    private string $content;
    private bool $dark_mode;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? '';
        $this->classes = $args['classes'] ?? '';
        $this->content = $args['content'] ?? '';
        $this->dark_mode = $args['dark_mode'] ?? false;
    }

    public function setDarkMode(): string
    {
        if ($this->dark_mode == true) {
            return "<div class='bg-primary p-2 dark text-light'>Dark Mode</div>";
        } else {
            return "<div class='bg-secondary p-2 default'>Default Mode</div>";
        }
    }

    public function render(): string
    {
        $html = "<div id=\"{$this->id}\" class=\"{$this->classes}\">";
        $html .= "Excuse me, Let me clear my throat. <br>";
        $html .= "{$this->content} <br>";
        $html .= self::setDarkMode();
        $html .= "</div>";

        return $html;
    }
}
