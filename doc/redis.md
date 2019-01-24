## 应用场景：
缓存、队列、数据存储

### linux源码安装
安装redis客户端：
去官网下载最新的redis版本：https://redis.io/download

* `# wget http://download.redis.io/releases/redis-4.0.1.tar.gz`
* `# tar zxvf redis-4.0.1.tar.gz`
* `# cd redis-4.0.1`
* `# make`
* `# cd src`
* `# mkdir /usr/local/redis`
* `# mkdir /usr/local/redis/bin`
* `# mkdir /usr/local/redis/conf`
* `# mkdir /usr/local/redis/run`
* `# mkdir /usr/local/redis/log`
* `# cp redis-server /usr/local/redis/bin `
* `# cp redis-cli /usr/local/redis/bin`
* `# cd ..`
* `# cp redis.conf /usr/local/redis/conf/6379.conf`
* `# vim /usr/local/redis/conf/6379.conf`

### 配置redis
`vim 6379.conf`

daemonize yse
pidfile /usr/local/redis/run/redis_6379.pid

logfile /usr/local/redis/log/log_6379.log

redis-server /usr/local/redis/conf/6379.conf & 

`# redis-cli` 

安装redisphp扩展
选择一个稳定版本phpredis :  http://pecl.php.net/package/redis

或者通过phpd的扩展程序pecl下载redis`pecl download redis` ,这里通过官网下载

* `# tar zxvf redis.4.2.0.tgz`
* `# cd redis.4.2.0`
* `# /usr/local/php7/bin/phpize` #用phpize生成configure配置文件
* `./configure --with-php-config=/usr/local/php7/bin/php-config`  #配置
* `make && make install`  #编译、安装

安装完成后会提示redis.so的安装目录，是php的源码编译扩展目录

然后修改php.ini
添加 extension=redis.so 即可