<?php

namespace src\Script;

use src\Script;
use src\System\Database;
use src\Util\Logger;
use src\Util\Parser;

class GetBlock extends Script
{
    public function _process()
    {
        echo PHP_EOL;

        $transactions = $this->GetBlock();

        foreach ($transactions as $transaction) {
            Logger::EchoLog($transaction);
        }
    }

    public function GetBlock()
    {
        $db = Database::GetInstance();

        $namespace = 'saseul_committed.blocks';
        $filter = [];
        $opt = ['sort' => ['timestamp' => -1]];
        $rs = $db->Query($namespace, $filter, $opt);

        $max = 5;
        $count = 0;
        $transactions = [];

        foreach ($rs as $item) {
            $item = Parser::obj2array($item);
            unset($item['_id']);

            $transactions[] = $item;
            $count = $count + 1;

            if ($count >= $max) {
                break;
            }
        }

        return $transactions;
    }
}
