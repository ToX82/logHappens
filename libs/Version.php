<?php

namespace Libs;

/**
 * Version and update related helpers.
 */
class Version
{
    /**
     * Get the current local commit hash.
     *
     * @return string|null
     */
    public static function getCurrentCommitHash(): ?string
    {
        $gitHeadFile = ROOT . '.git/HEAD';

        if (!is_file($gitHeadFile)) {
            return null;
        }

        $head = trim((string)file_get_contents($gitHeadFile));

        if (strpos($head, 'ref: ') === 0) {
            $ref = substr($head, 5);
            $refFile = ROOT . '.git/' . $ref;

            if (is_file($refFile)) {
                return trim((string)file_get_contents($refFile));
            }
        }

        if (preg_match('/^[a-f0-9]{40}$/', $head)) {
            return $head;
        }

        return null;
    }

    /**
     * Get the latest commit hash from GitHub API.
     *
     * @return string|null
     */
    public static function getLatestGitHubCommit(): ?string
    {
        $apiUrl = 'https://api.github.com/repos/ToX82/logHappens/commits';

        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => [
                    'User-Agent: LogHappens/1.0',
                    'Accept: application/vnd.github.v3+json'
                ],
                'timeout' => 10
            ]
        ]);

        $response = @file_get_contents($apiUrl, false, $context);

        if ($response === false) {
            return null;
        }

        $data = json_decode($response, true);

        if (is_array($data) && isset($data[0]['sha'])) {
            return $data[0]['sha'];
        }

        return null;
    }

    /**
     * Check if an update is available.
     *
     * @return array{available: bool, current: ?string, latest: ?string, github_url: string}
     */
    public static function checkForUpdates(): array
    {
        $currentHash = self::getCurrentCommitHash();
        $latestHash = self::getLatestGitHubCommit();

        return [
            'available' => $currentHash && $latestHash && $currentHash !== $latestHash,
            'current' => $currentHash,
            'latest' => $latestHash,
            'github_url' => 'https://github.com/ToX82/logHappens/'
        ];
    }

    /**
     * Get version information for display.
     *
     * @return array{current: string, latest: string, has_update: bool, github_url: string}
     */
    public static function getVersionInfo(): array
    {
        $currentHash = self::getCurrentCommitHash();
        $latestHash = self::getLatestGitHubCommit();

        return [
            'current' => $currentHash ? substr($currentHash, 0, 7) : 'unknown',
            'latest' => $latestHash ? substr($latestHash, 0, 7) : 'unknown',
            'has_update' => $currentHash && $latestHash && $currentHash !== $latestHash,
            'github_url' => 'https://github.com/ToX82/logHappens/'
        ];
    }
}
