<?php

declare(strict_types=1);
/**
 * This file is part of WebStone\Redkit\Pipe.
 *
 * (C) 2009-2024 Maxim Kirichenko <kirichenko.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WebStone\Redkit;

use WebStone\Redkit\Pipe\ChannelTrait;
use WebStone\Redkit\Pipe\ClusterTrait;
use WebStone\Redkit\Pipe\ConnectionTrait;
use WebStone\Redkit\Pipe\HashTrait;
use WebStone\Redkit\Pipe\HyperLogTrait;
use WebStone\Redkit\Pipe\KeysTrait;
use WebStone\Redkit\Pipe\LatencyTrait;
use WebStone\Redkit\Pipe\ListTrait;
use WebStone\Redkit\Pipe\ScriptTrait;
use WebStone\Redkit\Pipe\ServerTrait;
use WebStone\Redkit\Pipe\SetsTrait;
use WebStone\Redkit\Pipe\SortedTrait;
use WebStone\Redkit\Pipe\StringsTrait;
use WebStone\Redkit\Pipe\TransactionsTrait;

class Client extends ClientAbstract
{
    use ChannelTrait;
    use ClusterTrait;
    use ConnectionTrait;
    use HashTrait;
    use HyperLogTrait;
    use KeysTrait;
    use LatencyTrait;
    use ListTrait;
    use ScriptTrait;
    use ServerTrait;
    use SetsTrait;
    use SortedTrait;
    use StringsTrait;
    use TransactionsTrait;

    protected int $db = 0;

    public function getDb(): int
    {
        return $this->db;
    }

    public function setDb(int $db)
    {
        $this->select($this->db = $db);
    }
}

/* End of file Client.php */
