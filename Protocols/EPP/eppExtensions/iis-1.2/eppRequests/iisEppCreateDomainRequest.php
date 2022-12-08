<?php
namespace Metaregistrar\EPP;

class iisEppCreateDomainRequest extends eppCreateDomainRequest {

    /**
     * iisEppCreateDomainRequest constructor.
     *
     * @param eppDomain $domain
     */
    public function __construct(eppDomain $domain, bool $verified, $forcehostattr = false, $namespacesinroot=true) {
        parent::__construct($domain, $forcehostattr, $namespacesinroot);
        $this->addVerifiedTag($verified);
        $this->addSessionId();
    }

    public function addVerifiedTag(bool $verified){
        $eid = $this->createElement('iis:eid');
        $eid->setAttribute('verified', $verified ? "true" : "false");
        $this->getExtension()->appendChild($eid);
    }
}
