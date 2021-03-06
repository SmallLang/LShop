<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title')</title>
    <link href="/AmazeUI-2.4.2/assets/css/amazeui.css" rel="stylesheet" type="text/css" />
    <link href="/AmazeUI-2.4.2/assets/css/admin.css" rel="stylesheet" type="text/css" />
    <link href="/basic/css/demo.css" rel="stylesheet" type="text/css" />

    <link href="/css/hmstyle.css" rel="stylesheet" type="text/css" />
    <script src="/AmazeUI-2.4.2/assets/js/jquery.min.js"></script>
    <script src="/AmazeUI-2.4.2/assets/js/amazeui.min.js"></script>

    @yield('HeaderCSSAndJS')
</head>

<body>
    <div class="hmtop">
        <!--顶部导航条 -->
        <div class="am-container header">
            <ul class="message-l">
                <div class="topMessage">
                    <div class="menu-hd">
                        @if(auth()->check())
                            <a style="color: #f22e00;" href="{{ url('login') }}" target="_top" class="h">您好! {{ auth()->user()->name }}</a>
                            <a href="{{ url('/logout') }}" target="_top">退出</a>
                        @else
                            <a style="color: #f22e00;" href="{{ url('login') }}" target="_top" class="h">亲，请登录</a>
                            <a href="{{ url('/register') }}" target="_top">免费注册</a>
                        @endif
                    </div>
                </div>
            </ul>
            <ul class="message-r">
                <div class="topMessage home">
                    <div class="menu-hd"><a href="{{ url('/') }}" target="_top" class="h">商城首页</a></div>
                </div>
                <div class="topMessage my-shangcheng">
                    <div class="menu-hd MyShangcheng"><a href="#" target="_top"><i class="am-icon-user am-icon-fw"></i>个人中心</a></div>
                </div>
                <div class="topMessage mini-cart">
                    <div class="menu-hd">
                        <a id="mc-menu-hd" href="{{ url('/cart') }}" target="_top">
                        <i class="am-icon-shopping-cart  am-icon-fw"></i>
                        <span>购物车</span><strong id="J_MiniCartNum" class="h" style="color: #DC143C;"></strong></a>
                    </div>
                </div>
                <div class="topMessage favorite">
                    <div class="menu-hd"><a href="#" target="_top"><i class="am-icon-heart am-icon-fw"></i><span>收藏夹</span></a></div>
            </ul>
        </div>
        <!--悬浮搜索框-->
        <div class="nav white">
            <div class="logo"><img src="/images/logo.png" /></div>
            <div class="logoBig">
                <li><img src="/images/logobig.png" /></li>
            </div>

            <div class="search-bar pr">
                <a name="index_none_header_sysc" href="#"></a>
                <form>
                    <input id="searchInput" name="index_none_header_sysc" type="text" placeholder="搜索" autocomplete="off">
                    <input id="ai-topsearch" class="submit am-btn" value="搜索" index="1" type="submit">
                </form>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    @yield('content')
    <div class=tip>
        <div id="sidebar">
            <div id="wrap">
                <div id="prof" class="item ">
                    <a href="# ">
                        <span class="setting "></span>
                    </a>
                    <div class="ibar_login_box status_login ">
                        <div class="avatar_box ">
                            <p class="avatar_imgbox "><img src="/images/no-img_mid_.jpg " /></p>
                            <ul class="user_info ">
                                <li>用户名：sl1903</li>
                                <li>级&nbsp;别：普通会员</li>
                            </ul>
                        </div>
                        <div class="login_btnbox ">
                            <a href="# " class="login_order ">我的订单</a>
                            <a href="# " class="login_favorite ">我的收藏</a>
                        </div>
                        <i class="icon_arrow_white "></i>
                    </div>

                </div>
                <div id="shopCart " class="item ">
                    <a href="# ">
                        <span class="message "></span>
                    </a>
                    <p>
                        购物车
                    </p>
                    <p class="cart_num ">0</p>
                </div>
                <div id="asset " class="item ">
                    <a href="# ">
                        <span class="view "></span>
                    </a>
                    <div class="mp_tooltip ">
                        我的资产
                        <i class="icon_arrow_right_black "></i>
                    </div>
                </div>

                <div id="foot " class="item ">
                    <a href="# ">
                        <span class="zuji "></span>
                    </a>
                    <div class="mp_tooltip ">
                        我的足迹
                        <i class="icon_arrow_right_black "></i>
                    </div>
                </div>

                <div id="brand " class="item ">
                    <a href="#">
                        <span class="wdsc "><img src="/images/wdsc.png " /></span>
                    </a>
                    <div class="mp_tooltip ">
                        我的收藏
                        <i class="icon_arrow_right_black "></i>
                    </div>
                </div>

                <div id="broadcast " class="item ">
                    <a href="# ">
                        <span class="chongzhi "><img src="/images/chongzhi.png " /></span>
                    </a>
                    <div class="mp_tooltip ">
                        我要充值
                        <i class="icon_arrow_right_black "></i>
                    </div>
                </div>

                <div class="quick_toggle ">
                    <li class="qtitem ">
                        <a href="# "><span class="kfzx "></span></a>
                        <div class="mp_tooltip ">客服中心<i class="icon_arrow_right_black "></i></div>
                    </li>
                    <!--二维码 -->
                    <li class="qtitem ">
                        <a href="#none "><span class="mpbtn_qrcode "></span></a>
                        <div class="mp_qrcode " style="display:none; "><img src="/images/weixin_code_145.png " /><i class="icon_arrow_white "></i></div>
                    </li>
                    <li class="qtitem ">
                        <a href="#top " class="return_top "><span class="top "></span></a>
                    </li>
                </div>

                <!--回到顶部 -->
                <div id="quick_links_pop " class="quick_links_pop hide "></div>

            </div>

        </div>
        <div id="prof-content " class="nav-content ">
            <div class="nav-con-close ">
                <i class="am-icon-angle-right am-icon-fw "></i>
            </div>
            <div>
                我
            </div>
        </div>
        <div id="shopCart-content " class="nav-content ">
            <div class="nav-con-close ">
                <i class="am-icon-angle-right am-icon-fw "></i>
            </div>
            <div>
                购物车
            </div>
        </div>
        <div id="asset-content " class="nav-content ">
            <div class="nav-con-close ">
                <i class="am-icon-angle-right am-icon-fw "></i>
            </div>
            <div>
                资产
            </div>

            <div class="ia-head-list ">
                <a href="# " target="_blank " class="pl ">
                    <div class="num ">0</div>
                    <div class="text ">优惠券</div>
                </a>
                <a href="# " target="_blank " class="pl ">
                    <div class="num ">0</div>
                    <div class="text ">红包</div>
                </a>
                <a href="# " target="_blank " class="pl money ">
                    <div class="num ">￥0</div>
                    <div class="text ">余额</div>
                </a>
            </div>

        </div>
        <div id="foot-content " class="nav-content ">
            <div class="nav-con-close ">
                <i class="am-icon-angle-right am-icon-fw "></i>
            </div>
            <div>
                足迹
            </div>
        </div>
        <div id="brand-content " class="nav-content ">
            <div class="nav-con-close ">
                <i class="am-icon-angle-right am-icon-fw "></i>
            </div>
            <div>
                收藏
            </div>
        </div>
        <div id="broadcast-content " class="nav-content ">
            <div class="nav-con-close ">
                <i class="am-icon-angle-right am-icon-fw "></i>
            </div>
            <div>
                充值
            </div>
        </div>
    </div>

<!--菜单 -->
@yield('FooterCSSAndJS')
    <script>
      @if(auth()->check())
          {{--$(function() {--}}
                {{--$.ajax({--}}
                    {{--type: "get",--}}
                    {{--headers: {--}}
                        {{--'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')--}}
                    {{--},--}}
                    {{--url: "{{ url('/cart/ajaxGetGoodsCount') }}",--}}
                    {{--dataType: 'json',--}}
                    {{--success: function (response) {--}}
                        {{--if (response['status']) {--}}
                            {{--$("#J_MiniCartNum").text(response['content']);--}}
                        {{--}--}}
                    {{--}--}}
                {{--})--}}
            {{--});--}}
        @endif
    </script>
</body>

</html>
