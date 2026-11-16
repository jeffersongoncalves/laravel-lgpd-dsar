<?php

namespace JeffersonGoncalves\LgpdDsar\Enums;

/**
 * Data subject rights (LGPD art. 18).
 */
enum RequestType: string
{
    case Confirmation = 'confirmation';             // I   - confirm processing exists
    case Access = 'access';                         // II  - access the data
    case Correction = 'correction';                 // III - correct incomplete/inaccurate data
    case Anonymization = 'anonymization';           // IV  - anonymize, block or delete unnecessary data
    case Portability = 'portability';               // V   - portability to another provider
    case Deletion = 'deletion';                     // VI  - delete data processed with consent
    case SharingInformation = 'sharing_information'; // VII - who the data was shared with
    case ConsentInformation = 'consent_information'; // VIII - the option to refuse consent and its consequences
    case ConsentRevocation = 'consent_revocation';  // IX  - revoke consent

    /**
     * Types fulfil() handles on its own; the others are answered by hand, then complete().
     */
    public function isAutomatic(): bool
    {
        return in_array($this, [self::Access, self::Portability, self::Anonymization, self::Deletion], true);
    }
}
