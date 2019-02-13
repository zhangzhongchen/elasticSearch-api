<?php
namespace core;

use core\Config;

abstract class Model
{
    //索引名称(相当于表名)
    public $index;

    //默认查询列表字段
    public $select = ['*'];

    //分页数默认 1
    public $page = 1;

    //要取的条数 同分页条数
    public $limit = 10;

    //where条件 子类重写条件合并
    public $where = [];

    //排序条件
    public $order;

    //dsl语句
    private $dsl;


    function __construct()
    {
        //子类如果没有定义index 默认取子类类名
        if (!$this->index) {
            $class = get_class($this);
            $this->index = strtolower(basename(str_replace('\\', '/', $class)));
        }
    }

    /**
     * 返回要执行的url
     * @return string
     * @throws \Exception
     */
    public function url()
    {
        $host = trim(Config::get('host'), '/');
        $url = $host . '/' . $this->index . '/' . $this->index . '/';
        return $url;
    }

    /**
     * 请求参数自动赋值到属性
     * 生成dsl查询语句
     * @param $query
     * @return string
     * @throws \Exception
     */
    public function getQueryJson($query)
    {
        isset($query['select']) && $this->select($query['select']);
        isset($query['page'])   && $this->page($query['page']);
        isset($query['limit'])  && $this->limit($query['limit']);
        isset($query['where'])  && $this->where($query['where']);
        isset($query['order'])  && $this->order($query['order']);
        $dsl = $this->build();
        return $dsl;
    }

    /**
     * 执行拼接dsl数组
     * @return string
     */
    public function build()
    {
        $this->_select();
        $this->_where();
        $this->_order();
        $this->_page();
        $dsl = json_encode($this->dsl, JSON_UNESCAPED_UNICODE);
        logs('dsl : ' . $dsl, 'request-response.log');
        return $dsl;
    }

    /**
     * @param $select
     * @return $this
     */
    public function select($select)
    {
        $this->select = $select;
        return $this;
    }

    /**
     * @param $where
     * @return $this
     */
    public function where($where)
    {
        $this->where = ($this->where + $where);
        return $this;
    }

    /**
     * @param $page
     * @return $this
     */
    public function page($page)
    {
        $this->page = $page;
        return $this;
    }

    /**
     * @param $limit
     * @return $this
     */
    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @param $order
     * @return $this
     */
    public function order($order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * 拼接查询字段
     */
    protected function _select()
    {
        $this->dsl['_source'] = $this->select;
    }

    /**
     * 拼接where条件
     * 暂时支持 like in between
     */
    protected function _where()
    {
        if ($this->where) {
            foreach ($this->where as $k => $value) {
                $method = '_' . $k;
                if (method_exists($this, $method)) {
                    $this->$method($value);
                } else {
                    $this->_default($k, $value);
                }
                unset($this->where[$k]);
            }
        }
    }

    /**
     * 拼接排序
     */
    protected function _order()
    {
        if ($this->order) {
            $this->dsl['sort'] = $this->order;
        }
    }

    /**
     * 设置分页
     */
    protected function _page()
    {
        $this->dsl['from'] = ($this->page - 1) * $this->limit;
        $this->dsl['size'] = $this->limit;
    }

    /**
     * 范围筛选 (es不支持多字段)
     * @param $value
     */
    protected function _between($value)
    {
        list($gte, $lte) = current($value);
        $this->dsl['query']['bool']['filter'] = ['range' => [key($value) => ['gte' => $gte, 'lte' => $lte]]];
    }

    /**
     * in 查询 (支持多字段)
     * @param $value
     */
    protected function _in($value)
    {
        foreach ($value as $k2 => $v) {
            $this->dsl['query']['bool']['must'][] = ['terms' => [$k2 => $v]];
        }

    }

    /**
     * like (全文搜索)(多字段联查配置文件 'searchBoostList')
     * @param $value
     */
    protected function _like($value)
    {
        $key = key($value);
        $value = current($value);
        if (!Config::getIndex($this->index, 'searchBoostList')) {
            $this->dsl['query']['bool']['must'][] = ['match' => [$key => ['query' => $value]]];
        } else {
            $searchBoostList = Config::getIndex($this->index, 'searchBoostList');
            $i = 0;
            foreach ($searchBoostList as $k2 => $Boost) {
                $where = 'should';
                ($i == 0) && $where = 'must';
                $this->dsl['query']['bool'][$where][]['match'][$k2] = ['query' => $value, 'boost' => $Boost['boost']];
                $i++;
            }
        }
    }

    /**
     * 默认and条件
     * @param $key
     * @param $value
     */
    protected function _default($key, $value)
    {
        $this->dsl['query']['bool']['must'][] = ['term' => [$key => $value]];
    }

}
