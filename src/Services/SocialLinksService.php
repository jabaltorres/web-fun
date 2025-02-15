<?php
declare(strict_types=1);

namespace Fivetwofive\KrateCMS\Services;

use Fivetwofive\KrateCMS\Models\KrateSettings;
use Fivetwofive\KrateCMS\Core\Helpers\HtmlHelper;

class SocialLinksService
{
    private KrateSettings $settings;
    private HtmlHelper $htmlHelper;

    public function __construct(KrateSettings $settings, HtmlHelper $htmlHelper)
    {
        $this->settings = $settings;
        $this->htmlHelper = $htmlHelper;
    }

    public function displayLinks(): string
    {
        $socialSettings = [
            'Facebook' => 'social_facebook',
            'Instagram' => 'social_instagram',
            'LinkedIn' => 'social_linkedin'
        ];

        $links = array_reduce(
            array_keys($socialSettings),
            function(array $carry, string $platform) use ($socialSettings): array {
                $url = $this->settings->getSetting($socialSettings[$platform]);
                if ($url) {
                    $carry[] = sprintf(
                        '<li><a href="%s" target="_blank" rel="noopener noreferrer">%s</a></li>',
                        $this->htmlHelper->escape($url),
                        $this->htmlHelper->escape($platform)
                    );
                }
                return $carry;
            },
            []
        );

        return $links ? sprintf('<ul class="social-links">%s</ul>', implode('', $links)) : '';
    }
} 