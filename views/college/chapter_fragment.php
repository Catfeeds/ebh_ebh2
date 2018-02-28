<link href="https://cdn.bootcss.com/layer/3.1.0/theme/default/layer.css" rel="stylesheet">
<script src="https://cdn.bootcss.com/layer/3.1.0/layer.js"></script>
<link rel="stylesheet" href="http://static.ebanhui.com/ebh/js/date/skin/WdatePicker.css">
<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<!--word导出插件-->
<script src="http://static.ebanhui.com/wordexport/FileSaver.js"></script>
<script id="word"></script>
<script src="http://static.ebanhui.com/date/date-methods.js"></script>
<script src="http://static.ebanhui.com/common/common.js"></script>

<style>
    /*    缺省图片*/
    .study {
        width: 100% !important;
    }

    /*    本页样式*/
    /*选择框*/
    .kstdg {
        width: 12% !important;

    }

    .kstdg span {
        width: 100% !important;
    }

    #end, #start {
        display: inline-block;
        width: 80px;
        height: 22px;
        border: solid 1px #c3c3c3;
        padding: 0 25px 0 10px;
    }

    #start {
        margin-left: 5px;
    }

    #end {
        margin-left: -2px;
    }

    /*导出*/
    #output, #search-time {
        display: inline-block;
        width: 65px;
        height: 25px;
        border: solid 1px #c3c3c3;
        background: dodgerblue;
        color: #fff;
        border-radius: 3px;
        vertical-align: top

    }

    .time-box {
        width: 400px;
        display: inline-block;
        position: relative;
    }

    /*清除时间*/
    .clear-time-start {
        font-size: 18px;
        position: absolute;
        top: -3px;
        left: 106px;
        cursor: pointer;
        display: none;

    }

    .clear-time-end {
        font-size: 18px;
        position: absolute;
        top: -3px;
        left: 223px;
        cursor: pointer;
        display: none;

    }

    /*联动选择框*/
    ._class {
        width: 602px;
        height: 400px;
        position: absolute;
        top: 22px;
        left: -0.5px;
        background: #fff;
        border: 1px solid #d9d9d9;
        display: none;
    }

    ._class ul {
        float: left;
        width: 199px;
        height: 100%;
        overflow: hidden;
        overflow-y: auto;
    }

    ._class ul li {
        width: 100%;
        height: 35px;
        line-height: 35px;
        text-indent: 10px;
    }

    ._class ul li:hover {
        background: #F1F1F1;
    }

    ._class ul + ul {
        border-left: 1px solid #d9d9d9;
    }

    /*类型选择状态*/
    .add_selected {
        color: cornflowerblue
    }
</style>
<div id="schoollayer2" style="background:#fff;width:980px;height:115px;"
     class="mamase">
    <div class="kdhtyg">
        <div style="display:none;" id="examtypeselect" class="kstdg">
            <span id="examtypeselecttitle" class="xtitle" tag=2>
                请选择来源
            </span>

            <div class="liawtlet">
                <a id="examtype2" tag="2" href="javascript:void(0)">
                    学校题库
                </a>
            </div>
        </div>
        <div id="courseselect1" class="kstdg" style="margin-left:0;">
            <span id="folderid" class="xtitle" tag=0>
            	课程主类
            </span>
            <div class="_class">
                <ul pid>

                </ul>
                <ul sid id="sidsid">

                </ul>
                <ul>

                </ul>
            </div>
            <div class="liawtlet" style="display:none;max-height:300px;overflow-y: auto;"></div>
        </div>
        <div id="middleselect" class="kstdg" style="margin-left:5px;">
            <span id="middleselecttitle" class="xtitle" tag=0>请选择版本</span>
            <div class="liawtlet" style="display:none;max-height:300px;overflow-y: auto;"></div>
        </div>
        <div id="mysecondselect" class="kstdg" style="margin-left:5px;display:none;">
            <span id="mysecondselecttitle" class="xtitle" tag=0>请选择知识点</span>
            <div class="liawtlet" style="display:block;max-height:300px;overflow-y: scroll;"></div>
        </div>
        <div id="mythirdselect" class="kstdg" style="margin-left:5px;width:102px;display:none;">
            <span id="mythirdselecttitle" class="xtitle" tag=0>请选择知识点</span>
            <input type="hidden" class="chapterpath"/>
            <div id="thirdselectpanel"
                 style="position:absolute;top:24px;left:-1px;border: solid 1px #d9d9d9;display:none;">
            </div>
        </div>
        <div class="time-box">

            <input type="text" placeholder="开始时间"
                   onclick="WdatePicker({dateFmt:'yyyy-MM-dd',maxDate:'#F{$dp.$D(\'end\')}'});" id="start"><span
                    class="clear-time-start">x</span>
            <input type="text" placeholder="结束时间"
                   onclick="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'start\')}',onpicked:$.changeTime});"
                   id="end"><span class="clear-time-end">x</span>
            <button type="button" id="search-time">搜索</button>
            <button type="button" id="output">导出</button>
        </div>
    </div>
    <h2 class="ferygur">
        <span>
            题型过滤
        </span>
    </h2>
    <div class="kstytwr" id="kstytwrt1" style="margin:15px 0 15px 0px;">
        <ul>
            <li class="kedtg">
                <input id="myallquet" type="checkbox" checked="checked" value="0" name="myquetype">
                <label for="myallquet">
                    全部
                </label>
            </li>
            <!--  <li class="kedtg">
                 <input id="myxquet" type="radio" value="X" name="myquetype">
                 <label for="myxquet">
                     答题卡
                 </label>
             </li> -->
            <li class="kedtg">
                <input id="myaquet" type="checkbox" checked="checked" value="A" name="myquetype">
                <label for="myaquet">
                    单选题
                </label>
            </li>
            <li class="kedtg">
                <input id="mybquet" type="checkbox" checked="checked" value="B" name="myquetype">
                <label for="mybquet">
                    多选题
                </label>
            </li>
            <li class="kedtg">
                <input id="mydquet" type="checkbox" checked="checked" value="D" name="myquetype">
                <label for="mydquet">
                    判断题
                </label>
            </li>
            <li class="kedtg">
                <input id="mycquet" type="checkbox" checked="checked" value="C" name="myquetype">
                <label for="mycquet">
                    填空题
                </label>
            </li>
            <li class="kedtg">
                <input id="myequet" type="checkbox" checked="checked" value="E" name="myquetype">
                <label for="myequet">
                    文字题
                </label>
            </li>
            <li class="kedtg">
                <input id="myhquet" type="checkbox" checked="checked" value="H" name="myquetype">
                <label for="myhquet">
                    主观题
                </label>
            </li>
        </ul>
    </div>
</div>
<!--cs-->
<div id="output-box" style="display: none">
    <div>
        <p>单选</p>
        <p>2111 <span>[1分]</span></p>
        <p>A 222</p>
        <P>b 3333</P>
        <p>我的答案：<span>未作答</span></p>
        <p>正确答案：<span>A</span></p>
    </div>
</div>

<script type="application/javascript">
    document.getElementById('word').src = 'http://static.ebanhui.com/wordexport/jquery.wordexport.js?v='+Math.random();
    Xques.getFolder = function () {

    };

    //隐藏知识框
    function clear_chird() {
        setTimeout(function () {
            $('#mysecondselect').hide();
            $('#mythirdselect').hide();
        }, 0)

    } //隐藏选择框
    function click_all() {
        setTimeout(function () {
            $('#thirdselectpanel').hide();

        }, 0)

    }

    window.onload = function () {
        //获取课程列表
        function getFolderList() {
            $.ajax({
                url: '/college/examv2/getFolderList.html',
                type: 'POST',
                dataType: 'json'
            }).done(function (res) {
                if (typeof res == 'object') {
//                 console.log(res);
                    var list = res.datas;
                    list = list.sort($.to_orderby('pid', 'desc'));
                    $.extend({
                        folderList: list,//课程列表
                        curPid: 0,//当前选择的pid
                        curSid: 0,//当前选择的sid
                        tid: 0,
                        _class: '',//主类
                        _chird: '',//子类
                        _foldername: ''//课程名


                    })
                }

            }).fail(function (e) {

            })
        }

        getFolderList();

        //重写请求课程类别方法
        //选择知识点点击
        $('.xtitle').live('click', function (e) {
            var eid = e.target.id;//判断当前事件源id{
            if (eid == 'middleselect' || eid == 'middleselecttitle') {
                if ($('a[chapterid="0"]').length == 0) {
                    $('.chapter_option').eq(0).before('<a chapterid="0" onclick="clear_chird()">全部</a>');

                }
            }

            if (eid == 'mysecondselecttitle' || eid == 'mysecondselect') {
                if ($('#mysecondselect a[chapterid="0"]').length == 0) {
                    $('#mysecondselect .chapter_option').eq(0).before('<a chapterid="0" title onclick="click_all()">全部</a>');
                }
            }
        });


//       $('div.kstdg').unbind('click');
//       $('div#courseselect1.kstdg').unbind('click');
//       $('li.add_selected').unbind('click');
        //课程选择点击
        $('#courseselect1').live('click', function (e) {
            var target = e.target;
            if (target.id != 'courseselect1' && target.id != 'folderid') {
                return false;
            }
            //判断是否首次请求
            if (typeof $.folderList == "object") {
                if (!$('._class').is(':hidden')) {
                    $('._class').hide();
                    return false;
                }
                $('._class ul').eq(1).empty();
                $('._class ul').eq(1).removeClass('add_roll');
                $('._class ul').eq(2).empty();
                $('._class ul').eq(2).removeClass('add_roll');
                addPid();
                $('._class').show();
                return false;

            }

            return false;
        });
        //点空白地方关闭联动框
        $(document).on('click', function () {
            if (!$('._class').is(':hidden')) {

                var param = postData();
                var tid = $('#folderid').attr('tag');
                getErrorList(tid, param);
                $('._class').hide();
            }
        });

        //添加课程菜单
        function addFolderMenu(str) {
            if (str == '') {
                return false;
            }
            //处理字符长度
            var dom = document.getElementById('folderid');
            dom.setAttribute('title', str);
            if (typeof str == 'string') {
                str = str.substring(0, 6);
            } else {
                str = str;
            }
            dom.innerHTML = str;
        }

        //添加选择中的课程id
        function addSelectFolderid(type, pid, sid, folderid) {
            var folderidArr = [];
            var strArr = [];//标题数组

            switch (type) {
                case -1:
                    folderidArr.push('');
                    strArr.push('全部');
                    break;
                case 0:
                    $($.folderList).each(function () {
                        if (this.pid == pid) {
                            folderidArr.push(this.folderid);
                            if(this.pid == 0){
                                this.pname = '其他分类';
                            }
                            if (strArr.length == 0) {
                                if (typeof this.foldername == 'string') {
                                    var name = this.pname.substring(0, 12);
                                } else {
                                    var name = this.pname;
                                }

                                strArr.push(name);
                            } else if (strArr.length == 1) {
                                strArr.push('...');
                            }
                        }
                    })
                    break;
                case 1:
                    $($.folderList).each(function () {
                        if (this.pid == pid && this.sid == sid) {
                            folderidArr.push(this.folderid);
                            this.sid   = 0 ;
                            this.iname = '其他分类';
                            if (strArr.length == 0) {
                                if (typeof this.iname == 'string') {
                                    var name = this.iname.substring(0, 12);
                                } else {
                                    var name = this.iname;
                                }
                                strArr.push(name);
                            } else if (strArr.length == 1) {
                                strArr.push('...');
                            }
                        }
                    })
                    break;
                case 2:
                    folderidArr.push(folderid);
                    var str = '';
                    $($.folderList).each(function () {
                        if (this.folderid == folderid && str == '') {
                            if (typeof this.foldername == 'string') {
                                str = this.foldername.substring(0, 12);
                            } else {
                                str = this.foldername;
                            }

                        }
                    })

                    strArr.push(str.substring(0, 12));


            }
            $('#folderid').attr('tag', folderidArr.join(','));
            addFolderMenu(strArr.join(','));

        }

        var $class = $('._class')
        var $ul = $class.find('ul')
        //主类点击
        $('li[pid]').live('click', function () {
            $class.show();
            $class.css("width", '401px')
            var self = this;
            var pid = self.getAttribute('pid');
            $(self).addClass('add_selected');
            $(self).siblings().removeClass('add_selected');
            $.curPid = pid;
            $._class = self.innerText;
            $('._class ul').eq(1).empty();
            $('._class ul').eq(2).empty();
            if (pid == 'all') {
                addSelectFolderid(-1, '');
                $('._class').hide();
                var param = postData();
                var tid = 0;
                getErrorList(0,param);
            }
            addSid();
            //添加课程id
            addSelectFolderid(0, $.curPid);
            return false;
        });

//      //子类点击
//
        $('li[sid]').live('click', function () {
            $class.show();
            $class.css("width", '601px')
            var self = this;
            var pid = $.curPid;
            var sid = self.getAttribute('sid');
            $.curSid = sid;
            $._chird = self.innerText;
            addFolderid();
            $(self).addClass('add_selected');
            $(self).siblings().removeClass('add_selected');
            //子类选择后，添加folderid到属性中folderid以,号隔开
            addSelectFolderid(1, $.curPid, $.curSid);
            return false;

        });
        //课程列表点击
        $('li[folderid]').live('click', function (e) {
            //
            //console.log(e.target.innerHTML);
            $class.show();
            $class.css("width", '601px')
            var self = this;
            $._foldername = self.innerText;
            var folderid = this.getAttribute('folderid');
            $(self).addClass('add_selected');
            $(self).siblings().removeClass('add_selected');
            //添加课程id
            addSelectFolderid(2, '', '', folderid);
            var tid = $('#folderid').attr('tag');
            var param = postData();
            getErrorList(tid, param);
            $('._class').hide();
            return false;

        });


        //添加主类
        function addPid() {
            $('._class').css({width: '200px'}).show();
            var list = $.folderList;
            list = list.sort($.to_orderby('pid', 'desc'));
            $('._class ul').eq(0).empty();
            var html = '';
            html += '<li pid="all">全部</li>';
            var curPid = 0;//当前主类id
            var row = 1;//行数
            var arr = [];
            if (list) {
                for (var k in list) {
                    var info = list[k];
                    if (typeof info.pname == 'string') {
                        var name = info.pname.substring(0, 12);
                    } else {
                        var name = info.pname;
                    }
                    if (k == 0) {
                        curPid = info.pid;

                        html += '<li pid="' + info.pid + '" >' + name + '</li>';
                        arr.push(info.pid);


                    }
                    if (!$.in_array(arr, info.pid)) {
                        curPid = info.pid;
                        arr.push(info.pid);
                        html += '<li pid="' + info.pid + '" >' + name + '</li>';
                        row++;
                    }

                }
                $('._class ul').eq(0).append(html);
                if (row > 5) {
                    $('._class ul').eq(0).addClass('add_roll');
                } else {
                    $('._class ul').eq(0).removeClass('add_roll');

                }
            }


        }

        //       添加子类
        function addSid() {
            var list = $.folderList;
            list = list.sort($.to_orderby('sid', 'desc'));
            var pid = $.curPid;
            var self = $('._class ul').eq(1);
            $(self).next().empty();
            var html = '';
            var row = 0;
            var other = 0;
            var sidList = [];
            for (var k  in list) {
                var info = list[k];
                if (info.pid == pid) {
                    if (other > 0 && info.sid == 0) {
                        continue;
                    }
                    if (info.sid == 0) {
                        other++;
                    }
                    if (typeof info.iname == 'string') {
                        var name = info.iname.substring(0, 14);
                    }
                    //去重
                    if ($.in_array(sidList, info.sid) == false) {
                        html += '<li sid="' + info.sid + '">' + (info.sid == 0 ? '其他分类' : name) + '</li>';
                        sidList.push(info.sid);
                        row++;
                    }
                }
            }
            self.empty().append(html);
            return false;
            if (row > 5) {
                $(self).addClass('add_roll');
            } else {
                $(self).removeClass('add_roll');

            }
        }

        //添加课程id列表
        function addFolderid() {
            $('._class ul').eq(2).empty();
            var list = $.folderList;
            var html = '';
            var row = 0;
            var sid = $.curSid;
            var pid = $.curPid;
            for (var k  in list) {
                var info = list[k];
                if (info.pid == pid && info.sid == sid) {
                    if (typeof info.foldername == 'sting') {
                        var name = info.foldername.substring(0, 12);
                    } else {
                        var name = info.foldername;
                    }
                    html += '<li folderid="' + info.folderid + '">' + name + '</li>';
                    row++;
                }
            }
            $('._class ul').eq(2).empty().append(html);
            if (row > 5) {
                $('._class ul').eq(2).addClass('add_roll');
            } else {
                $('._class ul').eq(2).removeClass('add_roll');

            }

        }

        //导出word
        $(document).on('click', '#output', function () {
            parent.layer.load();
            param = {};
            param.size = getcookie('ebh_total_num');
            if (param.size <= 0) {
                parent.layer.closeAll();
                parent.layer.alert('没有导出的内容', {icon: 2, title: '错误提示'});
                return;
            }
            param.url = '/college/examv2/outWord.html';
            param.page = 1;
            param = postData(param);
            param.tid = $('#folderid').attr('tag');

            var chapterpath = '';
            var cur = $('.nodeSel');
            while (cur.length) {
                if (cur.attr('id') == 'smyd0')
                    break;
                var h = cur.attr('href');
                var reg = /([0-9]+)/g;
                var cid = h.match(reg)[0];
                chapterpath = '/' + cid + chapterpath;
                cur = cur.parent().parent().prev('.dTreeNode').find('.node');
            }
            var path = param.topchapterid != 0 ? (param.topchapterid + (param.secchapterid != 0 ? '/' + param.secchapterid + (chapterpath ? chapterpath : param.chapterid != 0 ? '/' + param.chapterid : '') : '')) : '';
            var ttype = path ? 'CHAPTER' : 'FOLDER';
            param.path = path;
            param.ttype = ttype;
            $.ajax(
                {
                    url: param.url,
                    type: 'POST',
                    async: true,
                    dateType: 'json',
                    data: param
                }
            ).done(function (res) {

                res = JSON.parse(res);
                var totalNum = typeof res.datas.errList != 'undefined' ? res.datas.errList.length : 0;
                if (totalNum > 0) {
                    parent.layer.confirm('共导出数据' + totalNum + '道题,是否继续？<p style="color: red;font-size: 11px;">注：导出后,涉及主观题图片,请用office2007或更高的版本打开,其他软件暂不支持,敬请期待!</p>', {
                        icon: 0,
                        title: '提示'
                    }, function () {
                        parent.layer.closeAll();
                        parent.layer.load();
                        var html = getHtml(res.datas.errList, res.datas.imgPath);
                        var title = getTitle();
                        var fileName = title;
                        $('#output-box').empty().append(html);
                        $('#output-box h4').html(title);
                        setTimeout(function () {
                        $('#output-box').wordExport(fileName);
                        parent.layer.closeAll();
                        },1000)
                    }, function () {
                        parent.layer.closeAll();
                    });
                    // parent.layer.alert('正在导出word，请不要执行任何操作',{icon:3,title:'警告！'});
//                    console.log(res);
                } else {
                    parent.layer.closeAll();
                    parent.layer.alert('没有导出的内容', {icon: 2, title: '错误提示'});
                }


            }).fail(function (e) {
                parent.layer.alert('请求错误');
                setTimeout(function () {
                    parent.layer.closeAll();
                }, 2000)
//                console.log(e);
            })


        });
        //搜索按钮
        $('#search-time').on('click', function () {
            var param = postData();
            if(param.quetypeList.length == 0){
                parent.$('#mainFrame').css({height:document.body.offsetHeight+'px'});
                return false;
            }
            getErrorList($.tid, param);
        })
        //清除时间
        $('.clear-time-end').on('click', function () {
            document.getElementById('end').value = '';
            $(this).hide();
        })
        $('.clear-time-start').on('click', function () {
            document.getElementById('start').value = '';
            $(this).hide();
        });
        //时间选择框失去焦点
        $('#start,#end').on('blur', function () {
            var self = this;
            var id = self.id;
            if (self.value == '') {
                $('.clear-time-' + id).hide();
            } else {
                $('.clear-time-' + id).show();
            }

        });

        /**
         * 获取要导出的标题
         * */
        function getTitle() {
            var _class = $._class == '全部' ? '' : $._class;
//            console.log(_class);
            var _classChird = $._chird;
            var temp = (_classChird && _class  ? _class + '-' + _classChird : _class + _classChird);
            var temp = temp == '' ? $._foldername : temp + $._foldername;
            temp = temp == '' ? '错题本导出' : temp;
            var date = new Date();
            var time = getUnixToStr(date.getTime() / 1000, 'yyyyMMdd');
            temp = temp + ($.title?$.title:'') + time;
            return temp;

        }

        //拼接要导出的html
        function getHtml(list, imgPath) {
            //取开始和结束时间用于表头
            var startdate = document.getElementById('start').value;
            var enddate = document.getElementById('start').value;
            if (startdate == '' || enddate == '') {
                startdate = list[0]['dateline'];
                enddate = list[list.length - 1]['dateline'];
                if (enddate < startdate) {
                    var tempTime = enddate;
                    enddate = startdate;
                    startdate = tempTime;
                }
                startdate = getUnixToStr(startdate, 'yyyy-MM-dd');
                enddate = getUnixToStr(enddate, 'yyyy-MM-dd');
            } else {
                startdate = getUnixToStr(getStrToUnix(startdate), 'yyyy-MM-dd')
                enddate = getUnixToStr(getStrToUnix(enddate), 'yyyy-MM-dd')
            }
            var html = '';
            var title = '';
            html += '<h4 class="bag_title">' + title + '</h4>';
            html += '<h6 class="time_title">错题时间：' + startdate + '-----' + enddate + '</h6>';
            var type = 0;//用于判断题类型的数字
            var currType = '';//当前的题类型
            var titleArr = ['一 、', '二 、', '三 、', '四 、', '五 、', '六 、'];
            var title_type = '';
            for (var k in list) {
                var curr = list[k];
                if (currType == '') {
                    //首次循环
                    currType = curr.question.queType;
                    html += '<h3>' + titleArr[type] + getqueType(currType) + '</h3>';
                    var _key = 1;//题序号，每个新题型从1开始
                    title_type = getqueType(currType);
                }
                if (currType != curr.question.queType) {
                    //切换题类型
                    currType = curr.question.queType;
                    type += 1;
                    _key = 1;
                    html += '<h3 class="chird_title">' + titleArr[type] + getqueType(curr.question.queType) + '</h3>';
                    title_type = '';//多题型的情况下不要题型
                }

                //题目标题
                html += '<div>';
                html += '<span class="title">' + _key + ' . ' + curr.question.qsubject.replace(/#input#/g, '______').replace(/<br>/,'').replace(/#img#/g,'______') + '<span class="fen">[' + curr.question.quescore + '分]</span></span>';
                _key++;
                //题目选项
                var blankList = curr.question.blanks.blankList;
                var rightKey = [];//正确答案
                //填空题过滤，没有题目

                for (var _k = 0 in blankList) {
                    if (_k == 0) {
                        var index = 65;
                    }
                    //正确答案
                    if (blankList[_k].isanswer == 1) {
                        //正确答案判断填空题和文字题
                        if ( currType == 'E' || currType == 'C' || currType == 'H') {
                                var bsubject = blankList[_k].bsubject;
                            //填空题
                            if(currType == 'C'){
                                if(/ebh_1_data-latexebh_2_/.test(bsubject)){
                                    bsubject = '<img '+bsubject.replace(/ebh_1_/g, ' ').replace(/ebh_2_/g, '=')+' />';
                                }
                            }

                            rightKey.push( bsubject);
                        } else {
                            rightKey.push(String.fromCharCode(index));

                        }
                    }
                    if (currType == 'E' || currType == 'C' || currType == 'H') {
                        var select = ''
                    } else {
                        var select = String.fromCharCode(index);
                    }
                    var bsubject = blankList[_k].bsubject;

                    if (currType != 'C' && currType != 'E') {

                        html += '<p>' + select + ' ' + bsubject + '</p>';
                    }
                    index++;

                } //问题循环

                var extdata = JSON.parse(curr.question.extdata);
                var yimg = '';
                var pimg = '';


                //主观题
                if (currType == 'H') {
                    var  uid = curr.uid;
                    var  imgkey =curr.question.blanks.key;
                    var cwid = extdata.schcwid; //课件id
                    //原图地址

                        var cwurlH = 'http://up.ebh.net/exam/getBase64.html?orinote=1&uid=' + uid+ '&origin=1&key=' + encodeURIComponent(imgkey)+'&isBase64=1';
                        //答题后的图
                        var answerH = 'http://up.ebh.net/exam/getBase64.html?uid=' + uid + '&origin=1&key=' + encodeURIComponent(imgkey) + '&isBase64=1';
                        yimg = getImgBase64(cwurlH);//原图
                        pimg = getImgBase64(answerH);//批阅后的图
//                        yimg = /.*\.(jpg|png|bmp|gif|jpeg)$/.test(yimg) ? 'http://img.ebanhui.com/examcourse/' + yimg : '';
                      //  yimg = /.*\.(jpg|png|bmp|gif|jpeg)$/.test(yimg) ? 'http://img.ebanhui.com/schimages/' + yimg : '';
//                    /    pimg = /.*\.(jpg|png|bmp|gif|jpeg)$/.test(pimg) ? 'http://img.ebanhui.com/examcourse/' + pimg : '';
                       // pimg = /.*\.(jpg|png|bmp|gif|jpeg)$/.test(pimg) ? 'http://img.ebanhui.com/schimages/' + pimg : '';

                }

                if (yimg) {
                        html += '<img src="' + yimg + '" />';


                    //原图地址
                }
                //我的答案
                if (currType == 'C') {
                    //填空题
                    if ($.isset(curr, 'curr.answerQueDetail.answerBlankDetails')) {
                        var myanswer = curr.answerQueDetail.answerBlankDetails;
                        var temparr = [];
                        for (var k in myanswer) {
                            if (myanswer[k].content == '') {
                                temparr.push('未解答');
                            } else {
                                var content = myanswer[k].content;
                                if (/ebh_1_data-latexebh_2_/.test(content)) {
                                    var bsubjecthtml = content.replace(/ebh_1_/g, ' ').replace(/ebh_2_/g, '=');
                                    if (bsubjecthtml) {
                                        bsubjecthtml = '<img ' + bsubjecthtml + ' />';

                                    } else {
                                        bsubjecthtml = '未作答';
                                    }
                                } else {
                                    bsubjecthtml = content ? content : '未作答';
                                }

                                temparr.push(bsubjecthtml);
                            }
                        }
                    }
                    html += '<p>我的答案：<span class="my">' + temparr.join(' ; ') + '</span></p>';

                } else if('H' != currType) {

                    html += '<p>我的答案：<span class="my">' + getAnswer(blankList, curr) + '</span></p>';
                }
//                if (yimg) {
//
//                    html += '<img src="' + yimg + '" />';
//
//                }
                if(currType == 'H'){

                if (pimg) {
                    html += '<p>我的答案：</p>';

                    html += '<img src="' + pimg + '" />';
                }else{
                    html += '<p>我的答案：未解答</p>';
                }
                }
                //正确答案
                if (currType != 'H') {

                    html += '<p>正确答案:<span>' + rightKey.join(' ; ') + '</span>';
                    html += '</div>';
                }else{
                   // html += '<p>正确答案:</p>';
                }
                extdata.fenxi = extdata.fenxi.replace(/<br>/g, '').replace(/<p>/g, '').replace(/<\/p>/g, '');
                if (extdata.fenxi != '') {

                    html += '<p>分析：' + extdata.fenxi + '</p>';
                }
                $.extend({
                    title: title + (title_type == '' ? '' : '-' + title_type)
                });
            }// 主循环
            return html;

        }

        /**
         * 获取题类型文字
         * @param string type 字母类型
         * @return string 文字类型
         * */
        function getqueType(type) {
            switch (type) {
                case "A":
                    return '单选题';
                case "B":
                    return '多选题';
                case "C":
                    return '填空题';
                case "D":
                    return '判断题';
                case "E":
                    return '文字题';
                case "H":
                    return '主观题';
                default:
                    return '未知题型';


            }
        }
        function getImgBase64(url) {
            var src = '';
            $.ajax({
                // 允许携带证书
                xhrFields: {
                    withCredentials: true
                },
                url: url,
                type:'get',
                dataType:'json',
                async:false,

                success: function (r) {
                    if(r.code == 0){
                       src = r.data.src;
                    }
                },
                error: function (e) {
                   // console.log(e)
                }
            });
            return src;
        }
        /**
         * 获取我的回答
         * @param Object   blankList 题目对象
         * @param Object   curr     当前题目对象
         * @return string   答案
         *
         * */
        function getAnswer(blankList, curr) {
            var mychoicestr = '';
            var type = curr.question.queType;
            switch (type) {
                case 'C':
                    for (key in blankList) {
                        if (/ebh_1_data-latexebh_2_/.test(blankList[key].content)) {
                            var bsubjecthtml = blankList[key].content.replace(/ebh_1_/g, ' ').replace(/ebh_2_/g, '=');
                            bsubjecthtml = '<img ' + bsubjecthtml + ' />';
                            mychoicestr += bsubjecthtml ? bsubjecthtml : '<font color="red">未作答</font>';
                        } else {
                            mychoicestr += blankList[key].content ? blankList[key].content : '<font color="red">未作答</font>';
                        }

                        if (key < blankList.length - 1)
                            mychoicestr += ';&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    }
                    break;
                case 'A':
                    var trueanswer = '';
                    var aindex = -2;
                    var maindex = -2;
                    while (aindex != -1) {
                        if (aindex == -2)
                            aindex = curr.question.choicestr.indexOf(1)
                        else
                            aindex = curr.question.choicestr.indexOf(1, aindex + 1);

                        if (aindex >= 0)
                            trueanswer += String.fromCharCode(parseInt(aindex) + 65);
                    }
                    while (maindex != -1) {
                        if (maindex == -2) {
                            maindex = curr.answerQueDetail.choicestr.indexOf(1)
                        } else {
                            maindex = curr.answerQueDetail.choicestr.indexOf(1, maindex + 1);
                        }
                        if (maindex >= 0) {
                            mychoicestr += String.fromCharCode(parseInt(maindex) + 65);
                        }

                    }
                    break;
                case 'B':
                    var trueanswer = '';
                    var aindex = -2;
                    var maindex = -2;
                    while (aindex != -1) {
                        if (aindex == -2)
                            aindex = curr.question.choicestr.indexOf(1)
                        else
                            aindex = curr.question.choicestr.indexOf(1, aindex + 1);

                        if (aindex >= 0)
                            trueanswer += String.fromCharCode(parseInt(aindex) + 65);
                    }
                    while (maindex != -1) {
                        if (maindex == -2) {
                            maindex = curr.answerQueDetail.choicestr.indexOf(1)
                        } else {
                            maindex = curr.answerQueDetail.choicestr.indexOf(1, maindex + 1);
                        }
                        if (maindex >= 0) {
                            mychoicestr += String.fromCharCode(parseInt(maindex) + 65);
                        }

                    }
                    break;


            }
            return mychoicestr == '' ? '未解答' : mychoicestr;

        }

        //时间结束选择
        $.extend(
            {
                /**
                 * 处理时间选择
                 * @param db
                 */
                changeTime: function (db) {
                    return;
                    var startdate = document.getElementById('start').value;
                    if (startdate == '') {
                        d = parent.dialog({
                            title: '错误',
                            content: '请先选择开始时间！',
                            okValue: '确定',
                            cancel: false,
                            ok: function () {
                            }
                        });
                        d.showModal();
                        document.getElementById('end').value = '';
                        return;
                    }
                    var enddate = db.cal.newdate.y + '-' + db.cal.newdate.M + '-' + db.cal.newdate.d;
                    var param = {startdate: startdate, enddate: enddate};
                    param = postData(param);
                    getErrorList('', param);

                }

            }
        );

        //多选框
        $(document).on('change', 'input[type="checkbox"]', function () {
            var id = this.id;
            //全选动作
            if (id == 'myallquet') {
                var isChecked = this.checked;

                $('input[type="checkbox"]').each(function () {
                    this.checked = isChecked;
                });
                if (!isChecked) {
                    setCookie('ebh_total_num', 0);
                    parent.resetmain();
                    return false;
                }
            } else {
                //只要选择子类其中一个全选勾上
                var checkedNum = 0;
                $('input[type="checkbox"]').each(function () {
                    if (this.checked && this.id != 'myallquet')
                        checkedNum++;
                });
                if (checkedNum > 0 && checkedNum == 6) {
                    document.getElementById('myallquet').checked = true;
                } else {
                    document.getElementById('myallquet').checked = false;
                }
                if (checkedNum == 0) {
                    setCookie('ebh_total_num', 0);
                    parent.resetmain();
                    return false;

                }
            }
            param = postData();
            getErrorList($.tid, param);
            return false;
        })
        //知识选择后关闭
        $(document).on('click', '#thirdselectpanel a', function () {
            $('#thirdselectpanel').hide();
        });

        //获取请求参数
        var postData = function (param) {
            param = param || {};


            //取时间
            var startdate = document.getElementById('start').value;
            if (startdate != '') {
                startdate += ' 00:00:00';
                param.startdate = getStrToUnix(startdate);
            }

            var enddate = document.getElementById('end').value;
            if (enddate != '') {
                enddate += ' 23:59:59';
                param.enddate = getStrToUnix(enddate);
            }

            //取题型过滤
            var quetypeList = [];
            $('input[type="checkbox"]').each(function () {
                if (this.checked) {
                    if (this.value != '0') {
                        quetypeList.push(this.value);
                    }
                }
            });
            if (quetypeList.length == 0) {
                var cmain_bottom = '<div class="cmain_bottom " style="width: 100%; min-height: 400px; background:#fff">' +
                    '<div class="study" style="margin: 0 auto; width: 205px;">' +
                    '<div class="nodata"></div>' +
                    '<p class="zwktrykc" style="text-align: center;"></p>' +
                    '</div>' +
                    '</div>';
                $('#errlist').empty().append(cmain_bottom);
                $('#mpage').empty();
//                return false;
            }
            param.quetypeList = quetypeList;
            //获取课程id
            $.tid = $('#folderid').attr('tag');
//           param.folderid = document.getElementById('courseselecttit').getAttribute('tag');
            param.topchapterid = $('#middleselecttitle').attr('tag');
            param.secchapterid = $('#mysecondselecttitle').attr('tag');
            param.chapterid = $('#mythirdselecttitle').attr('tag');
            return param;
        }

        function getErrorList(tid, param, url) {
            //打开加载框
            layer.load(2);
            $('.layui-layer-loading').css({top:'100px'});
            if (typeof url == "undefined" && (!param.hasOwnProperty('url'))) {
                url = '/college/examv2/errlistAjax.html';
            } else {
                url = url || param.url;
            }
            //folderid:param.folderid,chapterid:param.chapterid,quetype:param.quetype,topchapterid:param.topchapterid,secchapterid:param.secchapterid

            var chapterpath = '';
            var cur = $('.nodeSel');
            while (cur.length) {
                if (cur.attr('id') == 'smyd0')
                    break;
                var h = cur.attr('href');
                var reg = /([0-9]+)/g;
                var cid = h.match(reg)[0];
                chapterpath = '/' + cid + chapterpath;
                cur = cur.parent().parent().prev('.dTreeNode').find('.node');
            }
            var path = param.topchapterid != 0 ? (param.topchapterid + (param.secchapterid != 0 ? '/' + param.secchapterid + (chapterpath ? chapterpath : param.chapterid != 0 ? '/' + param.chapterid : '') : '')) : '';
            var ttype = path ? 'CHAPTER' : 'FOLDER';
            if (!param.quetypeList) {
                return false;
            }
            $.ajax({
                url: url,
                method: 'post',
                dataType: 'json',
                data: {
                    ttype: ttype,
                    tid: tid,

                    quetypeList: param.quetypeList,
                    chapterid: param.chapterid,
                    topchapterid: param.topchapterid,
                    secchapterid: param.secchapterid,
                    path: path,
                    q: param.q,
                    startdate: param.startdate,
                    enddate: param.enddate
                }
            }).done(function (res) {
                layer.closeAll();
                $("#errlist").empty();
                var errList = res.datas.errList;
                var totalNum = typeof res.datas.totalNum != 'undefined' ? res.datas.totalNum : 0;
                setCookie('ebh_total_num', totalNum);
                if (errList.length <= 0) {
                    $('#mpage').empty();
                    var cmain_bottom = '<div class="cmain_bottom " style="width: 100%; min-height: 400px; background:#fff">' +
                        '<div class="study" style="margin: 0 auto; width: 205px;">' +
                        '<div class="nodata"></div>' +
                        '<p class="zwktrykc" style="text-align: center;"></p>' +
                        '</div>' +
                        '</div>';
                    $('#errlist').empty().append(cmain_bottom);
                } else {
                    for (var i = 0; i < errList.length; i++) {
                        var queType = errList[i].question.queType;
                        if (errList[i].question.queType == 'C') {
                            var qsubject = errList[i].question.qsubject.replace(/#input#/g, '<input type="text" readonly="readonly" maxlength="2147483647" size="20" value="">');
                            qsubject = qsubject.replace(/#img#/g, '<input type="text" readonly="readonly" maxlength="2147483647" size="20" value="">');
                        } else {
                            var qsubject = errList[i].question.qsubject;
                        }

                        if (queType == 'C') {
                            var choicestr = [];
                            var bidarr = [];
                            var answerblankarr = [];
                            for (var j = 0; j < errList[i].question.blanks.blankList.length; j++) {
                                if (/ebh_1_data-latexebh_2_/.test(errList[i].question.blanks.blankList[j].bsubject)) {
                                    var bsubjecthtml = unescape(errList[i].question.blanks.blankList[j].bsubject.replace(/ebh_1_/g, ' ').replace(/ebh_2_/g, '='));
                                    bsubjecthtml = '<img ' + bsubjecthtml + ' />';
                                    choicestr.push(bsubjecthtml);
                                } else {
                                    choicestr.push(errList[i].question.blanks.blankList[j].bsubject);
                                }
                                bidarr.push(errList[i].answerQueDetail.answerBlankDetails[j].bid);
                            }
                            for (var k = 0; k < errList[i].answerQueDetail.answerBlankDetails.length; k++) {
                                var bid = errList[i].answerQueDetail.answerBlankDetails[k].bid;
                                answerblankarr[bid] = errList[i].answerQueDetail.answerBlankDetails[k]
                            }
                            var choicestr = choicestr.join(';&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')
                            var extdata = $.parseJSON(errList[i].question.extdata)
                            var mychoicestr = '';
                            for (key in bidarr) {
                                if (/ebh_1_data-latexebh_2_/.test(answerblankarr[bidarr[key]].content)) {
                                    var bsubjecthtml = answerblankarr[bidarr[key]].content.replace(/ebh_1_/g, ' ').replace(/ebh_2_/g, '=');
                                    bsubjecthtml = '<img ' + bsubjecthtml + ' />';
                                    mychoicestr += bsubjecthtml ? bsubjecthtml : '<font color="red">未作答</font>';
                                } else {
                                    mychoicestr += answerblankarr[bidarr[key]].content ? answerblankarr[bidarr[key]].content : '<font color="red">未作答</font>';
                                }

                                if (key < bidarr.length - 1)
                                    mychoicestr += ';&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                            }
                            //var mychoicestr = errList[i].answerQueDetail.data;
                        } else if (queType == 'E') {
                            var choicestr = errList[i].question.blanks.blankList[0].bsubject;
                        } else if (queType == 'A' || queType == 'B') {
                            // alert();
                            var trueanswer = '';
                            var myanswer = '';
                            var aindex = -2;
                            var maindex = -2;
                            while (aindex != -1) {
                                if (aindex == -2)
                                    aindex = errList[i].question.choicestr.indexOf(1)
                                else
                                    aindex = errList[i].question.choicestr.indexOf(1, aindex + 1);

                                if (aindex >= 0)
                                    trueanswer += String.fromCharCode(parseInt(aindex) + 65);
                            }
                            while (maindex != -1) {
                                if (maindex == -2) {
                                    maindex = errList[i].answerQueDetail.choicestr.indexOf(1)
                                } else {
                                    maindex = errList[i].answerQueDetail.choicestr.indexOf(1, maindex + 1);

                                }
                                ;
                                if (maindex >= 0) {
                                    myanswer += String.fromCharCode(parseInt(maindex) + 65);
                                }

                            }
                            var choicestr = trueanswer;
                            var mychoicestr = myanswer;
                        } else if (queType == 'H') {
                            //原图
                            var cwurlH = 'http://up.ebh.net/exam/getsubthumb.html?orinote=1&uid=' + errList[i].uid + '&origin=1&key=' + encodeURIComponent(errList[i].question.blanks.key);
                            //答题后的图
                            var answerH = 'http://up.ebh.net/exam/getsubthumb.html?uid=' + errList[i].uid + '&origin=1&key=' + encodeURIComponent(errList[i].question.blanks.key) + '';
                            var datelineH = getLocalTime(errList[i].dateline);
                            var choicestr = errList[i].question.choicestr;
                            if (errList[i].question.blanks.key) {
                                var keyH = errList[i].question.blanks.key;
                            } else {
                                var keyH = "";
                            }
                            var typeH = errList[i].question.blanks.type;
                        } else {
                            var choicestr = errList[i].question.choicestr;
                        }

                        if (errList[i].question.extdata == '') {
                            var extdata = '';
                        } else {
                            var extdata = $.parseJSON(errList[i].question.extdata);
                            extdata.fenxi = extdata.fenxi.replace(/<br>/, '')
                            extdata.jx = extdata.jx.replace(/<br>/, '');
                            extdata.dp = extdata.dp.replace(/<br>/, '');
                        }
                        mychoicestr = mychoicestr ? mychoicestr : '<font color="red">未作答</font>';

                        var page = parseInt(res.datas.page)
                        if (errList[i].exam.esubject.length > 40) {
                            var sesubject = errList[i].exam.esubject.substring(0, 40) + "...";
                        } else {
                            var sesubject = errList[i].exam.esubject;
                        }
                        var data = {
                            page: page - 1,
                            i: i,
                            keycode: 65,
                            queType: errList[i].question.queType,
                            sesubject: sesubject,
                            esubject: errList[i].exam.esubject,
                            dateline: getLocalTime(errList[i].question.dateline),
                            blanks: errList[i].question.blanks.blankList || [],
                            quescore: errList[i].question.quescore,
                            qsubject: qsubject,
                            choicestr: choicestr,
                            errorCount: errList[i].errorCount,
                            extdata: extdata,
                            qid: errList[i].question.qid,
                            mychoicestr: mychoicestr,
                            cwurlH: cwurlH,
                            answerH: answerH,
                            datelineH: datelineH,
                            keyH: keyH,
                            typeH: typeH
                        };
                        var $dom = $(template('t:que', data));
                        $("#errlist").append($dom);
                        $('#errlist br').remove();
                    }
                    $('#mpage').empty().append(res.datas.pagestr);
                    $('.radioBox label ').each(function () {
                        $(this).text(String.fromCharCode($(this).attr('bid')));
                    })
                    var ii = setInterval(function () {
                        var allready = true;
                        $.each($('img'), function (v) {
                            if ($(this)[0].complete == false) {
                                allready = false;
                                return false;
                            }
                        });
                        if (allready == true) {
                            parent.resetmain();
                            window.clearInterval(ii);
                        }
                    }, 1000);
                    //关闭加载框

                    parent.resetmain();
                }

            }).fail(function () {
                //关闭加载框
                layer.closeAll();
                console.log('req err');
            });

        }

    }
</script>