<?php

namespace Libs;

/**
 * Flash message helper
 *
 * Stores one-time messages in session and retrieves them for rendering.
 */
class Flash
{
    /** @var string */
    private const SESSION_KEY = '__flash_messages__';

    /**
     * Add a flash message
     *
     * @param string $message Message text
     * @param string $type    one of: success, info, warning, error
     * @param array<string,mixed> $options Extra options (e.g., title)
     * @return void
     */
    public static function add(string $message, string $type = 'info', array $options = []): void
    {
        if (!isset($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = [];
        }

        $_SESSION[self::SESSION_KEY][] = [
            'message' => $message,
            'type' => $type,
            'options' => $options,
        ];
    }

    /**
     * Get and clear all flash messages
     *
     * @return array<int, array{message:string,type:string,options:array<string,mixed>}> Messages
     */
    public static function consume(): array
    {
        if (empty($_SESSION[self::SESSION_KEY]) || !is_array($_SESSION[self::SESSION_KEY])) {
            return [];
        }

        $messages = $_SESSION[self::SESSION_KEY];
        unset($_SESSION[self::SESSION_KEY]);
        return $messages;
    }
}
