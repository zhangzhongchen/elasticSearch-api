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
              "ptoduct_tags": {
                "type": "text",
                "analyzer": "ik_smart",
                "search_analyzer": "ik_smart"
              },
              "cat_names": {
                "type": "text",
                "analyzer": "ik_smart",
                "search_analyzer": "ik_smart"
              },
              "brand_value": {
                "type": "text",
                "analyzer": "ik_smart",
                "search_analyzer": "ik_smart"
              },
              "country_value": {
                "type": "text",
                "analyzer": "ik_smart",
                "search_analyzer": "ik_smart"
              },
              "category_ids": {
                "type": "text",
                "analyzer": "douhao",
                "search_analyzer": "douhao"
              },
                "entity_id": {
                "type": "integer"
              },
                "brand": {
                "type": "integer"
              },
                "entity_type_id": {
                "type": "integer"
              },
                "attribute_set_id": {
                "type": "integer"
              },
                "status": {
                "type": "integer"
              },
                "visibility": {
                "type": "integer"
              },
                "vendor_code": {
                "type": "integer"
              },
                "country": {
                "type": "integer"
              },
                "sale_amount": {
                "type": "integer"
              },
                "price": {
                "type": "float"
              },
                "special_price": {
                "type": "float"
              },
                "cost": {
                "type": "float"
              },
                "is_in_stock": {
                "type": "integer"
              },
                "is_salable": {
                "type": "integer"
              },
                "qty": {
                "type": "integer"
              },
                "special_from_date": {
                "type": "date",
                "format": "yyyy-MM-dd HH:mm:ss||yyyy-MM-dd||epoch_millis"
              },
                "news_from_date": {
                "type": "date",
                "format": "yyyy-MM-dd HH:mm:ss||yyyy-MM-dd||epoch_millis"
              },
                "created_at": {
                "type": "date",
                "format": "yyyy-MM-dd HH:mm:ss||yyyy-MM-dd||epoch_millis"
              },
                "updated_at": {
                "type": "date",
                "format": "yyyy-MM-dd HH:mm:ss||yyyy-MM-dd||epoch_millis"
              },
                "news_to_date": {
                "type": "date",
                "format": "yyyy-MM-dd HH:mm:ss||yyyy-MM-dd||epoch_millis"
              },
                "custom_design_from": {
                "type": "date",
                "format": "yyyy-MM-dd HH:mm:ss||yyyy-MM-dd||epoch_millis"
              },
                "custom_design_to": {
                "type": "date",
                "format": "yyyy-MM-dd HH:mm:ss||yyyy-MM-dd||epoch_millis"
              },
                "snapping": {
                "type": "date",
                "format": "yyyy-MM-dd HH:mm:ss||yyyy-MM-dd||epoch_millis"
              },
                "custom_update_time": {
                "type": "date",
                "format": "yyyy-MM-dd HH:mm:ss||yyyy-MM-dd||epoch_millis"
              }
         }
     }',
    //查询时 关联字段 权重
    'searchBoostList' => [
        //第一个字段默认 must(同where条件中的and) 防止or都不满足词语也会查询出来
        'cat_names' => ['boost' => 6],
        'ptoduct_tags' => ['boost' => 5],
        'brand_value' => ['boost' => 4],
        'country_value' => ['boost' => 3],
        'name' => ['boost' => 2],
    ]
];
