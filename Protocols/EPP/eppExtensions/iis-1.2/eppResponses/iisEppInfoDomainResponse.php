<?php

namespace Metaregistrar\EPP;

/*
<extension>
  <iis:infData xmlns:iis="urn:se:iis:xml:epp:iis-1.2" xsi:schemaLocation="urn:se:iis:xml:epp:iis-1.2 iis-1.2.xsd">
      <iis:state>active</iis:state>
      <iis:clientDelete>0</iis:clientDelete>
  </iis:infData>
</extension>
 */

class iisEppInfoDomainResponse extends eppInfoDomainResponse
{
    function __construct()
    {
        parent::__construct();
    }


    /**
     *
     * @return string State
     */
    public function getDomainState()
    {
        $xpath = $this->xPath();
        $result = $xpath->query('/epp:epp/epp:response/epp:extension/iis:infData/iis:state');
        if ($result->length > 0)
        {
            return $result->item(0)->nodeValue;
        }
        else
        {
            return null;
        }
    }


    /**
     *
     * @return 0 or 1
     */
    public function getDomainClientDelete()
    {
        $xpath = $this->xPath();
        $result = $xpath->query('/epp:epp/epp:response/epp:extension/iis:infData/iis:clientDelete');
        if ($result->length > 0)
        {
            return $result->item(0)->nodeValue;
        }
        else
        {
            return null;
        }
    }

    /**
     *
     * @return String
     */
    public function getDomainDeactDate()
    {
        $xpath = $this->xPath();
        $result = $xpath->query('/epp:epp/epp:response/epp:extension/iis:infData/iis:deactDate');
        if ($result->length > 0)
        {
            return $result->item(0)->nodeValue;
        }
        else
        {
            return null;
        }
    }


    /**
     *
     * @return String
     */
    public function getDomainDelDate()
    {
        $xpath = $this->xPath();
        $result = $xpath->query('/epp:epp/epp:response/epp:extension/iis:infData/iis:delDate');
        if ($result->length > 0)
        {
            return $result->item(0)->nodeValue;
        }
        else
        {
            return null;
        }
    }


    public function getKeydata()
    {
        // Check if dnssec is enabled on this interface
        if ($this->findNamespace('secDNS'))
        {
            $xpath = $this->xPath();
            $result = $xpath->query('/epp:epp/epp:response/epp:extension/secDNS:infData/*');
            $keys = array();
            if (count($result) > 0)
            {
                foreach ($result as $keydata)
                {
                    /* @var $keydata \DOMElement */
                    // Check if the keyTag element is present. If not, use getKeys()
                    $test = $keydata->getElementsByTagName('keyTag');
                    if ($test->length > 0)
                    {
                        $secdns = new eppSecdns();
                        $secdns->setKeytag($keydata->getElementsByTagName('keyTag')->item(0)->nodeValue);
                        $secdns->setAlgorithm($keydata->getElementsByTagName('alg')->item(0)->nodeValue);
                        $secdns->setDigestType($keydata->getElementsByTagName('digestType')->item(0)->nodeValue);
                        $secdns->setDigest($keydata->getElementsByTagName('digest')->item(0)->nodeValue);
                        $keys[] = $secdns;
                    }
                }
            }
            return $keys;
        }
        return null;
    }
}
