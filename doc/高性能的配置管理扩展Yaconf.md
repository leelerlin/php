## 现有问题
* php配置文件过多，配置文件较大，解析配置文件会影响性能（用opcache可以解决，但也需要有执行过程）
* 除了php的配置文件，还有json等配置文件的可读性差,还需要额外的解析时间
* 配置文件一般会与代码耦合在一起，会有安全隐患（如数据库配置）,其次如果配置和代码属于一个项目，这会导致修改配置也要走上线流程
* 一些资源配置文件, 比如mysql/memcache的配置信息, 这些内容本来是应该对开发透明的, 运维直接负责即可. 但是放到了代码中就会导致, 运维如果要发起一些变更, 也要开发配合修改配置文件上线.

## Yaconf的作用
yaconf就可以解决以上问题
1. 它使用单独的一个配置目录(在yaconf.directory指定), 不和代码在一起.
2. 它在PHP启动的时候, 处理所有的要处理的配置, 然后这些配置就会常驻内存, 随着PHP的生命周期存亡. 避免了每次请求的时候解析配置文件.
3. 所有的配置内容都是immutable的, 这就可以借助于Fork的COW, 降低内存占用, 并且在访问配置的时候, 几乎不需要任何的内存Copy, 也不会有无谓的引用计数增减
4. 最重要的, 配置目录和代码分离以后, 可以借助一个配置管理后台, 来实现配置的统一化管理.
5. 它支持(对于非ZTS)配置变更重新加载, 也就是说配置如果有变化(建议更改配置一定使用mv, 不要使用cp), 它会reload, 不需要重启(检测的频率由yaconf.check_delay控制).
6. 它支持丰富的配置类型, 包括字符串, 数组, 分节, 分节继承, 并且还可以在配置中直接写PHP的常量和环境变量等.
7. 最重要的是, 它很简单.

## 安装方法
去https://pecl.php.net/下载yaconf扩展安装即可

## Yaconf的配置项
* yaconf.directory 配置文件目录, 这个配置不能通过ini_set指定, 因为必须在PHP启动的时候就确定好.
* yaconf.check_delay 多久(秒)检测一次文件变动, 如果是0就是不检测, 也就是说如果是0的时候, 文件变更只能通过重启PHP重新加载

## Yaconf提供的方法
* mixed Yaconf::get(string $name, mixed $default = NULL) 这个是获取一个配置, 名字是配置的名字, 一般来说如果你有一个ini文件叫做foo.ini, 那么$name使用foo的话就会获取到这个文件内的所有内容, 以数组形式返回. default是当配置不存在的时候返回的默认值.
* bool Yaconf::has(string $name) 这个是检测一个配置是否存在.

## 配置的格式
Yaconf采用ini文件作为配置文件, 这是因为我一直觉得ini是最适合做配置文件的, key-value格式, 清晰可读.

简单的配置写起来如下(以下全部假设ini文件的名字是test):
```
foo="bar"
phpversion=PHP_VERSION
env=${HOME}

;索引数组
arr[]=1
arr.1=2

;关联数组
map.foo=bar
map.bar=foo
 
;你可以使用分号来写注释
map2.foo.name=yaconf
map2.foo.year=2015

; 分节继承
[parent]
parent="base"
children="NULL"
leeler=123
 
[children : parent]
children="children"
;请注意配置的分节继承的语法 children:(冒号)parent, 这的意思是children节继承全部base的配置项. 然后你在children节里面定义的和parent节中同名的配置, 会覆盖掉parent中定义的内容.
;Yaconf::get("test.children.children");
;Yaconf::get("test.children.leeler");
```

## 注意事项
首先, 假设我们的所有的配置文件都放置在/tmp/yaconf中, 那么我们就需要在php.ini中增加如下配置:
```
yaconf.directory=/tmp/yaconf
```
这样yaconf在PHP启动的时候, 就会在这个目录下找所有的*.ini文件, 然后尝试处理他们. 这里要注意的是不支持多级目录, 也就是说, yaconf只会处理yaconf.directory内的*.ini文件, 不会处理子目录里面的(这主要是为了简单考虑, 因为有分节, 你就可以一个项目定义一个ini文件).

## 总结
自己动手搭一下，非常简单。


