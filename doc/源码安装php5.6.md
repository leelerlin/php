#源码安装php5.6
##解压php
`tar zxvf php-5.6.38.tar.gz`
`cd php-5.6.38`

##安装必要的扩展
`yum -y install libcurl-devel openssl-devel`
`yum -y install libXpm-devel`
`yum -y install libxml2-devel`
`yum -y  install  gcc gcc-c++`

##初始化配置
`./configure --prefix=/usr/local/php --with-config-file-path=/usr/local/php/etc  --with-openssl  --with-curl --enable-ctype`

##编译安装
`make && make install`

##复制php.ini文件
`cp php.ini-development /usr/local/php/lib/php.ini`

##软件php命令行
`ln -s /usr/local/php/bin/php /usr/bin/php`

##查看版本和扩展
`php -v`
`php -m`