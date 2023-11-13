$(function() {
    getInviteCodex();
    getIfJoin();
});

function getIfJoin(){
      $.ajax({
                        type: "POST",
                        async:true,
                        url: "https://www.bearnotion.ru/jsonapi/bsLinkAction",
                        data: {
                            "type": 'find',
                            "siteUrl":siteUrl,
                            "siteToken":siteToken
                        },
                        dateType: "json",
                        success: function(data) {
                            json = JSON.parse(data);
 var strs = " ";
    if(json.code == '1'){
  
                                strs += '<span class="button button-success csf--button"  id="siteKey" style="pointer-events: none;"><i class="fas fa-bolt"></i> '+json.siteKey+'</span>'
                                $("#alreadyJoin").fadeIn();
                                $("#siteKey").html(strs).fadeIn();
    }
    else if(json.code == '-2'){
     strs += '<span class="button button-success csf--button"  id="siteKey" style="pointer-events: none;"><i class="fas fa-bolt"></i> '+json.siteKey+'</span>'
                                $("#alreadyJoin2").fadeIn();
                                $("#siteKey").html(strs).fadeIn(); 
    }
    else{
    $("#applyJoin").fadeIn();   
    }
                        },
                        complete: function() {
                        },
                        error: function() {
                            toastr.warning('数据获取错误，请稍后再试~~');
                        }
                    });
    
}


function getInviteCodex(){
    var invitecode = document.getElementsByClassName("invitecode");
      $.ajax({
                        type: "POST",
                        async:true,
                        url: "https://api.typecho.co.uk/index.php/getInviteCode",
                        data: {
                            "type": 'findcode',
                            "domain":siteUrl,
                            "siteToken":siteToken
                        },
                        dateType: "json",
                        success: function(data) {
                            json = JSON.parse(data);
for (var i = 0; i < invitecode.length; i++) {
        
        invitecode[i].innerHTML = json.message;
    }
    if(json.username){
    $('#username_talk').text(json.username);
    $('#bindUser').fadeIn();
    }
    else{
    $('#bindUserNot').fadeIn();    
    }
                        },
                        complete: function() {
                        },
                        error: function() {
                            toastr.warning('数据获取错误，请稍后再试~~');
                        }
                    });
    
}

function getInviteCode(){
    var invitecode = document.getElementsByClassName("invitecode");
    layer.confirm('是否同意授权通过本站域名获取并绑定BearTalk社区专属邀请注册码？', {
  btn: ['授权','取消']
}, function(){
  layer.msg('获取成功', {icon: 1});
      $.ajax({
                        type: "POST",
                        async:true,
                        url: "https://api.typecho.co.uk/index.php/getInviteCode",
                        data: {
                            "type": 'getcode',
                            "domain":siteUrl,
                            "siteToken":siteToken
                        },
                        dateType: "json",
                        success: function(data) {
                             json = JSON.parse(data);
for (var i = 0; i < invitecode.length; i++) {
        
        invitecode[i].innerHTML = json.message;
    }
                        },
                        complete: function() {
                        },
                        error: function() {
                            toastr.warning('数据获取错误，请稍后再试~~');
                        }
                    });
});
}

//20231113 站点提交
$(document).delegate("#applyJoin", "click", function() {
layer.open({
    type: 1 
    ,btn:["确定加入","取消加入"]
    ,title: '加入展示列表'
    ,skin: 'layui-layer-prompt'
    ,content: "<div style='margin:-10px 0 10px 0'>站点名称</div><div><input id='sitename' type='text' class='layui-layer-input' value='"+siteName+"' placeholder='站点名称'></div><div style='margin:10px 0 10px 0'>站点网址[已自动填写]</div><div><input style='margin-top:10px;' id='siteurl' type='text' class='layui-layer-input' value='"+siteUrl+"' placeholder='站点网址' disabled></div><div style='margin:10px 0 10px 0'>站点LOGO图片地址[非必填]</div><div><input style='margin-top:10px;' id='sitelogo' type='text' class='layui-layer-input' value='' placeholder='站点LOGO图片地址'></div><div style='margin:10px 0 10px 0'>站点描述</div><div><input style='margin-top:10px;' id='sitedesc' type='text' class='layui-layer-input' value='"+siteDesc+"' placeholder='站点描述'></div>"
    ,yes: function(index, callback){
        if(!$(callback).find("#sitename").val()){
            layer.msg('站点名称不能为空哦~');
            return false;
        }
        if(!$(callback).find("#siteurl").val()){
            layer.msg('站点网址不能为空哦~');
            return false;
        }
        if(!$(callback).find("#sitedesc").val()){
            layer.msg('站点描述不能为空哦~');
            return false;
        }
        $('.layui-layer-btn0').css('pointer-events','none');
      $.ajax({
                        type: "POST",
                        async:true,
                        url: "https://www.bearnotion.ru/jsonapi/bsLinkAction",
                        data: {
                            "type": 'join',
                            "siteName":$(callback).find("#sitename").val(),
                            "siteUrl":$(callback).find("#siteurl").val(),
                            "siteLogo":$(callback).find("#sitelogo").val(),
                            "siteDesc":$(callback).find("#sitedesc").val(),
                            "useTheme":useTheme,
                            "siteToken":siteToken
                        },
                        dateType: "json",
                        success: function(data) {
                            json = JSON.parse(data);
                            if(json.code == '1'){
toastr.success('您已成功申请加入展示列表~');
 var strs = " ";
                                strs += '<span class="button button-success csf--button"  id="siteKey" style="pointer-events: none;"><i class="fas fa-bolt"></i> '+json.siteKey+'</span>'
                                $("#applyJoin").hide();
                                $("#alreadyJoin").fadeIn();
                                $("#siteKey").html(strs).fadeIn();
                                
}
else{
toastr.warning('申请失败，参数格式错误，请重试~');    
}
layer.closeAll();

                        },
                        complete: function() {
                        },
                        error: function() {
                            toastr.warning('数据获取错误，请稍后再试~~');
                        }
                    });
                    
                    
    }
});
});