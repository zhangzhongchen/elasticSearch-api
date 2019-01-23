# elasticSearch-api

 elasticSearch 独立部署服务器  提供写入查询服务接口

 简单写个php微框架 MC 提供接口没有 V 模板层

    支持 命名空间 自动加载 自定义配置 公共函数 验证器 控制器依赖注入

    目录结构:

    ├─elasticSearch 框架系统目录
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
    │  ├─lib               框架类库目录
    │  │  ├─ spl-dsl       sql转dsl类库
    │  ├─log              日志
    │  ├─index.php        单一入口


   spl-dsl(EsParser(原作者:https://github.com/qieangel2013/EsParser) 修改了like查询) 类包目前支持的sql函数

    *  SQL Select
    *  SQL Delete
    *  SQL Update
    *  SQL Where
    *  SQL Order By
    *  SQL Group By
    *  SQL AND
    *  SQL OR (多重or如:((a=1 and b=2) or (c=3 and d=4)) and e=5)
    *  SQL Like
    *  SQL Not Like
    *  SQL Is NULL
    *  SQL Is Not NULL
    *  SQL COUNT distinct
    *  SQL In
    *  SQL Not In
    *  SQL =
    *  SQL !=
    *  SQL <>
    *  SQL avg()
    *  SQL count()
    *  SQL max()
    *  SQL min()
    *  SQL sum()
    *  SQL Between
    *  SQL Aliases
    *  SQL concat_ws
    *  SQL DATE_FORMATE
    *  SQL Having

    远端调用接口:

             首先配置配置文件
             创建索引类型
             批量添加or更新数据
             查询 直接post(json方式) sql字符串 自动解析成dsl语句 返回查询数据
