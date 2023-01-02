## PHP包管理器 PackIt

#### 适用于

- 本地拥有包资源

#### 开始使用

- 在项目的包目录执行`wget https://raw.githubusercontent.com/LianSchedule/PackIt/master/dist/pack -O pack`下载`pack`文件
- 指定本地包资源目录`$packagesDir`[pack文件]，在项目安装包时将从此目录获取
- 在项目的入口文件`include`刚才下载的`pack`文件
- 执行命令安装需要的包

#### 常用命令

- 安装
  - `php pack install package1` (自动安装最高版本的包)
  - `php pack install package1 1.0.0`
- 卸载
  - `php pack uninstall package2` (移除所有版本的该包)
  - `php pack uninstall package2 1.0.0` (仅移除指定版本的该包)

#### 本地包资源目录的结构

```bash
--package1
      |--1.0
      |    |--require.php
      |    |--A.php
      |--2.0 
      |    |--require.php
      |    |--A.php
--package2
      |--1.0
      |    |--require.php
      |    |--B.php
      |--2.0 
      |    |--require.php
      |    |--B.php
```

#### 资源包的命名空间

同一文件、不同版本的命名空间保持一致

```php
file:package1/1.0/A/B.php
namespace package1\A;

file:package1/2.0/A/B.php
namespace package1\A;
```

#### 包中`require.php`的格式

当A包中引用了B包时，建议在该文件`A/1.0/require.php`中指明引用的B包的版本：

- 在安装A包时，将自动安装所需的B包
- 在A包中调用B包时，将自动include该版本的B包文件
- 在移除A包时，如果B包未显式安装，将自动提示您移除B包

```php
//file:A/1.0/require.php
<?php 
return [
    "packages" => [
        "B" => [
            "version" => "1.0"
        ]
    ]
];
```

#### 注意事项

- 为了保证命名空间的一致性，`include package1/1.0/A/B.php`时，将无法同时`include package1/2.0/A/B.php`
- 如果B包调用A@1.0，C包调用A@2.0，则B包、C包都可以正常调用，但是不可以同时调用，也是因为命名空间冲突

#### 进阶用法

- 项目包目录将自动生成`require.php`文件，`defaultVersion`默认为空
  - `defaultVersion`为空时，自动调用最高版本
  - `defaultVersion`不为空时，调用该版本
