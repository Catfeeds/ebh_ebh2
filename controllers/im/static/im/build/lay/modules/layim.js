/** layui-v1.0.2 经典模块化前端框架 LGPL license By www.layui.com */
;
layui.define(["layer", "laytpl", "upload"],
function(i) {
    var a = "2.0.9",
    e = layui.jquery,
    t = layui.layer,
    n = layui.laytpl,
    l = "layim-show",
    s = "layim-this",
    o = 20,
    r = {},
    d = function() {
        this.v = a,
        e("body").on("click", "*[layim-event]",
        function(i) {
            var a = e(this),
            t = a.attr("layim-event");
            U[t] ? U[t].call(this, a, i) : ""
        })
    };
    d.prototype.config = function(i) {
        var a = [];
        if (layui.each(Array(4),
        function(i) {
            a.push(layui.cache.dir + "css/modules/layim/skin/" + (i + 1) + ".jpg")
        }), i = i || {},
        i.skin = i.skin || [], layui.each(i.skin,
        function(i, e) {
            a.unshift(e)
        }), i.skin = a, i = e.extend({
            isfriend: !0,
            isgroup: !0
        },
        i), window.JSON && window.JSON.parse) return S(i),
        this
    },
    d.prototype.on = function(i, a) {
        return "function" == typeof a && (r[i] ? r[i].push(a) : r[i] = [a]),
        this
    },
    d.prototype.cache = function() {
        return C
    },
    d.prototype.chat = function(i, a) {
        if (window.JSON && window.JSON.parse) return L(i, a),
        this
    },
    d.prototype.setChatMin = function() {
        return M(),
        this
    },
    d.prototype.getMessage = function(i) {
        return D(i),
        this
    },
    d.prototype.addList = function(i) {
        return z(i),
        this
    },
    d.prototype.removeList = function(i) {
        return _(i),
        this
    },
    d.prototype.content = function(i) {
        return layui.data.content(i)
    };
    var u = function(i) {
        var a = {
            friend: "该分组下暂无好友",
            group: "暂无群组",
            history: "暂无历史会话"
        };
        return i = i || {},
        i.item = i.item || "d." + i.type,
        ["{{# var length = 0; layui.each(" + i.item + ", function(i, data){ length++; }}", '<li layim-event="chat" data-type="' + i.type + '" data-index="{{ ' + (i.index || "i") + ' }}" id="layim-' + i.type + '{{ data.id }}"><img src="{{ data.avatar }}"><span>{{ data.username||data.groupname||data.name||"佚名" }}</span><p>{{ data.remark||data.sign||"" }}</p></li>', "{{# }); if(length === 0){ }}", '<li class="layim-null">' + (a[i.type] || "暂无数据") + "</li>", "{{# } }}"].join("")
    },
    c = ['<div class="layui-layim-main">', '<div class="layui-layim-info">', '<div class="layui-layim-user">{{ d.mine.username }}</div>', '<div class="layui-layim-status">', '{{# if(d.mine.status === "online"){ }}', '<span class="layui-icon layim-status-online" layim-event="status" lay-type="show">&#xe617;</span>', '{{# } else if(d.mine.status === "hide") { }}', '<span class="layui-icon layim-status-hide" layim-event="status" lay-type="show">&#xe60f;</span>', "{{# } }}", '<ul class="layui-anim layim-menu-box">', '<li {{d.mine.status === "online" ? "class=layim-this" : ""}} layim-event="status" lay-type="online"><i class="layui-icon">&#xe618;</i><cite class="layui-icon layim-status-online">&#xe617;</cite>在线</li>', '<li {{d.mine.status === "hide" ? "class=layim-this" : ""}} layim-event="status" lay-type="hide"><i class="layui-icon">&#xe618;</i><cite class="layui-icon layim-status-hide">&#xe60f;</cite>隐身</li>', "</ul>", "</div>", '<p class="layui-layim-remark" title="{{# if(d.mine.sign){ }}{{d.mine.sign}}{{# } }}">{{ d.mine.remark||d.mine.sign||"你很懒，没有写签名" }}</p>', "</div>", '<ul class="layui-layim-tab{{# if(!d.base.isfriend || !d.base.isgroup){ }}', " layim-tab-two", '{{# } }}">', '<li class="layui-icon', "{{# if(!d.base.isfriend){ }}", " layim-hide", "{{# } else { }}", " layim-this", "{{# } }}", '" title="联系人" layim-event="tab" lay-type="friend">&#xe612;</li>', '<li class="layui-icon', "{{# if(!d.base.isgroup){ }}", " layim-hide", "{{# } else if(!d.base.isfriend) { }}", " layim-this", "{{# } }}", '" title="群组" layim-event="tab" lay-type="group">&#xe613;</li>', '<li class="layui-icon" title="历史会话" layim-event="tab" lay-type="history">&#xe611;</li>', "</ul>", '<ul class="layim-tab-content {{# if(d.base.isfriend){ }}layim-show{{# } }} layim-list-friend">', '{{# layui.each(d.friend, function(index, item){ var spread = d.local["spread"+index]; }}', "<li>", '<h5 layim-event="spread" lay-type="{{ spread }}"><i class="layui-icon">{{# if(spread === "true"){ }}&#xe61a;{{# } else {  }}&#xe602;{{# } }}</i><span>{{ item.groupname||"未命名分组"+index }}</span><em>(<cite class="layim-count"> {{ (item.list||[]).length }}</cite>)</em></h5>', '<ul class="layui-layim-list {{# if(spread === "true"){ }}', " layim-show", '{{# } }}">', u({
        type: "friend",
        item: "item.list",
        index: "index"
    }), "</ul>", "</li>", "{{# }); if(d.friend.length === 0){ }}", '<li><ul class="layui-layim-list layim-show"><li class="layim-null">暂无联系人</li></ul>', "{{# } }}", "</ul>", '<ul class="layim-tab-content {{# if(!d.base.isfriend && d.base.isgroup){ }}layim-show{{# } }}">', "<li>", '<ul class="layui-layim-list layim-show layim-list-group">', u({
        type: "group"
    }), "</ul>", "</li>", "</ul>", '<ul class="layim-tab-content  {{# if(!d.base.isfriend && !d.base.isgroup){ }}layim-show{{# } }}">', "<li>", '<ul class="layui-layim-list layim-show layim-list-history">', u({
        type: "history"
    }), "</ul>", "</li>", "</ul>", '<ul class="layim-tab-content">', "<li>", '<ul class="layui-layim-list layim-show" id="layui-layim-search"></ul>', "</li>", "</ul>", '<ul class="layui-layim-tool">', '<li class="layui-icon layim-tool-search" layim-event="search" title="搜索">&#xe615;</li>', '<li class="layui-icon layim-tool-skin" layim-event="skin" title="换肤">&#xe61b;</li>', "{{# if(d.base.find){ }}", '<li class="layui-icon layim-tool-find" layim-event="find" title="查找">&#xe61f;</li>', "{{# } }}", "{{# if(!d.base.copyright){ }}", '<li class="layui-icon layim-tool-about" layim-event="about" title="关于">&#xe60b;</li>', "{{# } }}", "</ul>", '<div class="layui-layim-search"><input><label class="layui-icon" layim-event="closeSearch">&#x1007;</label></div>', "</div>"].join(""),
    y = ['<ul class="layui-layim-skin">', "{{# layui.each(d.skin, function(index, item){ }}", '<li><img layim-event="setSkin" src="{{ item }}"></li>', "{{# }); }}", '<li layim-event="setSkin"><cite>默认</cite></li>', "</ul>"].join(""),
    m = ['<div class="layim-chat layim-chat-{{d.data.type}}">', '<div class="layim-chat-title">', '<a class="layim-chat-other">', '<img src="{{ d.data.avatar }}"><span layim-event="{{ d.data.type==="group" ? "groupMembers" : "" }}">{{ d.data.name||"佚名" }} {{d.data.temporary ? "<cite>临时会话</cite>" : ""}} {{# if(d.data.type==="group"){ }} <em class="layim-chat-members"></em><i class="layui-icon">&#xe61a;</i> {{# } }}</span>', "</a>", "</div>", '<div class="layim-chat-main">', "<ul></ul>", "</div>", '<div class="layim-chat-footer">', '<div class="layim-chat-tool" data-json="{{encodeURIComponent(JSON.stringify(d.data))}}">', '<span class="layui-icon layim-tool-face" title="选择表情" layim-event="face">&#xe60c;</span>', "{{# if(d.base && d.base.uploadImage){ }}", '<span class="layui-icon layim-tool-image" title="上传图片" layim-event="image">&#xe60d;<input type="file" name="file"></span>', "{{# }; }}", "{{# if(d.base && d.base.uploadFile){ }}", '<span class="layui-icon layim-tool-image" title="发送文件" layim-event="image" data-type="file">&#xe61d;<input type="file" name="file"></span>', "{{# }; }}", "{{# if(d.base && d.base.chatLog){ }}", '<span class="layim-tool-log" layim-event="chatLog"><i class="layui-icon">&#xe60e;</i>聊天记录</span>', "{{# }; }}", "</div>", '<div class="layim-chat-textarea"><textarea></textarea></div>', '<div class="layim-chat-bottom">', '<div class="layim-chat-send">', "{{# if(!d.base.brief){ }}", '<span class="layim-send-close" layim-event="closeThisChat">关闭</span>', "{{# } }}", '<span class="layim-send-btn" layim-event="send">发送</span>', '<span class="layim-send-set" layim-event="setSend" lay-type="show"><em class="layui-edge"></em></span>', '<ul class="layui-anim layim-menu-box">', '<li {{d.local.sendHotKey !== "Ctrl+Enter" ? "class=layim-this" : ""}} layim-event="setSend" lay-type="Enter"><i class="layui-icon">&#xe618;</i>按Enter键发送消息</li>', '<li {{d.local.sendHotKey === "Ctrl+Enter" ? "class=layim-this" : ""}} layim-event="setSend"  lay-type="Ctrl+Enter"><i class="layui-icon">&#xe618;</i>按Ctrl+Enter键发送消息</li>', "</ul>", "</div>", "</div>", "</div>", "</div>"].join(""),
    f = function(i) {
        return i < 10 ? "0" + (0 | i) : i
    };
    layui.data.date = function(i) {
        var a = new Date(i || new Date);
        return a.getFullYear() + "-" + f(a.getMonth() + 1) + "-" + f(a.getDate()) + " " + f(a.getHours()) + ":" + f(a.getMinutes()) + ":" + f(a.getSeconds())
    },
    layui.data.content = function(i) {
        var a = function(i) {
            return new RegExp("\\n*\\[" + (i || "") + "(pre|div|p|table|thead|th|tbody|tr|td|ul|li|ol|li|dl|dt|dd|h2|h3|h4|h5)([\\s\\S]*?)\\]\\n*", "g")
        };
        return i = (i || "").replace(/&(?!#?[a-zA-Z0-9]+;)/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/'/g, "&#39;").replace(/"/g, "&quot;").replace(/@(\S+)(\s+?|$)/g, '@<a href="javascript:;">$1</a>$2').replace(/\s{2}/g, "&nbsp").replace(/img\[([^\s]+?)\]/g,
        function(i) {
            return '<img class="layui-layim-photos" src="' + i.replace(/(^img\[)|(\]$)/g, "") + '">'
        }).replace(/file\([\s\S]+?\)\[[\s\S]*?\]/g,
        function(i) {
            var a = (i.match(/file\(([\s\S]+?)\)\[/) || [])[1],
            e = (i.match(/\)\[([\s\S]*?)\]/) || [])[1];
            return a ? '<a class="layui-layim-file" href="' + a + '" target="_blank"><i class="layui-icon">&#xe61e;</i><cite>' + (e || a) + "</cite></a>": i
        }).replace(/face\[([^\s\[\]]+?)\]/g,
        function(i) {
            var a = i.replace(/^face/g, "");
            return '<img alt="' + a + '" title="' + a + '" src="' + J[a] + '">'
        }).replace(/a\([\s\S]+?\)\[[\s\S]*?\]/g,
        function(i) {
            var a = (i.match(/a\(([\s\S]+?)\)\[/) || [])[1],
            e = (i.match(/\)\[([\s\S]*?)\]/) || [])[1];
            return a ? '<a href="' + a + '" target="_blank">' + (e || a) + "</a>": i
        }).replace(a(), "<$1 $2>").replace(a("/"), "</$1>").replace(/\n/g, "<br>")
    };
    var p, h, g, v, b, x = ['<li {{ d.mine ? "class=layim-chat-mine" : "" }}>', '<div class="layim-chat-user"><img src="{{ d.avatar }}"><cite>', "{{# if(d.mine){ }}", '<i>{{ layui.data.date(d.timestamp) }}</i>{{ d.username||"佚名" }}', "{{# } else { }}", '{{ d.username||"佚名" }}<i>{{ layui.data.date(d.timestamp) }}</i>', "{{# } }}", "</cite></div>", '<div class="layim-chat-text">{{ layui.data.content(d.content||"&nbsp") }}</div>', "</li>"].join(""),
    k = '<li class="layim-chatlist-{{ d.data.type }}{{ d.data.id }} layim-this" layim-event="tabChat"><img src="{{ d.data.avatar }}"><span>{{ d.data.name||"佚名" }}</span>{{# if(!d.base.brief){ }}<i class="layui-icon" layim-event="closeChat">&#x1007;</i>{{# } }}</li>',
    w = function(i, a, n) {
        return i = i || {},
        e.ajax({
            url: i.url,
            type: i.type || "get",
            data: i.data,
            dataType: i.dataType || "json",
            cache: !1,
            success: function(i) {
                0 == i.code ? a && a(i.data || {}) : t.msg(i.msg || (n || "Error") + ": LAYIM_NOT_GET_DATA", {
                    time: 5e3
                })
            },
            error: function(i, a) {
                window.console && console.log && console.error("LAYIM_DATE_ERROR：" + a)
            }
        })
    },
    C = {
        message: {},
        chat: []
    },
    S = function(i) {
        var a = i.mine || {},
        t = layui.data("layim")[a.id] || {},
        l = {
            base: i,
            local: t,
            mine: a,
            history: t.history || {}
        };
        return C = e.extend(C, l),
        i.brief ? layui.each(r.ready,
        function(i, a) {
            a && a(l)
        }) : void w(i.init,
        function(a) {
            var t = i.mine || a.mine || {},
            l = layui.data("layim")[t.id] || {},
            s = {
                base: i,
                local: l,
                mine: t,
                friend: a.friend || [],
                group: a.group || [],
                history: l.history || {}
            };
            C = e.extend(C, s),
            T(n(c).render(s)),
            (l.close || i.min) && j(),
            layui.each(r.ready,
            function(i, a) {
                a && a(s)
            })
        },
        "INIT")
    },
    T = function(i) {
        return t.open({
            type: 1,
            area: ["260px", "520px"],
            skin: "layui-box layui-layim",
            title: "&#8203;",
            offset: "rb",
            id: "layui-layim",
            shade: !1,
            moveType: 1,
            shift: 2,
            content: i,
            success: function(i) {
                var a = layui.data("layim")[C.mine.id] || {},
                n = a.skin;
                p = i,
                p.css({
                    "background-image": n ? "url(" + n + ")": "none"
                }),
                C.base.right && i.css("margin-left", "-" + C.base.right),
                h && t.close(h.attr("times"));
                var l = [],
                s = i.find(".layim-list-history");
                s.find("li").each(function() {
                    l.push(e(this).prop("outerHTML"))
                }),
                l.length > 0 && (l.reverse(), s.html(l.join(""))),
                I()
            },
            cancel: function(i) {
                j();
                var a = layui.data("layim")[C.mine.id] || {};
                return a.close = !0,
                layui.data("layim", {
                    key: C.mine.id,
                    value: a
                }),
                !1
            }
        })
    },
    I = function() {
        p.on("contextmenu",
        function(i) {
            return i.cancelBubble = !0,
            i.returnValue = !1,
            !1
        });
        var i = function() {
            t.closeAll("tips")
        };
        p.find(".layim-list-history").on("contextmenu", "li",
        function(a) {
            var n = e(this),
            l = '<ul data-id="' + n[0].id + '" data-index="' + n.data("index") + '"><li layim-event="menuHistory" data-type="one">移除该会话</li><li layim-event="menuHistory" data-type="all">清空全部会话列表</li></ul>';
            n.hasClass("layim-null") || (t.tips(l, this, {
                tips: 1,
                time: 0,
                shift: 5,
                fix: !0,
                skin: "layui-box layui-layim-contextmenu",
                success: function(i) {
                    var a = function(i) {
                        B(i)
                    };
                    i.off("mousedown", a).on("mousedown", a)
                }
            }), e(document).off("mousedown", i).on("mousedown", i), e(window).off("resize", i).on("resize", i))
        })
    },
    j = function(i) {
        return h && t.close(h.attr("times")),
        p && p.hide(),
        C.mine = C.mine || {},
        t.open({
            type: 1,
            title: !1,
            id: "layui-layim-close",
            skin: "layui-box layui-layim-min layui-layim-close",
            shade: !1,
            closeBtn: !1,
            shift: 2,
            offset: "rb",
            content: '<img src="' + (C.mine.avatar || layui.cache.dir + "css/pc/layim/skin/logo.jpg") + '"><span>' + (i || C.base.title || "我的LayIM") + "</span>",
            success: function(i, a) {
                h = i,
                C.base.right && i.css("margin-left", "-" + C.base.right),
                i.on("click",
                function() {
                    t.close(a),
                    p.show();
                    var i = layui.data("layim")[C.mine.id] || {};
                    delete i.close,
                    layui.data("layim", {
                        key: C.mine.id,
                        value: i
                    })
                })
            }
        })
    },
    L = function(i) {
        i = i || {};
        var a = e("#layui-layim-chat"),
        l = {
            data: i,
            base: C.base,
            local: C.local
        };
        if (!i.id) return t.msg("非法用户");
        if (a[0]) {
            var s = g.find(".layim-chat-list"),
            o = s.find(".layim-chatlist-" + i.type + i.id);
            return "none" === g.css("display") && g.show(),
            v && t.close(v.attr("times")),
            1 !== s.find("li").length || o[0] || (g.css("width", "800px"), s.css("display", "inline-block")),
            o[0] || (s.append(n(k).render(l)), a.append(n(m).render(l))),
            E(s.find(".layim-chatlist-" + i.type + i.id)),
            o[0] || R(),
            O(i),
            $(),
            b
        }
        var d = b = t.open({
            type: 1,
            area: ["600px", "520px"],
            skin: "layui-box layui-layim-chat",
            id: "layui-layim-chat",
            title: "&#8203;",
            shade: !1,
            moveType: 1,
            maxmin: !0,
            closeBtn: !C.base.brief && 1,
            content: n('<ul class="layim-chat-list">' + k + "</ul>" + m).render(l),
            success: function(a) {
                var e = layui.data("layim")[C.mine.id] || {},
                n = e.skin;
                g = a,
                g.css({
                    "background-image": n ? "url(" + n + ")": "none"
                }),
                $(),
                O(i),
                layui.each(r.chatChange,
                function(i, a) {
                    a && a(H())
                }),
                R(),
                q(),
                a.on("click", ".layui-layim-photos",
                function() {
                    var i = this.src;
                    t.close(L.photosIndex),
                    t.photos({
                        photos: {
                            data: [{
                                alt: "大图模式",
                                src: i
                            }]
                        },
                        shade: .01,
                        closeBtn: 2,
                        shift: 0,
                        success: function(i, a) {
                            L.photosIndex = a
                        }
                    })
                })
            },
            min: function() {
                return M(),
                !1
            },
            end: function() {
                t.closeAll("tips")
            }
        });
        return d
    },
    M = function(i) {
        var a = i || H().data,
        n = layui.layim.cache().base;
        g && !i && g.hide(),
        v && t.close(v.attr("times")),
        t.open({
            type: 1,
            title: !1,
            id: "layui-layim-min",
            skin: "layui-box layui-layim-min",
            shade: !1,
            closeBtn: !1,
            shift: a.shift || 2,
            offset: "b",
            move: "#layui-layim-min img",
            moveType: 1,
            area: ["182px", "54px"],
            content: '<img src="' + a.avatar + '"><span>' + a.name + "</span>",
            success: function(a, l) {
                i || (v = a),
                n.minRight && t.style(l, {
                    left: e(window).width() - a.outerWidth() - parseFloat(n.minRight)
                }),
                a.find(".layui-layer-content span").on("click",
                function() {
                    t.close(l),
                    i ? layui.each(C.chat,
                    function(i, a) {
                        L(a)
                    }) : g.show(),
                    i && (C.chat = [], K())
                }),
                a.find(".layui-layer-content img").on("click",
                function(i) {
                    B(i)
                })
            }
        })
    },
    E = function(i, a) {
        i = i || e(".layim-chat-list ." + s);
        var n = i.index() === -1 ? 0 : i.index(),
        l = ".layim-chat",
        o = g.find(l).eq(n);
        if (a) {
            i.hasClass(s) && E(0 === n ? i.next() : i.prev()),
            i.remove(),
            o.remove();
            var d = g.find(l).length;
            return 1 === d && (g.find(".layim-chat-list").hide(), g.css("width", "600px")),
            0 === d && t.close(b),
            !1
        }
        i.addClass(s).siblings().removeClass(s),
        o.css("display", "inline-block").siblings(l).hide(),
        o.find("textarea").focus(),
        layui.each(r.chatChange,
        function(i, a) {
            a && a(H())
        }),
        q()
    },
    q = function() {
        var i = H(),
        a = C.message[i.data.type + i.data.id];
        a && delete C.message[i.data.type + i.data.id]
    },
    H = function() {
        var i = e(".layim-chat-list ." + s).index(),
        a = g.find(".layim-chat").eq(i),
        t = JSON.parse(decodeURIComponent(a.find(".layim-chat-tool").data("json")));
        return {
            elem: a,
            data: t,
            textarea: a.find("textarea")
        }
    },
    O = function(i) {
        var a = layui.data("layim")[C.mine.id] || {},
        e = {},
        t = a.history || {},
        l = t[i.type + i.id];
        if (p) {
            var s = p.find(".layim-list-history");
            if (i.historyTime = (new Date).getTime(), t[i.type + i.id] = i, a.history = t, layui.data("layim", {
                key: C.mine.id,
                value: a
            }), !l) {
                e[i.type + i.id] = i;
                var o = n(u({
                    type: "history",
                    item: "d.data"
                })).render({
                    data: e
                });
                s.prepend(o),
                s.find(".layim-null").remove()
            }
        }
    },
    A = function() {
        var i = {
            username: C.mine ? C.mine.username: "访客",
            avatar: C.mine ? C.mine.avatar: layui.cache.dir + "css/pc/layim/skin/logo.jpg",
            id: C.mine ? C.mine.id: null,
            mine: !0
        },
        a = H(),
        e = a.elem.find(".layim-chat-main ul"),
        l = C.base.maxLength || 3e3;
        if (i.content = a.textarea.val(), "" !== i.content.replace(/\s/g, "")) {
            if (i.content.length > l) return t.msg("内容最长不能超过" + l + "个字符");
            e.append(n(x).render(i));
            var s = {
                mine: i,
                to: a.data
            },
            o = {
                username: s.mine.username,
                avatar: s.mine.avatar,
                id: s.to.id,
                type: s.to.type,
                content: s.mine.content,
                timestamp: (new Date).getTime(),
                mine: !0
            };
            N(o),
            layui.each(r.sendMessage,
            function(i, a) {
                a && a(s)
            })
        }
        K(),
        a.textarea.val("").focus()
    },
    D = function(i) {
        i = i || {};
        var a = e(".layim-chatlist-" + i.type + i.id),
        t = {},
        l = a.index();
        if (i.timestamp = i.timestamp || (new Date).getTime(), N(i), !g && i.content || l === -1) {
            if (C.message[i.type + i.id]) C.message[i.type + i.id].push(i);
            else if (C.message[i.type + i.id] = [i], "friend" === i.type) {
                var s;
                layui.each(C.friend,
                function(a, e) {
                    if (layui.each(e.list,
                    function(a, e) {
                        if (e.id == i.id) return e.type = "friend",
                        e.name = e.username,
                        C.chat.push(e),
                        s = !0
                    }), s) return ! 0
                }),
                s || (i.name = i.username, i.temporary = !0, C.chat.push(i))
            } else if ("group" === i.type) {
                var o;
                layui.each(C.group,
                function(a, e) {
                    if (e.id == i.id) return e.type = "group",
                    e.name = e.groupname,
                    C.chat.push(e),
                    o = !0
                }),
                o || (i.name = i.groupname, C.chat.push(i))
            } else i.name = i.name || i.username || i.groupname,
            C.chat.push(i);
            return "group" === i.type && layui.each(C.group,
            function(a, e) {
                if (e.id == i.id) return t.avatar = e.avatar,
                !0
            }),
            M({
                name: "收到新消息",
                avatar: t.avatar || i.avatar,
                shift: 6
            })
        }
        var r = H();
        r.data.type + r.data.id !== i.type + i.id && (a.addClass("layui-anim layer-anim-06"), setTimeout(function() {
            a.removeClass("layui-anim layer-anim-06")
        },
        300));
        var d = g.find(".layim-chat").eq(l),
        u = d.find(".layim-chat-main ul");
        "" !== i.content.replace(/\s/g, "") && u.append(n(x).render(i)),
        K()
    },
    N = function(i) {
        var a = layui.data("layim")[C.mine.id] || {},
        e = a.chatlog || {};
        e[i.type + i.id] ? (e[i.type + i.id].push(i), e[i.type + i.id].length > o && e[i.type + i.id].shift()) : e[i.type + i.id] = [i],
        a.chatlog = e,
        layui.data("layim", {
            key: C.mine.id,
            value: a
        })
    },
    R = function() {
        var i = layui.data("layim")[C.mine.id] || {},
        a = H(),
        e = i.chatlog || {},
        t = a.elem.find(".layim-chat-main ul");
        layui.each(e[a.data.type + a.data.id],
        function(i, a) {
            t.append(n(x).render(a))
        }),
        K()
    },
    z = function(i) {
        var a, e = p.find(".layim-list-" + i.type),
        l = {};
        if (C[i.type]) if ("friend" === i.type) layui.each(C.friend,
        function(e, n) {
            if (i.groupid == n.id) return layui.each(C.friend[e].list,
            function(e, t) {
                if (t.id == i.id) return a = !0
            }),
            a ? t.msg("好友 [" + (i.username || "") + "] 已经存在列表中", {
                shift: 6
            }) : (C.friend[e].list = C.friend[e].list || [], l[C.friend[e].list.length] = i, i.groupIndex = e, C.friend[e].list.push(i), !0)
        });
        else if ("group" === i.type) {
            if (layui.each(C.group,
            function(e, t) {
                if (t.id == i.id) return a = !0
            }), a) return t.msg("您已是 [" + (i.groupname || "") + "] 的群成员", {
                shift: 6
            });
            l[C.group.length] = i,
            C.group.push(i)
        }
        if (!a) {
            var s = n(u({
                type: i.type,
                item: "d.data",
                index: "friend" === i.type ? "data.groupIndex": null
            })).render({
                data: l
            });
            if ("friend" === i.type) {
                var o = e.find(">li").eq(i.groupIndex);
                o.find(".layui-layim-list").append(s),
                o.find(".layim-count").html(C.friend[i.groupIndex].list.length),
                o.find(".layim-null")[0] && o.find(".layim-null").remove()
            } else "group" === i.type && (e.append(s), e.find(".layim-null")[0] && e.find(".layim-null").remove())
        }
    },
    _ = function(i) {
        var a = p.find(".layim-list-" + i.type);
        C[i.type] && ("friend" === i.type ? layui.each(C.friend,
        function(e, t) {
            layui.each(t.list,
            function(t, n) {
                if (i.id == n.id) {
                    var l = a.find(">li").eq(e);
                    l.find(".layui-layim-list>li");
                    return l.find(".layui-layim-list>li").eq(t).remove(),
                    C.friend[e].list.splice(t, 1),
                    l.find(".layim-count").html(C.friend[e].list.length),
                    0 === C.friend[e].list.length && l.find(".layui-layim-list").html('<li class="layim-null">该分组下已无好友了</li>'),
                    !0
                }
            })
        }) : "group" === i.type && layui.each(C.group,
        function(e, t) {
            if (i.id == t.id) return a.find(">li").eq(e).remove(),
            C.group.splice(e, 1),
            0 === C.group.length && a.html('<li class="layim-null">暂无群组</li>'),
            !0
        }))
    },
    K = function() {
        var i = H(),
        a = i.elem.find(".layim-chat-main"),
        e = a.find("ul");
        if (e.find("li").length >= o) {
            var t = e.find("li").eq(0);
            e.prev().hasClass("layim-chat-system") || e.before('<div class="layim-chat-system"><span layim-event="chatLog">查看更多记录</span></div>'),
            t.remove()
        }
        a.scrollTop(a[0].scrollHeight),
        a.find("ul li:last").find("img").load(function() {
            a.scrollTop(a[0].scrollHeight)
        })
    },
    $ = function() {
        var i = H(),
        a = i.textarea;
        a.focus(),
        a.off("keydown").on("keydown",
        function(i) {
            var e = layui.data("layim")[C.mine.id] || {},
            t = i.keyCode;
            if ("Ctrl+Enter" === e.sendHotKey) return void(i.ctrlKey && 13 === t && A());
            if (13 === t) {
                if (i.ctrlKey) return a.val(a.val() + "\n");
                if (i.shiftKey) return;
                i.preventDefault(),
                A()
            }
        })
    },
    J = function() {
        var i = ["[微笑]", "[嘻嘻]", "[哈哈]", "[可爱]", "[可怜]", "[挖鼻]", "[吃惊]", "[害羞]", "[挤眼]", "[闭嘴]", "[鄙视]", "[爱你]", "[泪]", "[偷笑]", "[亲亲]", "[生病]", "[太开心]", "[白眼]", "[右哼哼]", "[左哼哼]", "[嘘]", "[衰]", "[委屈]", "[吐]", "[哈欠]", "[抱抱]", "[怒]", "[疑问]", "[馋嘴]", "[拜拜]", "[思考]", "[汗]", "[困]", "[睡]", "[钱]", "[失望]", "[酷]", "[色]", "[哼]", "[鼓掌]", "[晕]", "[悲伤]", "[抓狂]", "[黑线]", "[阴险]", "[怒骂]", "[互粉]", "[心]", "[伤心]", "[猪头]", "[熊猫]", "[兔子]", "[ok]", "[耶]", "[good]", "[NO]", "[赞]", "[来]", "[弱]", "[草泥马]", "[神马]", "[囧]", "[浮云]", "[给力]", "[围观]", "[威武]", "[奥特曼]", "[礼物]", "[钟]", "[话筒]", "[蜡烛]", "[蛋糕]"],
        a = {};
        return layui.each(i,
        function(i, e) {
            a[e] = layui.cache.dir + "images/face/" + i + ".gif"
        }),
        a
    } (),
    B = layui.stope,
    F = function(i, a) {
        var e, t = i.value;
        i.focus(),
        document.selection ? (e = document.selection.createRange(), document.selection.empty(), e.text = a) : (e = [t.substring(0, i.selectionStart), a, t.substr(i.selectionEnd)], i.focus(), i.value = e.join(""))
    },
    Y = "layui-anim-up",
    U = {
        status: function(i, a) {
            var t = function() {
                i.next().hide().removeClass(Y)
            },
            n = i.attr("lay-type");
            if ("show" === n) B(a),
            i.next().show().addClass(Y),
            e(document).off("click", t).on("click", t);
            else {
                var l = i.parent().prev();
                i.addClass(s).siblings().removeClass(s),
                l.html(i.find("cite").html()),
                l.removeClass("layim-status-" + ("online" === n ? "hide": "online")).addClass("layim-status-" + n),
                layui.each(r.online,
                function(i, a) {
                    a && a(n)
                })
            }
        },
        tab: function(i) {
            var a, e = ".layim-tab-content",
            t = p.find(".layui-layim-tab>li");
            "number" == typeof i ? (a = i, i = t.eq(a)) : a = i.index(),
            a > 2 ? t.removeClass(s) : (U.tab.index = a, i.addClass(s).siblings().removeClass(s)),
            p.find(e).eq(a).addClass(l).siblings(e).removeClass(l)
        },
        spread: function(i) {
            var a = i.attr("lay-type"),
            e = "true" === a ? "false": "true",
            t = layui.data("layim")[C.mine.id] || {};
            i.next()["true" === a ? "removeClass": "addClass"](l),
            t["spread" + i.parent().index()] = e,
            layui.data("layim", {
                key: C.mine.id,
                value: t
            }),
            i.attr("lay-type", e),
            i.find(".layui-icon").html("true" === e ? "&#xe61a;": "&#xe602;")
        },
        search: function(i) {
            var a = p.find(".layui-layim-search"),
            e = p.find("#layui-layim-search"),
            t = a.find("input"),
            n = function(i) {
                var a = t.val().replace(/\s/);
                if ("" === a) U.tab(0 | U.tab.index);
                else {
                    for (var n = [], l = C.friend || [], s = C.group || [], o = "", r = 0; r < l.length; r++) for (var d = 0; d < (l[r].list || []).length; d++) l[r].list[d].username.indexOf(a) !== -1 && (l[r].list[d].type = "friend", l[r].list[d].index = r, l[r].list[d].list = d, n.push(l[r].list[d]));
                    for (var u = 0; u < s.length; u++) s[u].groupname.indexOf(a) !== -1 && (s[u].type = "group", s[u].index = u, s[u].list = u, n.push(s[u]));
                    if (n.length > 0) for (var c = 0; c < n.length; c++) o += '<li layim-event="chat" data-type="' + n[c].type + '" data-index="' + n[c].index + '" data-list="' + n[c].list + '"><img src="' + n[c].avatar + '"><span>' + (n[c].username || n[c].groupname || "佚名") + "</span><p>" + (n[c].remark || n[c].sign || "") + "</p></li>";
                    else o = '<li class="layim-null">无搜索结果</li>';
                    e.html(o),
                    U.tab(3)
                }
            }; ! C.base.isfriend && C.base.isgroup ? U.tab.index = 1 : C.base.isfriend || C.base.isgroup || (U.tab.index = 2),
            a.show(),
            t.focus(),
            t.off("keyup", n).on("keyup", n)
        },
        closeSearch: function(i) {
            i.parent().hide(),
            U.tab(0 | U.tab.index)
        },
        skin: function() {
            t.open({
                type: 1,
                title: "换肤",
                shade: !1,
                area: "300px",
                skin: "layui-box layui-layer-border",
                id: "layui-layim-skin",
                zIndex: 66666666,
                content: n(y).render({
                    skin: C.base.skin
                })
            })
        },
        find: function() {
            t.open({
                type: 2,
                title: "查找",
                shade: !1,
                area: ["1000px", "520px"],
                skin: "layui-box layui-layer-border",
                id: "layui-layim-find",
                content: C.base.find
            })
        },
        about: function() {
            t.alert("版本： " + a + '<br>版权所有：<a href="http://layim.layui.com" target="_blank">layim.layui.com</a>', {
                title: "关于 LayIM",
                shade: !1
            })
        },
        setSkin: function(i) {
            var a = i.attr("src"),
            e = layui.data("layim")[C.mine.id] || {};
            e.skin = a,
            a || delete e.skin,
            layui.data("layim", {
                key: C.mine.id,
                value: e
            });
            try {
                p.css({
                    "background-image": a ? "url(" + a + ")": "none"
                }),
                g.css({
                    "background-image": a ? "url(" + a + ")": "none"
                })
            } catch(t) {}
        },
        chat: function(i) {
            var a = layui.data("layim")[C.mine.id] || {},
            e = i.data("type"),
            t = i.data("index"),
            n = i.attr("data-list") || i.index(),
            l = {};
            "friend" === e ? l = C[e][t].list[n] : "group" === e ? l = C[e][n] : "history" === e && (l = (a.history || {})[t] || {}),
            l.name = l.name || l.username || l.groupname,
            "history" !== e && (l.type = e),
            L(l)
        },
        tabChat: function(i) {
            E(i)
        },
        closeChat: function(i) {
            E(i.parent(), 1)
        },
        closeThisChat: function() {
            E(null, 1)
        },
        groupMembers: function(i, a) {
            var n = i.find(".layui-icon"),
            l = function() {
                n.html("&#xe61a;"),
                i.data("down", null),
                t.close(U.groupMembers.index)
            },
            s = function(i) {
                B(i)
            };
            i.data("down") ? l() : (n.html("&#xe619;"), i.data("down", !0), U.groupMembers.index = t.tips('<ul class="layim-members-list"></ul>', i, {
                tips: 3,
                time: 0,
                shift: 5,
                fix: !0,
                skin: "layui-box layui-layim-members",
                success: function(a) {
                    var t = C.base.members || {},
                    n = H(),
                    l = "";
                    t.data = e.extend(t.data, {
                        id: n.data.id
                    }),
                    w(t,
                    function(e) {
                        layui.each(e.list,
                        function(i, a) {
                            l += '<li><a><img src="' + a.avatar + '"></a><p>' + a.username + "</p></li>"
                        }),
                        a.find(".layim-members-list").html(l),
                        layui.each(r.members,
                        function(i, a) {
                            a && a(e)
                        }),
                        i.find(".layim-chat-members").html((e.list || []).length + "人")
                    }),
                    a.on("mousedown",
                    function(i) {
                        B(i)
                    })
                }
            }), e(document).off("mousedown", l).on("mousedown", l), e(window).off("resize", l).on("resize", l), i.off("mousedown", s).on("mousedown", s))
        },
        send: function() {
            A()
        },
        setSend: function(i, a) {
            var t = i.siblings(".layim-menu-box"),
            n = function() {
                t.hide().removeClass(Y)
            },
            l = i.attr("lay-type");
            if ("show" === l) B(a),
            t.show().addClass(Y),
            e(document).off("click", n).on("click", n);
            else {
                i.addClass(s).siblings().removeClass(s);
                var o = layui.data("layim")[C.mine.id] || {};
                o.sendHotKey = l,
                layui.data("layim", {
                    key: C.mine.id,
                    value: o
                })
            }
        },
        face: function(i, a) {
            var n = "",
            l = H(),
            s = function() {
                t.close(U.face.index)
            };
            for (var o in J) n += '<li title="' + o + '"><img src="' + J[o] + '"></li>';
            n = '<ul class="layui-clear layim-face-list">' + n + "</ul>",
            U.face.index = t.tips(n, i, {
                tips: 1,
                time: 0,
                fix: !0,
                skin: "layui-box layui-layim-face",
                success: function(i) {
                    i.find(".layim-face-list>li").on("mousedown",
                    function(i) {
                        B(i)
                    }).on("click",
                    function() {
                        F(l.textarea[0], "face" + this.title + " "),
                        t.close(U.face.index)
                    })
                }
            }),
            e(document).off("mousedown", s).on("mousedown", s),
            e(window).off("resize", s).on("resize", s),
            B(a)
        },
        image: function(i) {
            var a = i.data("type") || "images",
            e = {
                images: "uploadImage",
                file: "uploadFile"
            },
            n = H(),
            l = C.base[e[a]] || {};
            layui.upload({
                url: l.url || "",
                method: l.type,
                elem: i.find("input")[0],
                unwrap: !0,
                type: a,
                success: function(i) {
                    0 == i.code ? (i.data = i.data || {},
                    "images" === a ? F(n.textarea[0], "img[" + (i.data.src || "") + "]") : "file" === a && F(n.textarea[0], "file(" + (i.data.src || "") + ")[" + (i.data.name || "下载文件") + "]")) : t.msg(i.msg || "上传失败")
                }
            })
        },
        chatLog: function(i) {
            var a = H();
            return C.base.chatLog ? (t.close(U.chatLog.index), U.chatLog.index = t.open({
                type: 2,
                maxmin: !0,
                title: "与 " + a.data.name + " 的聊天记录",
                area: ["450px", "100%"],
                shade: !1,
                offset: "rb",
                skin: "layui-box",
                shift: 2,
                id: "layui-layim-chatlog",
                content: C.base.chatLog + "?id=" + a.data.id + "&type=" + a.data.type
            })) : t.msg("未开启更多聊天记录")
        },
        menuHistory: function(i, a) {
            var n = layui.data("layim")[C.mine.id] || {},
            l = i.parent(),
            s = i.data("type"),
            o = p.find(".layim-list-history"),
            r = '<li class="layim-null">暂无历史会话</li>';
            if ("one" === s) {
                var d = n.history;
                delete d[l.data("index")],
                n.history = d,
                layui.data("layim", {
                    key: C.mine.id,
                    value: n
                }),
                e("#" + l.data("id")).remove(),
                0 === o.find("li").length && o.html(r)
            } else "all" === s && (delete n.history, layui.data("layim", {
                key: C.mine.id,
                value: n
            }), o.html(r));
            t.closeAll("tips")
        }
    };
    i("layim", new d)
}).addcss("modules/layim/layim.css?v=2.09", "skinlayimcss");