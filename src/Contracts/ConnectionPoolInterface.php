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

use Laudis\Neo4j\Enum\AccessMode;
use Psr\Http\Message\UriInterface;

/**
 * @template T
 */
interface ConnectionPoolInterface
{
    /**
     * @return T
     */
    public function acquire(UriInterface $uri, AccessMode $mode, AuthenticateInterface $authenticate);
}
