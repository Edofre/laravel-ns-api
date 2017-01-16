<?php

namespace Edofre\NsApi\Responses;

use SimpleXMLElement;

/**
 * Class Departure
 * @package Edofre\NsApi\Responses
 */
class Departure
{

<RitNummer>14982</RitNummer>
<VertrekTijd>2017-01-16T22:44:00+0100</VertrekTijd>
<EindBestemming>Hilversum</EindBestemming>
<TreinSoort>Sprinter</TreinSoort>
<RouteTekst>Overvecht</RouteTekst>
<Vervoerder>NS</Vervoerder>
<VertrekSpoor wijziging="false">4</VertrekSpoor>
<ReisTip>Stopt niet in Hilversum Media Park en Bussum Zuid</ReisTip>

    function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * @param SimpleXMLElement $xml
     * @return Station
     */
    public static function createFromXml(SimpleXMLElement $xml)
    {
        return new self(
            (string)$xml->Code,
            (string)$xml->Type,
            (array)$xml->Namen,
            (string)$xml->Land,
            (string)$xml->UICCode,
            (string)$xml->Lat,
            (string)$xml->Lon,
            (array)$xml->Synoniemen->Synoniem
        );
    }
}