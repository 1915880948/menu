<?php

for($i=10;$i<100;$i++){
    if($i%2 == 1){
        $docu[$i] = ['习近平总书记@全体党员，纠正“四风”不能止步', '双十二遇冷：为什么马云再也造不出另一个双十一', '台限制两岸交流添新证据', '自如回应出租房甲醛超标：全力解决问题','美要重返月球 俄泼冷水：拟修国际法禁攫外太空矿藏'][rand(0, 4)];
    }else{
        $docu[$i] = ['健康的5条“警戒线”', '柯洁8天后重返围棋第一 与第二相差仅1分', '美军又哭穷？兰德：美军力不敌中俄或许会输', '网红大瓷瓶引发吐槽乾隆审美','荧光币你见过吗？这种一角钱现在很值钱'][rand(0, 4)];
    }
}
for($i=10;$i<100;$i++){
    if($i%2 == 1){
        $sidebar[$i] = ['风格管理', '职位招聘', '视频', '爱心商城','课程'][rand(0, 4)];
    }else{
        $sidebar[$i] = ['图书馆', '我', '参与抽奖', '主页','积分兑换'][rand(0, 4)];
    }
}
return [
    'project' => [
            "1"=>'项目管理系统',
            "2"=>'合同管理系统',
            "3"=>'仓库管理系统',
            "4"=>'创享客',
            "5"=>'尚酒吧',
            "6"=>'开心英语',
            "7"=>'IF',
            "8"=>'央视财经信息',
            "9"=>'图书馆管理系统'
        ],
    'sidebar' => $sidebar,
    'docu'    => $docu
];