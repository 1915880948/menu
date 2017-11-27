#!/usr/bin/env bash

#线上与线下对比，看看是否有字段变更（生成的sql，在本地运行）
#./protected/bin/mysql-schema-sync -conf ./protected/apps/application/datas/online2local.json 2>/dev/null >./protected/apps/application/datas/migrations/online2local.sql
#线下与线上对比，看看是否要增加字段（生成的Sql，在线上PMA运行）
./protected/bin/mysql-schema-sync -conf ./protected/apps/application/datas/local2online.json 2>/dev/null >./protected/apps/application/datas/migrations/local2online.sql


