$(function() {
    getInviteCodex();
});

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