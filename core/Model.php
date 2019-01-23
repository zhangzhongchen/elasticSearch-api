<?php
namespace core;

use core\Config;

class Model
{

    /**
     * 返回要执行的url
     * @return string
     * @throws \Exception
     */
    public function url()
    {
        $indexName = $this->getIndex();
        if (!$host = Config::get('host')) {
            throw new \Exception('host Undefined!');
        }
        $host = trim($host, '/');
        $url = $host . '/' . $indexName . '/' . $indexName . '/';
        return $url;
    }

    /**
     * 获取index
     * @return string
     */
    public function getIndex()
    {
        $class = get_class($this);
        $indexName = strtolower(basename(str_replace('\\', '/', $class)));
        return $indexName;
    }

    /**
     * @param $sql
     * @return string
     * @return string
     */
    public function getDsl($sql)
    {
        include ROOT . 'lib/sql-dsl/EsParser.php';
        $url = $this->url() . '_search';
        $index = $this->getIndex();
        $es_config = [
            'index' => $index,
            'type' => $index,
            'url' => $url,
            'version' => "6.5"
        ];
        $parser = new \EsParser($sql, true, $es_config);
        return $parser->explain();
    }
}
