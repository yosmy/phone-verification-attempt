<?php

namespace Yosmy\Phone\Verification;

/**
 * @di\service({
 *     private: true
 * })
 */
class ResetAttempt
{
    /**
     * @var ManageAttemptCollection
     */
    private $manageCollection;

    /**
     * @param ManageAttemptCollection $manageCollection
     */
    public function __construct(
        ManageAttemptCollection $manageCollection
    ) {
        $this->manageCollection = $manageCollection;
    }

    /**
     * @param string $country
     * @param string $prefix
     * @param string $number
     */
    public function reset(
        string $country,
        string $prefix,
        string $number
    ) {
        $this->manageCollection->updateOne(
            [
                'country' => $country,
                'prefix' => $prefix,
                'number' => $number,
            ],
            [
                '$set' => [
                    'starts' => 0,
                    'completes' => 0
                ]
            ]
        );
    }
}