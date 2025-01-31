<?php
declare(strict_types=1);

namespace Fivetwofive\KrateCMS;

/**
 * Class AudioElement
 * Represents an HTML5 audio element with configurable attributes
 */
class AudioElement
{
    private const ALLOWED_TYPES = [
        'audio/mpeg',
        'audio/ogg',
        'audio/wav'
    ];

    private string $title;
    private string $source;
    private string $type;
    private bool $autoplay = false;
    private bool $loop = false;

    /**
     * AudioElement constructor
     *
     * @param string $title The title of the audio element
     * @param string $source The source URL of the audio file
     * @param string $type The MIME type of the audio file
     * @throws \InvalidArgumentException If the audio source is empty or the audio type is not supported
     */
    public function __construct(string $title, string $source, string $type)
    {
        if (empty($source)) {
            throw new \InvalidArgumentException('Audio source cannot be empty');
        }
        
        $this->validateType($type);
        
        $this->title = $title;
        $this->source = $this->sanitizeUrl($source);
        $this->type = $type;
    }

    /**
     * Set whether the audio should autoplay
     *
     * @param bool $autoplay
     * @return self
     */
    public function setAutoplay(bool $autoplay): self
    {
        $this->autoplay = $autoplay;
        return $this;
    }

    /**
     * Set whether the audio should loop
     *
     * @param bool $loop
     * @return self
     */
    public function setLoop(bool $loop): self
    {
        $this->loop = $loop;
        return $this;
    }

    /**
     * Render the audio element as HTML
     *
     * @return string
     */
    public function render(): string
    {
        $autoplay = $this->autoplay ? ' autoplay' : '';
        $loop = $this->loop ? ' loop' : '';
        
        return sprintf(
            '<div class="audio-player-wrapper">
                <h4 class="audio-title mb-2">%s</h4>
                <audio controls%s%s>
                    <source src="%s" type="%s">
                    Your browser does not support the audio element.
                </audio>
            </div>',
            htmlspecialchars($this->title),
            $autoplay,
            $loop,
            htmlspecialchars($this->source),
            htmlspecialchars($this->type)
        );
    }

    /**
     * Validate the audio type
     *
     * @param string $type
     * @throws \InvalidArgumentException
     */
    private function validateType(string $type): void
    {
        if (!in_array($type, self::ALLOWED_TYPES)) {
            throw new \InvalidArgumentException(
                sprintf('Unsupported audio type: %s. Allowed types are: %s',
                    $type,
                    implode(', ', self::ALLOWED_TYPES)
                )
            );
        }
    }

    /**
     * Sanitize the URL
     *
     * @param string $url
     * @return string
     * @throws \InvalidArgumentException
     */
    private function sanitizeUrl(string $url): string
    {
        $sanitizedUrl = filter_var($url, FILTER_SANITIZE_URL);
        
        if (!filter_var($sanitizedUrl, FILTER_VALIDATE_URL) && !$this->isValidLocalPath($sanitizedUrl)) {
            throw new \InvalidArgumentException('Invalid audio source URL or path provided');
        }

        return $sanitizedUrl;
    }

    /**
     * Check if the path is a valid local file path
     *
     * @param string $path
     * @return bool
     */
    private function isValidLocalPath(string $path): bool
    {
        // Add your local path validation logic here
        return (bool) preg_match('/^[\/\w\-. ]+$/', $path);
    }

    /**
     * Get string representation of the audio element
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->render();
    }
}