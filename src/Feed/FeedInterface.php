<?php

declare(strict_types=1);

namespace App\Feed;

/**
 * Interface FeedInterface
 * @package App\Feed
 */
interface FeedInterface
{
    public function readFeedSource(): void;

    /**
     * @return array
     */
    public function getData(): array;

    /**
     * @return string
     */
    public function getFeedUrl(): string;
}