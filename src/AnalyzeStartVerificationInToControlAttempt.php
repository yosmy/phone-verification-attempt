<?php

namespace Yosmy\Phone;

/**
 * @di\service({
 *     tags: [
 *         'yosmy.phone.start_verification.in',
 *     ]
 * })
 */
class AnalyzeStartVerificationInToControlAttempt implements AnalyzeStartVerificationIn
{
    /**
     * @var Verification\Attempt\IncreaseStarts
     */
    private $increaseStarts;

    /**
     * {@inheritDoc}
     */
    public function analyze(
        string $country,
        string $prefix,
        string $number
    ) {
        try {
            $this->increaseStarts->increase(
                $country,
                $prefix,
                $number
            );
        } catch (VerificationException $e) {
            throw $e;
        }
    }
}