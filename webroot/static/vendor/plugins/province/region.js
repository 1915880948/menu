//地区数据是采集于淘宝的，保证是最全的
//作者：潘敬
//2014年2月10日 10:41:43
//QQ：599194993
//
var _is_append=false;
var index=0;
function Region(){
    this.param={
        elem: null,	//将select追加到指定的容器
        elems: {prov: '',city: '',area: ''},	//需要实例化的元素
        values: null,		//默认值
        tips: '请选择...',
        basePath: '/',
        labels: ["省","市","区/县"],
        parentClass: null,
        selectClass: null,
        autoImport: false,
        field: {
            name: null,value: 'value', //提交的是select的名字或者是value,如果提交名就是name
            split: ','	//用于分割省市区的字符，例如 杭州-西湖-留下镇
        },
        onProv: function (target,value){
        },
        onCity: function (target,value){
        },
        onArea: function (target,value){
        },
        onSelect: function (target,value){
        }
    }, this.info={
        provId: '',prov: {},cityId: '',city: {},areaId: '',area: {},fieldId: '',field: {}
    }, this.prov=function (){
        var helper=new GetHelper(this.info.provId);
        return helper;
    }, this.city=function (){
        var helper=new GetHelper(this.info.cityId);
        return helper;
    }, this.area=function (){
        var helper=new GetHelper(this.info.areaId);
        return helper;
    }, this.ready=function (_param){

        //合并参数
        for(var item in _param){
            this.param[item]=_param[item];
        }
        //引入数据
        if(this.param.autoImport){
            if(!_is_append){
                $(document.head).append('<script type="text/javascript" src="'+this.param.basePath+'/tdist_py.js"></script>');
                _is_append=true;
            }
        }
        //给对象增加省市区选择对象
        var id=index++;
        if(this.param.elem!=null){
            var areaId="area_"+id;
            var cityId="city_"+id;
            var provId="prov_"+id;
            var html='<div${parentClass}><span>${name0}</span><select id="${prov_id}" ${selectClass}></select>';
            html+='<span>${name1}</span><select id="${city_id}" ${selectClass}></select>';
            html+='<span>${name2}</span><select id="${area_id}" ${selectClass}></select></div>';
            //parentClass
            if(this.param.parentClass!=null){
                html=html.replace('${parentClass}',' class="'+this.param.parentClass+'"');
            }else{
                html=html.replace('${parentClass}','');
            }
            //selectClass
            if(this.param.selectClass!=null){
                html=html.replace("${selectClass}",'class="'+this.param.selectClass+'"');
                html=html.replace("${selectClass}",'class="'+this.param.selectClass+'"');
                html=html.replace("${selectClass}",'class="'+this.param.selectClass+'"');
            }else{
                html=html.replace("${selectClass}",'');
                html=html.replace("${selectClass}",'');
                html=html.replace("${selectClass}",'');
            }
            //id
            html=html.replace("${prov_id}",provId);
            html=html.replace("${city_id}",cityId);
            html=html.replace("${area_id}",areaId);
            //标签
            html=html.replace("${name0}",this.param.labels[0]);
            html=html.replace("${name1}",this.param.labels[1]);
            html=html.replace("${name2}",this.param.labels[2]);
            $(this.param.elem).append(html);
        }
        //追加表单字段
        if(typeof this.param.field.name!='undefined'&&this.param.field.name!=null){
            var _inputId=this.param.field.name+"_"+id;
            var _input='<input name="${name}" id="${id}" type="hidden"/>';
            //name
            _input=_input.replace("${name}",this.param.field.name);
            //id
            _input=_input.replace("${id}",_inputId);
            if(this.param.elem!=null){
                $(this.param.elem).append(_input);
            }else{
                $(this.param.elems.prov).parent().append(_input);
            }
            this.info.fieldId=_inputId;
            this.info.field=$("#"+_inputId);
        }
        //追加数据
        //省份追加数据
        this.info.areaId="#area_"+id;
        this.info.cityId="#city_"+id;
        this.info.provId="#prov_"+id;
        var provDatas=provDatas=getDatas('1');	//获取中国的
        //选取对象
        if(this.param.elem!=null){
            this.info.prov=$(this.info.provId);
            this.info.city=$(this.info.cityId);
            this.info.area=$(this.info.areaId);
        }else{
            this.info.prov=$(this.param.elems.prov);
            this.info.city=$(this.param.elems.city);
            this.info.area=$(this.param.elems.area);
            this.info.areaId=this.param.elems.area;
            this.info.cityId=this.param.elems.city;
            this.info.provId=this.param.elems.prov;
        }
        var info=this.info;
        //追加tips
        info.prov.append('<option value="">'+this.param.tips+'</option>');
        info.city.append('<option value="">'+this.param.tips+'</option>');
        info.area.append('<option value="">'+this.param.tips+'</option>');
        appendOption(info.prov,provDatas);
        //设置默认值
        if(this.param.values!=null){
            this.setValues(this.param.values);
        }
        //省份注册事件
        var ob=this;
        info.prov.change(function (){
            //设置默认值 省份
            provDatas=getDatas($(this).val());
            var elem=info.city;
            elem.html('');
            appendOption(elem,provDatas);
            //为区或者县最近数据
            info.area.html('');
            appendOption(info.area,getDatas(ob.city().getValue()));
            //调用事件
            ob.param.onProv($(this),$(this).val());
            ob.sync();
            //通用事件
            ob.param.onSelect($(this),$(this).val());
        });
        //为市注册事件
        info.city.change(function (){
            provDatas=getDatas($(this).val());
            info.area.html('');
            appendOption(info.area,provDatas);
            //调用事件
            ob.param.onCity($(this),$(this).val());
            //同步方法
            ob.sync();
            //通用事件
            ob.param.onSelect($(this),$(this).val());
        });
        //为县或者区注册事件
        info.area.change(function (){
            ob.param.onArea($(this),$(this).val());
            //表单字段值同步
            ob.sync();
            //通用事件
            ob.param.onSelect($(this),$(this).val());
        });
        return this;
    }, this.setValues=function (param){
        var info=this.info;
        var values=param;
        //省
        info.prov.find("option[value='"+values[0]+"']").attr("selected",true);
        appendOption(info.city,getDatas(values[0]));
        //市
        info.city.find("option[value='"+values[1]+"']").attr("selected",true);
        appendOption(info.area,getDatas(values[1]));
        //区
        info.area.find("option[value='"+values[2]+"']").attr("selected",true);
        //同步
        this.sync();
    }, this.getString=function (char){
        var split=char;
        if(char==null||typeof char=='undefined'){
            split="";
        }
        return this.prov().getName()+split+this.city().getName()+split+this.area().getName();
    }, this.getValues=function (char){
        var split=char;
        if(char==null||typeof char=='undefined'){
            split="";
        }
        return this.prov().getValue()+split+this.city().getValue()+split+this.area().getValue();
    }, this.sync=function (){
        if(typeof this.param.field.value=='undefined'){
            this.param.field.value="value";
        }
        //同步值到field
        if(this.param.field.value=='name'){
            $("#"+this.info.fieldId).val(this.getString(this.param.field.split));
        }
        if(this.param.field.value=='value'){
            $("#"+this.info.fieldId).val(this.getValues(this.param.field.split));
        }
    }, //通过id值来获取字符串
            this.getAddress=function (param){
                if(param==''){
                    return "";
                }
                var str="";
                var array=param.split(",");
                for(var i=0; i<array.length; i++){
                    str+=tdist_all[array[i]][0];
                }
                return str;
            }
}
function appendOption(ob,datas){
    for(var i=0; i<datas.length; i++){
        $(ob).append('<option value="'+datas[i].id+'">'+datas[i].name+'</option>');
    }
}
function GetHelper(id){
    this.getTarget=function (){
        return $(id);
    }, this.getId=function (){
        return $(id).attr("id");
    }, this.getValue=function (){
        return $(id).val();
    }, this.getName=function (){
        return $(id).find("option:selected").text();
        ;
    }
}
//读取数据
function getDatas(parent_id){
    var datas=[];
    for(var item in tdist_all){
        var obj=tdist_all[item];
        if(obj[1]==parent_id){
            datas.push({id: item,name: obj[0]});
        }
    }
    return datas;
}
