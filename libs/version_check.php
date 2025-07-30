<?php

/**
 * Version check utilities for LogHappens
 */

/**
 * Get the current local commit hash
 *
 * @return string|null The current commit hash or null if not available
 */
function getCurrentCommitHash()
{
    $gitHeadFile = ROOT . '.git/HEAD';

    if (!is_file($gitHeadFile)) {
        return null;
    }

    $head = trim(file_get_contents($gitHeadFile));

    // If HEAD points to a ref, read the ref file
    if (strpos($head, 'ref: ') === 0) {
        $ref = substr($head, 5);
        $refFile = ROOT . '.git/' . $ref;

        if (is_file($refFile)) {
            return trim(file_get_contents($refFile));
        }
    }

    // If HEAD contains a direct commit hash
    if (preg_match('/^[a-f0-9]{40}$/', $head)) {
        return $head;
    }

    return null;
}

/**
 * Get the latest commit hash from GitHub API
 *
 * @return string|null The latest commit hash or null if not available
 */
function getLatestGitHubCommit()
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
 * Check if an update is available
 *
 * @return array Array with 'available' boolean and 'current' and 'latest' commit hashes
 */
function checkForUpdates()
{
    $currentHash = getCurrentCommitHash();
    $latestHash = getLatestGitHubCommit();

    return [
        'available' => $currentHash && $latestHash && $currentHash !== $latestHash,
        'current' => $currentHash,
        'latest' => $latestHash,
        'github_url' => 'https://github.com/ToX82/logHappens/'
    ];
}

/**
 * Get version information for display
 *
 * @return array Version information
 */
function getVersionInfo()
{
    $currentHash = getCurrentCommitHash();
    $latestHash = getLatestGitHubCommit();

    return [
        'current' => $currentHash ? substr($currentHash, 0, 7) : 'unknown',
        'latest' => $latestHash ? substr($latestHash, 0, 7) : 'unknown',
        'has_update' => $currentHash && $latestHash && $currentHash !== $latestHash,
        'github_url' => 'https://github.com/ToX82/logHappens/'
    ];
}
