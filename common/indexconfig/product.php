<?php
//索引配置(相当于表名称)
return [
    //创建索引是自定义分词器 逗号分词器 用于category_ids分类查询
    'customIndex' => '{"settings": {"analysis": {"analyzer": {"douhao": {"type": "pattern","pattern": ","}}}}}',
    /*
     * 创建类型时 各字段类型与分词器设置
     * ik_max_word 尽可能多的拆分出词语
     * ik_smart 已被分出的词语将不会再次被其它词语占有
     * douhao category_ids 使用的自定义分词器
     */
    'customWord' => '{
         "properties": {
              "name": {
                "type": "text",
                "analyzer": "ik_max_word",
                "search_analyzer": "ik_max_word"
              },
              "cat_names": {
                "type": "text",
                "analyzer": "ik_smart",
                "search_analyzer": "ik_smart"
              },
              "category_ids": {
                "type": "text",
                "analyzer": "douhao",
                "search_analyzer": "douhao"
              },
                "created_at": {
                "type": "date",
                "format": "yyyy-MM-dd HH:mm:ss||yyyy-MM-dd||epoch_millis"
              }

         }
     }',

    //查询时 关联字段 权重
    'searchBoostList' => [
        //第一个字段默认 must(同where条件中的and) 防止or都不满足词语也会查询出来
        'name' => ['boost' => 6],
        'cat_names' => ['boost' => 5],
    ]
];
