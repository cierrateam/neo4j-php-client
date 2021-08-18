<?php

declare(strict_types=1);

/*
 * This file is part of the Laudis Neo4j package.
 *
 * (c) Laudis technologies <http://laudis.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Laudis\Neo4j\TestkitBackend;

use Ds\Map;
use Iterator;
use IteratorAggregate;
use Laudis\Neo4j\Contracts\DriverInterface;
use Laudis\Neo4j\Contracts\SessionInterface;
use Laudis\Neo4j\Contracts\UnmanagedTransactionInterface;
use Laudis\Neo4j\Databags\SummarizedResult;
use Laudis\Neo4j\TestkitBackend\Contracts\TestkitResponseInterface;
use Symfony\Component\Uid\Uuid;

final class MainRepository
{
    /** @var Map<string, DriverInterface> */
    private Map $drivers;
    /** @var Map<string, SessionInterface> */
    private Map $sessions;
    /** @var Map<string, SummarizedResult|TestkitResponseInterface> */
    private Map $records;
    /** @var Map<string, Iterator> */
    private Map $recordIterators;
    /** @var Map<string, UnmanagedTransactionInterface> */
    private Map $transactions;

    public function __construct(Map $drivers, Map $sessions, Map $records, Map $transactions)
    {
        $this->drivers = $drivers;
        $this->sessions = $sessions;
        $this->records = $records;
        $this->transactions = $transactions;
        $this->recordIterators = new Map();
    }

    public function addDriver(Uuid $id, DriverInterface $driver): void
    {
        $this->drivers->put($id->toRfc4122(), $driver);
    }

    public function removeDriver(Uuid $id): void
    {
        $this->drivers->remove($id->toRfc4122());
    }

    public function getIterator(Uuid $id): Iterator
    {
        return $this->recordIterators->get($id->toRfc4122());
    }

    public function getDriver(Uuid $id): DriverInterface
    {
        return $this->drivers->get($id->toRfc4122());
    }

    public function addSession(Uuid $id, SessionInterface $session): void
    {
        $this->sessions->put($id->toRfc4122(), $session);
    }

    public function removeSession(Uuid $id): void
    {
        $this->sessions->remove($id->toRfc4122());
    }

    public function getSession(Uuid $id): SessionInterface
    {
        return $this->sessions->get($id->toRfc4122());
    }

    /**
     * @param Uuid $id
     * @param SummarizedResult|TestkitResponseInterface $result
     */
    public function addRecords(Uuid $id, $result): void
    {
        $this->records->put($id->toRfc4122(), $result);
        if ($result instanceof IteratorAggregate) {
            $this->recordIterators->put($id->toRfc4122(), $result->getResult()->getIterator());
        }
    }

    public function removeRecords(Uuid $id): void
    {
        $this->records->remove($id->toRfc4122());
    }

    /**
     * @return SummarizedResult|TestkitResponseInterface
     */
    public function getRecords(Uuid $id)
    {
        return $this->records->get($id->toRfc4122());
    }

    public function addTransaction(Uuid $id, UnmanagedTransactionInterface $transaction): void
    {
        $this->transactions->put($id->toRfc4122(), $transaction);
    }

    public function removeTransaction(Uuid $id): void
    {
        $this->transactions->remove($id->toRfc4122());
    }

    public function getTransaction(Uuid $id): UnmanagedTransactionInterface
    {
        return $this->transactions->get($id->toRfc4122());
    }
}
