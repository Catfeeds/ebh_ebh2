<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/js/soundManager2/css/voicePlayer.css">
</head>

<body>
    <button id="del">111111</button>
    <div id="box"></div>
    <script src="http://static.ebanhui.com/js/soundManager2/js/jquery.js"></script>
    <script src="http://static.ebanhui.com/js/soundManager2/js/voicePlayer.js"></script>
    <script type="text/javascript">
    $(function() {
        /*
        voicePlayer({
            id:"",                  //ID,string
            box:"",                 //放置的容器,DOM,必填
            remove:"",              //是否添加移除按钮,boolean
            onremove:function(){},     //删除voicePlayer时产生的事件
            src:"",                 //音频链接地址,string,必填
            time:"",                //音频文件时间长度,number,必填
        }).show()                   //显示voicePlayer
          .remove()                 //移除voicePlayer
          .play()                   //开始播放
          .stop()                   //停止播放
          .get();                   //通过ID获取voicePlayer
          */

        voicePlayer({
            id: "abc", //选填
            box: $("#box"),
            src: "http://www.test.com/sound/music/a.mp3",
            time: 10
        }).show();

        $("#del").on("click", function() {
            voicePlayer.get("abc").remove(); //移除

        });


        voicePlayer({
            order:1,
            id: "", //选填
            box: $("#box"), //容器
            delBtn: true, //是否需要删除按钮（可选）默认无
            ondel: function() {
                console.log(this);
            },
            src: "http://www.test.com/sound/music/b.mp3", //路径
            time: 135 //剩余时间（秒）
        }).show();

    });
    </script>
</body>

</html>
