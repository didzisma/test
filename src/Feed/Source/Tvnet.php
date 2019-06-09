<?php

declare(strict_types=1);

namespace App\Feed\Source;

use App\Feed\FeedReader;

/**
 * Class Tvnet
 * @package App\Feed\Source
 */
class Tvnet extends FeedReader
{
    /**
     * @return string
     */
    public function getFeedUrl(): string
    {
        return 'https://www.tvnet.lv/rss';
    }

    /**
     * @return string
     */
    protected function getImageNodeName(): string
    {
        return 'enclosure,url';
    }

    public function readFeedSource(): void
    {
        $feed = \simplexml_load_file($this->getFeedUrl());

        $counter = 1;
        foreach ($feed->{$this->getChannelNodeName()}->{$this->getItemNodeName()} as $item) {
            if ($counter > $this->getItemCount()) break;

            $this->prepareData($item);
            $counter++;
        }
    }
}
