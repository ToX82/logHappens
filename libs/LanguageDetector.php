<?php

namespace Libs;

/**
 * Language Detection Service
 *
 * Handles browser language detection and language-related utilities.
 */
class LanguageDetector
{
    /**
     * Detects the user's browser language
     *
     * @return string Two-letter language code
     */
    public function getBrowserLanguage(): string
    {
        if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            return 'en';
        }

        return substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    }

    /**
     * Detects the user's full browser language
     *
     * @return string Full language code with region
     */
    public function getFullBrowserLanguage(): string
    {
        if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            return 'en_US';
        }

        return str_replace('-', '_', substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5));
    }

    /**
     * Returns the user's language name (when available)
     *
     * @return string Language name in English
     */
    public function getUserLanguage(): string
    {
        $languages = [
            'nl' => 'Dutch',
            'fr' => 'French',
            'de' => 'German',
            'it' => 'Italian',
            'sp' => 'Spanish',
        ];

        $lang = $this->getBrowserLanguage();
        return $languages[$lang] ?? 'English';
    }

    /**
     * Get available languages
     *
     * @return array Array of supported languages
     */
    public function getAvailableLanguages(): array
    {
        return [
            'nl' => 'Dutch',
            'fr' => 'French',
            'de' => 'German',
            'it' => 'Italian',
            'sp' => 'Spanish',
            'en' => 'English',
        ];
    }
}
