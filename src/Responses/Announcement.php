<?php

namespace Edofre\NsApi\Responses;

use SimpleXMLElement;

/**
 * Class Announcement
 * @package Edofre\NsApi\Responses
 */
class Announcement
{
    /** @var  string */
    public $id;
    /** @var  boolean */
    public $severity;
    /** @var  TravelSection[] */
    public $announcement;

    /**
     * Announcement constructor.
     * @param $id
     * @param $severity
     * @param $announcement
     */
    function __construct($id, $severity, $announcement)
    {
        $this->id = $id;
        $this->severity = $severity;
        $this->announcement = $announcement;
    }

    /**
     * @param SimpleXMLElement $xml
     * @return Announcement
     */
    public static function createFromXml(SimpleXMLElement $xml)
    {
        return new self(
            (string)$xml->Id,
            (boolean)$xml->Ernstig,
            (string)$xml->Text
        );
    }
}