<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\database\tables;

use DinoVNOwO\Base\exceptions\TableException;
use DinoVNOwO\Base\Initial;

class Table{

    protected $queries = [];

    public function __construct(array $queries){
        if(!isset($queries[TableData::INSERT])){
            throw new TableException("Missing queries with name 'INSERT'");
        }elseif(!isset($queries[TableData::UPDATE])){
            throw new TableException("Missing queries with name 'UPDATE'");
        }elseif(!isset($queries[TableData::FIND])){
            throw new TableException("Missing queries with name 'FIND'");
        }
        if(!is_array($queries[TableData::INSERT])){
            throw new TableException("Queries with name 'INSERT' is not a list/array of query");
        }elseif(!is_array($queries[TableData::UPDATE])){
            throw new TableException("Queries with name 'UPDATE' is not a list/array of query");
        }elseif(!is_array($queries[TableData::FIND])){
            throw new TableException("Queries with name 'FIND' is not a list/array of query");
        }
        /* Filtering unnecessary values */
        $this->queries[TableData::INSERT] = $queries[TableData::INSERT];
        $this->queries[TableData::UPDATE] = $queries[TableData::UPDATE];
        $this->queries[TableData::FIND] = $queries[TableData::FIND];
    }

    public function insert($queryindex, array $args, callable $onSuccess = null, callable $onError = null, bool $existCheck = false) : void{
        if($existCheck){
            $this->find(0, $args, 
            function(array $data) use($queryindex, $args, $onSuccess, $onError) : void{
                if($data !== []){
                    return;
                }
                Initial::getDatabaseManager()->getConnection()->executeInsert($this->queries[TableData::INSERT][$queryindex], $args, $onSuccess, $onError);
            }, null);
        }else{
            Initial::getDatabaseManager()->getConnection()->executeInsert($this->queries[TableData::INSERT][$queryindex], $args, $onSuccess, $onError);
        }
    }

    public function find($queryindex, array $args, callable $onSuccess = null, callable $onError = null) : void{
        Initial::getDatabaseManager()->getConnection()->executeSelect($this->queries[TableData::FIND][$queryindex], $args, $onSuccess, $onError);
    }

    public function update($queryindex, array $args, callable $onSuccess = null, callable $onError = null) : void{
        Initial::getDatabaseManager()->getConnection()->executeChange($this->queries[TableData::UPDATE][$queryindex], $args, $onSuccess, $onError);
    }
} 