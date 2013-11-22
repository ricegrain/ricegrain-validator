<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * @package  RiceGrain_Validator
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 */

namespace RiceGrain\Validator\Plugin;

class EmailValidator extends Validator
{
    /**
     * @var \RiceGrain\Validator\Rule\EmailRule
     */
    protected $rule;

    /**
     * @var string
     */
    protected $addrSpec;

    /**
     * @var string
     */
    protected $addrSpecForDotBeforeAtmark;

    /**
     * {@inheritDoc}
     */
    public function validate($value)
    {
        $this->generateEmailRegex();

        if (!$this->rule->getAllowDotBeforeAtmark()) {
            $result = preg_match("/^{$this->addrSpec}$/xSD", $value);
        } else {
            $result = preg_match("/^{$this->addrSpecForDotBeforeAtmark}$/xSD", $value);
        }

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    protected function generateEmailRegex()
    {
        $esc        = '\\\\';
        $period     = '\.';
        $space      = '\040';
        $tab        = '\t';
        $openBR     = '\[';
        $closeBR    = '\]';
        $openParen  = '\(';
        $closeParen = '\)';
        $nonASCII   = '\x80-\xff';
        $ctrl       = '\000-\037';
        $crList     = '\n\015';
        $qtext      = "[^$esc$nonASCII$crList\"]";
        $dtext      = "[^$esc$nonASCII$crList$openBR$closeBR]";
        $quotedPair = " $esc [^$nonASCII] ";
        $ctext      = " [^$esc$nonASCII$crList()] ";
        $cnested    = "$openParen$ctext*(?: $quotedPair $ctext* )*$closeParen";
        $comment    = "$openParen$ctext*(?:(?: $quotedPair | $cnested )$ctext*)*$closeParen";
        $x          = "[$space$tab]*(?: $comment [$space$tab]* )*";
        $atomChar   = "[^($space)<>\@,;:\".$esc$openBR$closeBR$ctrl$nonASCII]";
        $atom       = "$atomChar+(?!$atomChar)";
        $quotedStr  = "\"$qtext *(?: $quotedPair $qtext * )*\"";
        $word       = "(?:$atom|$quotedStr)";
        $domainRef  = $atom;
        $domainLit  = "$openBR(?: $dtext | $quotedPair )*$closeBR";
        $subDomain  = "(?:$domainRef|$domainLit)$x";
        $domain     = "$subDomain(?:$period $x $subDomain)*";
        $localPart  = "$word $x(?:$period $x $word $x)*";
        $localPartForDotBeforeAtmark = "$word $x(?:$period $x $word $x|$period)*";

        $this->addrSpec = "$localPart \@ $x $domain";
        $this->addrSpecForDotBeforeAtmark = "$localPartForDotBeforeAtmark \@ $x $domain";
    }
}

/*
 * Local Variables:
 * mode: php
 * coding: utf-8
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * indent-tabs-mode: nil
 * End:
 */
