#!/bin/sh

project=application
projectPrefix=Application

#
# auto create model
# custom config
#
#生成表基础类,默认Tbl为前缀
./yii tools/model \
    --db=db \
    --tableName=* \
    --ns=${project}\\models\\db  \
    --baseClass=\\${project}\\common\\db\\${projectPrefix}ActiveRecord \
    --useTablePrefix=1  \
    --generateLabelsFromComments=1  \
    --tableClassPrefix=tbl \
    --generateQuery=0  \
    --interactive=0 \
    --overwrite=true \

#生成搜索表
#./yii tools/search \
#    --project=fencheng \
#    --modelNs=fencheng\\models\\db \
#    --searchNs=fencheng\\models\\db\\search \
#    --modelPrefixClean=1 \
#    --modelPrefix=Tbl \
#    --searchClassPrefix=search \

#根据Table表生成基础类
./yii tools/basemodel \
    --modelNs=${project}\\models\\db \
    --ns=${project}\\models\\base \
    --interactive=0 \
    --overwrite=true \

./yii cache/flush-all --interactive=0

git add .

echo "dump success \n"


#备份数据库的语句
#./yii --project=cms migrates/backup all
