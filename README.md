# elasticSearch-api

# elasticSearch 独立部署服务器  提供写入查询服务接口

 简单写个php微框架提供接口

    支持 命名空间 自动加载 自定义配置 公共函数 验证器 控制器依赖注入

    目录结构:

    ├─elasticSearch        框架系统目录
    │  ├─app               项目运行目录
    │  │  ├─ controller    控制器目录
    │  │  ├─ model         模型目录
    │  │  ├─ validate      验证器目录
    │  ├─common            公共配置目录
    │  │  ├─ indexconfig   单个索引配置目录
    │  │  ├─ common.php    公共函数库
    │  │  ├─ config.php    公共配置
    │  ├─core              核心目录
    │  │  ├─ App.php       执行请求
    │  │  ├─ Config.php    配置类
    │  │  ├─ Error.php     错误异常处理
    │  │  ├─ Loader.php    自动加载
    │  │  ├─ Model.php     模型基类
    │  │  ├─ Request.php   请求
    │  │  ├─ Response.php  响应
    │  ├─lib               第三方类库目录
    │  ├─log               日志
    │  ├─index.php         单一入口




 #  远端调用接口:

             首先配置配置文件
             创建索引类型
             批量添加or更新数据
             查询 直接post(json方式)
             模型基类自动组装成dsl语句
             暂时支持 and like in between 其他需要根据需求扩展

             请求查询参数实例:

             $post_data = [
                     'page' => 2,
                     'limit' => 10,
                     'select' => ['id', 'name','category_ids', 'cat_names', 'brand'],
                     'where' => [
                         'category_ids' => 122,
                         'like' => ['name' => '高级干红葡萄酒'],
                         'in' => ['brand' => [1858, 328], 'country' => [60, 80]],
                         'between' => ['price' => [10, 1000]],
                     ],
                     'order' => ['entity_id' => 'desc'],
             ];
