<?php

namespace Yosmy\Phone;

/**
 * @di\service({
 *     tags: [
 *         'yosmy.phone.complete_verification.in',
 *     ]
 * })
 */
class AnalyzeCompleteVerificationInToControlAttempt implements AnalyzeCompleteVerificationIn
{
    /**
     * @var Verification\Attempt\IncreaseCompletes
     */
    private $increaseCompletes;

    /**
     * {@inheritDoc}
     */
    public function analyze(
        string $country,
        string $prefix,
        string $number
    ) {
        try {
            $this->increaseCompletes->increase(
                $country,
                $prefix,
                $number
            );
        } catch (VerificationException $e) {
            throw $e;
        }
    }
}