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

namespace Laudis\Neo4j\Contracts;

use Ds\Map;
use Ds\Vector;
use Laudis\Neo4j\Databags\Statement;
use Laudis\Neo4j\Databags\StaticTransactionConfiguration;
use Laudis\Neo4j\Exception\Neo4jException;

/**
 * @template T
 */
interface TransactionInterface
{
    /**
     * @param iterable<string, scalar|iterable|null> $parameters
     *
     * @return T
     */
    public function run(string $statement, iterable $parameters = []);

    /**
     * @return T
     */
    public function runStatement(Statement $statement);

    /**
     * @param iterable<Statement> $statements
     *
     * @throws Neo4jException
     *
     * @return Vector<T>
     */
    public function runStatements(iterable $statements): Vector;

    /**
     * @return StaticTransactionConfiguration<T>
     */
    public function getConfiguration(): StaticTransactionConfiguration;

    /**
     * @param callable():float|float $timeout timeout in seconds
     *
     * @return self<T>
     */
    public function withTimeout($timeout): self;

    /**
     * @template U
     *
     * @param callable():FormatterInterface<U>|FormatterInterface<U> $formatter
     *
     * @return self<U>
     */
    public function withFormatter($formatter): self;

    /**
     * @param callable():Map<string, scalar|array|null>|Map<string, scalar|array|null> $metaData
     *
     * @return self<T>
     */
    public function withMetaData($metaData): self;
}
