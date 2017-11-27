# -*- coding: utf-8 -*-
import os
import platform
import time
import re

from fabric.api import *
from fabric.colors import *
from fabric.contrib import project
from fabric.operations import get

# 如果到时候不能直接连接，则需要跳板机。
#env.gateway = '{gateway}'

# 目标服务器
env.hosts = [
    '{nginxHost}',
    '{apacheHost}',
]

# 远程服务器
env.passwords = {
    '{nginxHost}':'{nginxHostPass}',  # 目标服务器密码
    '{apacheHost}':'{apacheHostPass}',  # 目标服务器密码
}

env.roledefs = {
    'root':['{nginxHost}'],
    'web':['{apacheHost}']
}

LOCAL_PATH = os.getcwd()
WEBROOT_PATH = '/server/wwwroot'
WEB_DIRECTORY = '{domainName}'
REMOTE_WEBROOT_PATH = WEBROOT_PATH + "/"+ WEB_DIRECTORY

GIT_REPOSITORITY='{gitRepositority}'

@roles("web")
def init():
    with cd(WEBROOT_PATH):
        run("git clone  "+ GIT_REPOSITORITY + " " + WEB_DIRECTORY );
    with cd(REMOTE_WEBROOT_PATH):
        run("git config credential.helper store --file=.gitstore")
        run("{gitBranch}")
    with cd(WEBROOT_PATH):
        run("chown -R www-data:www-data " + REMOTE_WEBROOT_PATH);
    execute(env);


@roles(["web"])
def apache():
    with cd('/etc/apache2/sites-available'):
        put(LOCAL_PATH+"/deploy/httpd/apache/"+WEB_DIRECTORY+".conf" , WEB_DIRECTORY + '.conf');

@roles(["root"])
def nginx():
    with cd('/etc/nginx/sites-available'):
        put(LOCAL_PATH+"/deploy/httpd/nginx/"+WEB_DIRECTORY+".conf" , WEB_DIRECTORY + '.conf');

@roles(["root"])
def enable_nginx():
    run("ngx-conf -e "+WEB_DIRECTORY+".conf")
    run("service nginx reload")

@roles(['web'])
def enable_apache():
    run("a2ensite "+WEB_DIRECTORY+".conf")
    run("service apache2 reload")


def ls():
    with cd(REMOTE_WEBROOT_PATH):
        run("ls -lah")


@roles(['web'])
def update():
    with cd(REMOTE_WEBROOT_PATH):
        run("git pull")
        run("./yii cache/flush-all");
        run("chown -R www-data:www-data " + REMOTE_WEBROOT_PATH);
    green("update success")

@roles(['web'])
def composer():
    with cd(REMOTE_WEBROOT_PATH):
        run("composer update")
    green("update composer success");

@roles(['web'])
def env():
    with cd(REMOTE_WEBROOT_PATH):
        put(LOCAL_PATH+"/deploy/httpd/env/{domainName}.conf" , '.env');


@roles(['root'])
def reload_nginx():
    run("service nginx reload")

@roles(['web'])
def reload_apache():
    run("service apache2 reload")

@runs_once
def web():
    execute(apache);
    execute(nginx);

@runs_once
def enable():
    execute(enable_apache);
    execute(enable_nginx);

@runs_once
def reload():
    execute(reload_apache);
    execute(reload_nginx);

def server():
    with lcd("{localWebRoot}"):
        local("php -S 0.0.0.0:{localWebPort}");

@roles(['web'])
def yii(func):
    with cd(REMOTE_WEBROOT_PATH):
        run("./yii %s" % func)
        run("chown -R www-data:www-data " + REMOTE_WEBROOT_PATH);

@roles(['web'])
def lang():
    local("./yii translate @application/config/language.php")
    local("git add .")
