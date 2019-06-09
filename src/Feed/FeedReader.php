<?php

declare(strict_types=1);

namespace App\Feed;

/**
 * Class FeedReader
 * @package App\Feed
 */
abstract class FeedReader implements FeedInterface
{
    /**
     * @var array
     */
    protected $feedData = [];

    /**
     * @return int
     */
    protected function getItemCount(): int
    {
        return 5;
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return 'homepage/news.html.twig';
    }

    /**
     * @return string
     */
    public function getFeedUrl(): string
    {
        return '';
    }

    /**
     * @return string
     */
    protected function getChannelNodeName(): string
    {
        return 'channel';
    }

    /**
     * @return string
     */
    protected function getItemNodeName(): string
    {
        return 'item';
    }

    /**
     * @return string
     */
    protected function getTitleNodeName(): string
    {
        return 'title';
    }

    /**
     * @return string
     */
    protected function getDescriptionNodeName(): string
    {
        return 'description';
    }

    /**
     * @return string
     */
    protected function getLinkNodeName(): string
    {
        return 'link';
    }

    /**
     * @return string
     */
    protected function getImageNodeName(): string
    {
        return 'image';
    }

    /**
     * @param \SimpleXMLElement $xmlNode
     * @param string $itemName
     * @return string
     */
    protected function getNodeValue(\SimpleXMLElement $xmlNode, string $itemName): string
    {
        $itemDescription = explode(',', $itemName);
        if (\key_exists(1, $itemDescription)) {
            return  $xmlNode->{$itemDescription[0]}[$itemDescription[1]]->__toString();
        }

        return $xmlNode->{$itemDescription[0]}->__toString();
    }


    /**
     * @param \SimpleXMLElement $xmlNode
     */
    protected function prepareData(\SimpleXMLElement $xmlNode): void
    {
        $this->feedData[] = [
            'title' => $this->getNodeValue($xmlNode, $this->getTitleNodeName()),
            'description' => $this->getNodeValue($xmlNode, $this->getDescriptionNodeName()),
            'link' => $this->getNodeValue($xmlNode, $this->getLinkNodeName()),
            'image' => $this->getNodeValue($xmlNode, $this->getImageNodeName())
        ];
    }


    /**
     * @return array
     */
    public function getData(): array
    {
        $this->readFeedSource();

        return $this->feedData;
    }
}
