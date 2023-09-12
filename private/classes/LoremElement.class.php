<?php
/*
 * This class is used to create a new HTML element
 */
class LoremElement
{

    private string $tag_name;
    private array $attributes = [];
    private string $content;

    public function __construct($tag_name)
    {
        $this->tag_name = $tag_name;
    }

    public function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function setContent($content): self
    {
        $this->content = $content;
        return $this;
    }

    public function render(): string
    {
        // build attribute string
        $attributeString = "";

        // loop through attributes
        foreach ($this->attributes as $name => $value) {
            $attributeString .= " {$name}=\"{$value}\"";
        }

        // open the tag and add attributes
        $html = "<{$this->tag_name} {$attributeString}>";

        // add content
        if ($this->content) {
            $html .= "$this->content";
        }
        // close the tag
        $html .= "</{$this->tag_name}>";

        return $html;
    }
}