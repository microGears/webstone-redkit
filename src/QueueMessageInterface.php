<?php

declare(strict_types=1);
/**
 * This file is part of WebStone\Redkit.
 *
 * (C) 2009-2024 Maxim Kirichenko <kirichenko.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WebStone\Redkit;

interface QueueMessageInterface
{
    public function getId():string;
}
