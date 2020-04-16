<?php

namespace Yosmy\Phone\Verification;

use Yosmy\Mongo\DuplicatedKeyException;
use LogicException;

/**
 * @di\service()
 */
class ResolveAttempt
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
     *
     * @return Attempt
     */
    public function resolve(
        string $country,
        string $prefix,
        string $number
    ) {
        /** @var Attempt $attempt */
        $attempt = $this->manageCollection->findOne([
            'country' => $country,
            'prefix' => $prefix,
            'number' => $number,
        ]);

        if (!$attempt) {
            $id = uniqid();
            $starts = 0;
            $completes = 0;

            try {
                $this->manageCollection->insertOne([
                    '_id' => $id,
                    'country' => $country,
                    'prefix' => $prefix,
                    'number' => $number,
                    'starts' => $starts,
                    'completes' => $completes
                ]);
            } catch (DuplicatedKeyException $e) {
                throw new LogicException(null, null, $e);
            }

            return new Attempt([
                'id' => $id,
                'country' => $country,
                'prefix' => $prefix,
                'number' => $number,
                'starts' => $starts,
                'completes' => $completes
            ]);
        }

        return $attempt;
    }
}