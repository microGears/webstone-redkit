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

class QueueMessage extends Request implements QueueMessageInterface
{
    static int $offset = 0;

    public static function createId(): string
    {
        return md5(uniqid(__CLASS__, true) . '-' . ++self::$offset);
    }

    public function getId(): string
    {
        if (!$this->hasAttribute('id')) {
            $this->setAttribute('id', self::createId());
        }

        return (string)$this->getAttribute('id', false);
    }

    public function setId(string $id): self
    {
        $this->setAttribute('id', $id);
        return $this;
    }
}

/* End of file QueueMessage.php */
