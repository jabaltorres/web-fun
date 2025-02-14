<?php

declare(strict_types=1);

namespace Fivetwofive\KrateCMS\Models;

use InvalidArgumentException;
use JsonSerializable;

/**
 * Class LoremElement
 * 
 * A class for creating and rendering HTML elements with attributes and content.
 * Provides a fluent interface for element manipulation and ensures proper HTML escaping.
 */
class LoremElement implements JsonSerializable
{
    /** @var array<string> List of valid HTML tags */
    private const VALID_TAGS = [
        // Structure
        'div', 'span', 'section', 'article', 'header', 'footer', 'nav', 'main', 'aside',
        // Typography
        'p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
        // Lists
        'ul', 'ol', 'li', 'dl', 'dt', 'dd',
        // Interactive
        'a', 'button', 'form', 'input', 'label', 'select', 'textarea',
        // Table
        'table', 'thead', 'tbody', 'tr', 'th', 'td',
        // Other
        'img', 'figure', 'figcaption', 'time', 'address'
    ];

    /** @var array<string> List of void elements that don't need closing tags */
    private const VOID_ELEMENTS = ['img', 'input', 'br', 'hr', 'meta', 'link'];

    /** @var string */
    private $tag;
    
    /** @var array */
    private $attributes = [];
    
    /** @var string */
    private $content = '';
    
    /** @var bool */
    private $escapeContent = true;

    /**
     * @param string $tag The HTML tag name
     * @throws InvalidArgumentException If tag is empty or invalid
     */
    public function __construct(string $tag)
    {
        $this->setTag($tag);
    }

    /**
     * Create a new instance of LoremElement
     *
     * @param string $tag
     * @return self
     */
    public static function create(string $tag): self
    {
        return new self($tag);
    }

    /**
     * Set the HTML tag
     *
     * @param string $tag
     * @return self
     * @throws InvalidArgumentException If tag is empty or invalid
     */
    private function setTag(string $tag): self
    {
        $tag = strtolower(trim($tag));
        
        if (empty($tag)) {
            throw new InvalidArgumentException('Tag name cannot be empty');
        }

        if (!in_array($tag, self::VALID_TAGS, true)) {
            throw new InvalidArgumentException(
                sprintf('Invalid tag name: "%s". Must be one of: %s', 
                    $tag, 
                    implode(', ', self::VALID_TAGS)
                )
            );
        }

        $this->tag = $tag;
        return $this;
    }

    /**
     * Set an attribute for the element
     *
     * @param string $name
     * @param string|bool $value If boolean, attribute will be rendered without value if true
     * @return self
     * @throws InvalidArgumentException If attribute name is empty
     */
    public function setAttribute(string $name, $value): self
    {
        $name = trim($name);
        if (empty($name)) {
            throw new InvalidArgumentException('Attribute name cannot be empty');
        }

        if (is_bool($value)) {
            if ($value) {
                $this->attributes[$name] = true;
            } else {
                unset($this->attributes[$name]);
            }
        } else {
            $this->attributes[$name] = trim((string) $value);
        }

        return $this;
    }

    /**
     * Set multiple attributes at once
     *
     * @param array $attributes
     * @return self
     */
    public function setAttributes(array $attributes): self
    {
        foreach ($attributes as $name => $value) {
            $this->setAttribute((string) $name, $value);
        }
        return $this;
    }

    /**
     * Add a class to the element
     *
     * @param string $class
     * @return self
     */
    public function addClass(string $class): self
    {
        $currentClasses = explode(' ', (string) ($this->attributes['class'] ?? ''));
        $newClasses = explode(' ', trim($class));
        
        $allClasses = array_unique(array_merge($currentClasses, $newClasses));
        $allClasses = array_filter($allClasses); // Remove empty values
        
        $this->attributes['class'] = implode(' ', $allClasses);
        return $this;
    }

    /**
     * Get an attribute value
     *
     * @param string $name
     * @return string|bool|null
     */
    public function getAttribute(string $name)
    {
        return $this->attributes[$name] ?? null;
    }

    /**
     * Remove an attribute
     *
     * @param string $name
     * @return self
     */
    public function removeAttribute(string $name): self
    {
        unset($this->attributes[$name]);
        return $this;
    }

    /**
     * Set the content of the element
     *
     * @param string $content
     * @param bool $escape Whether to escape the content
     * @return self
     */
    public function setContent(string $content, bool $escape = true): self
    {
        $this->content = trim($content);
        $this->escapeContent = $escape;
        return $this;
    }

    /**
     * Get the element's content
     *
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Render the HTML element
     *
     * @return string
     */
    public function render(): string
    {
        $attributes = $this->renderAttributes();
        $content = $this->escapeContent 
            ? htmlspecialchars($this->content, ENT_QUOTES | ENT_HTML5, 'UTF-8')
            : $this->content;

        if (in_array($this->tag, self::VOID_ELEMENTS, true)) {
            return sprintf('<%s%s>', $this->tag, $attributes);
        }

        return sprintf('<%1$s%2$s>%3$s</%1$s>', $this->tag, $attributes, $content);
    }

    /**
     * Render the element's attributes
     *
     * @return string
     */
    private function renderAttributes(): string
    {
        if (empty($this->attributes)) {
            return '';
        }

        $parts = [];
        foreach ($this->attributes as $name => $value) {
            if (is_bool($value)) {
                $parts[] = htmlspecialchars($name, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            } else {
                $parts[] = sprintf('%s="%s"',
                    htmlspecialchars($name, ENT_QUOTES | ENT_HTML5, 'UTF-8'),
                    htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8')
                );
            }
        }

        return ' ' . implode(' ', $parts);
    }

    /**
     * Get string representation of the element
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->render();
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'tag' => $this->tag,
            'attributes' => $this->attributes,
            'content' => $this->content,
            'html' => $this->render()
        ];
    }
} 