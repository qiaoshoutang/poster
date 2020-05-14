<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>我为元界DNA打Call</title>
    <script>
        (function (doc, win) {
            var docEl = doc.documentElement,
                resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
                recalc = function () {
                    var clientWidth = docEl.clientWidth;
                    if (!clientWidth) return;
                    if(clientWidth>=640){
                        docEl.style.fontSize = '100px';
                    }else{
                        docEl.style.fontSize = 100 * (clientWidth / 640) + 'px';
                    }
                };
            if (!doc.addEventListener) return;
            win.addEventListener(resizeEvt, recalc, false);
            doc.addEventListener('DOMContentLoaded', recalc, false);
        })(document, window);
    </script>
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <link rel="stylesheet" href="css/FillInfoemation.css?23561">
    <script src="js/jquery.js"></script>
    <script src="js/layui/layui.js"></script>
</head>
<style>
    .box_top_new{
        width: 57%;
        margin: 1rem auto 0 auto;
    }
    .box_bottom_new{
        width: 55%;
        margin: .5rem auto;
    }
</style>
<body>
<!--<div style="display: none"><img src="images/DaCall.jpg" alt=""></div>-->
<div class="box">
    <!--邀请函-->
    <div class="box-imgbox">
        <!--关闭-->
        <div class="box-img">
            <div class="close-imgbox">
                ×
            </div>
            <img src="images/Zh.jpg" alt="">
        </div>
        <div class="Preservation-Img">
            长按图片保存专属邀请函
        </div>
    </div>
    
    <div class="box_top_new">
        <img src="images/YuJieDaCall.png" alt="" width="100%">
        
    </div>
    <!--信息填写-->
    <div class="Fill-Information">
        <ul>
            <li>
                <div class="user-information">您的名字</div>
                <div style="font-size: 0px">
                    <input type="text" placeholder="请输入您的名字" class="User-name" name="user-name">
                </div>
            </li>
            <li>
                <div class="user-information">您的身份</div>
                <input type="text" placeholder="您的身份1" class="User-identity-first" name="User-identity-first">
                <input type="text" placeholder="您的身份2" class="User-identity" name="User-identity-second">
                <!--<input type="text" placeholder="您的身份3" class="User-identity" name="User-identity-thired">-->
            </li>
        </ul>
        <div class="Tips">*最少需要输入一个身份，最多输入两个身份(字数在15字内)</div>
    </div>
    <!--生成邀请函-->
    <div class="Make-Poster">
        <img src="images/MakeCall.png" alt="">
    </div>
    <!--底部时间-->
    <div class="box_bottom_new">
        <img src="images/DaCall01.png" alt="" width="100%">
    </div>
</div>
</body>
<script>
    $(".close-imgbox").click(function () {
        $(".box-imgbox").hide();
    });
    layui.use('layer', function(){  //layer弹框
        var layer = layui.layer;
    });
    $(".Make-Poster img").click(function () {
        var user_name=$("input[name='user-name']").val();
        var first=$("input[name='User-identity-first']").val();
        var second=$("input[name='User-identity-second']").val();
        var third=$("input[name='User-identity-thired']").val();

        if(user_name==''||user_name=='null'){
            layer.msg('您的名字不能为空');
            return false
        }/*if(first.length==''||first.length==0){
            layer.msg('您身份1未填写');
            return false
        }*/if($.trim(first).length>25){
            layer.msg('您身份1的填写大于25字');
            return false
        }if($.trim(second).length>25){
            layer.msg('您身份2的填写大于25字');
            return false
        }if($.trim(third).length>25){
            layer.msg('您身份3的填写大于25字');
            return false
        }else {
            $(".box-imgbox").show()
            $.ajax({
                type:"post",
                url:"/Home/Ajax/getPoster",
                data:{user_name:user_name,first:first,second:second,third:third,language:'zh'},
                dataType:'json',
                success:function(data){
                    if(data.code==1){
                        $('.box-imgbox .box-img img').attr('src',data.poster);
                        $(".box-imgbox").show()
                    }else{
                        layer.msg(data.msg);
                    }
                }
            });
        }
    })
</script>
</html>