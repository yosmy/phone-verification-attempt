<?php

namespace Yosmy\Phone\Verification\Attempt;

use Yosmy\Phone;

/**
 * @di\service()
 */
class IncreaseCompletes
{
    /**
     * @var Phone\Verification\ManageAttemptCollection
     */
    private $manageCollection;

    /**
     * @param Phone\Verification\ManageAttemptCollection $manageCollection
     */
    public function __construct(
        Phone\Verification\ManageAttemptCollection $manageCollection
    ) {
        $this->manageCollection = $manageCollection;
    }

    /**
     * @param string $country
     * @param string $prefix
     * @param string $number
     *
     * @throws Phone\VerificationException
     */
    public function increase(
        string $country,
        string $prefix,
        string $number
    ) {
        /** @var Phone\Verification\Attempt $attempt */
        $attempt = $this->manageCollection->findOne([
            'country' => $country,
            'prefix' => $prefix,
            'number' => $number
        ]);

        if ($attempt->getCompletes() == 3) {
            throw new Phone\VerificationException('Haz llegado al número máximo de intentos');
        }

        $this->manageCollection->updateOne(
            [
                'country' => $country,
                'prefix' => $prefix,
                'number' => $number
            ],
            [
                '$inc' => [
                    'completes' => 1
                ]
            ]
        );
    }
}