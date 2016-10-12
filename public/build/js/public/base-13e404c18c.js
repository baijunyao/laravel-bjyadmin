$.ajaxSetup({
    // ajax 发送_token
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// 常用函数
bjy={

    /**
     * 通用跳转函数
     * @param  String url    跳转的目标url
     * @param  Number second  多少秒后跳转
     * @param  String message 提示信息
     */
    redirect: function(url,second,message){
        var url=url || '/',
            second=second || 0,
            message=message || '',
        // 转换为毫秒 为了处理0毫秒的问题所以+1
            second=second*1000+1;
        // 设置提示信息
        if (message!='') {
            this.alert(message);
        }
        // 设置跳转时间
        setTimeout(function(){
            location.href=url;
        },second)
    },

    /**
     * 刷新本页
     * @param  {Number}  second  多少秒后刷新 默认是0立即刷新
     * @param  {Boolean} history 默认为  false刷新后停留在当前位置  true 刷新后到顶部
     */
    refresh: function(second,history){
        var second=second || 0,
            history=history | false;
        // 转换为毫秒 为了处理0毫秒的问题所以+1
        second=second*1000+1;
        setTimeout(function(){
            if (history) {
                location.reload(true);
            }else{
                location.reload(false);
            }
        },second)
    },

    /**
     * 获取form中的数据并转为json对象格式
     * @param  {object} obj form对象
     * @return {json}       json对象
     */
    formToJson: function(obj){
        var formData=$(obj).serializeArray();
        var formArray={};
        $.each(formData, function(index, val) {
            formArray[val['name']]=val['value'];
        });
        return formArray;
    },

    /**
     * 弹出提示框
     * @param  {string} word 提示内容
     */
    alert: function(word){
        layer.open({
            content: word,
            time: 1
        });
    },

    mustLogin: function(obj){
        if (uid) {
            return true;
        }else{
            this.redirect('/Home/Index/login',1,'请先登录');
            return false;
        }
    },

    test: function(){
        this.alert('2222');
    },




}
