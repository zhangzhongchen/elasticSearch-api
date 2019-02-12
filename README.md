# elasticSearch-api

 elasticSearch 独立部署服务器  提供写入查询服务接口

 简单写个php微框架 MC 提供接口没有 V 模板层

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
    │  ├─lib               框架类库目录
    │  │  ├─ spl-dsl       sql转dsl类库
    │  ├─log               日志
    │  ├─index.php         单一入口

