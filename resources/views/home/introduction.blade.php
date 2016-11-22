@extends('home.layouts.app')
@section('HeaderCSSAndJS')
    <meta name="_token" content="{{ csrf_token() }}">

    <link type="text/css" href="/css/optstyle.css" rel="stylesheet"/>
    <link type="text/css" href="/css/style.css" rel="stylesheet"/>

    <script type="text/javascript" src="/basic/js/jquery-1.7.min.js"></script>
    <script type="text/javascript" src="/basic/js/quick_links.js"></script>

    <script type="text/javascript" src="/AmazeUI-2.4.2/assets/js/amazeui.js"></script>
    <script type="text/javascript" src="/js/jquery.imagezoom.min.js"></script>
    <script type="text/javascript" src="/js/jquery.flexslider.js"></script>
    <script type="text/javascript" src="/js/list.js"></script>

    <script src="//cdn.bootcss.com/sweetalert/1.1.3/sweetalert.min.js"></script>
    <link href="//cdn.bootcss.com/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet">
@endsection
@section('title', '商品详情')
@section('FooterCSSAndJS')

    <script>

        $(function() {
            if (!mobilecheck()) {
                $("#LikBasket").bind('click', addCart);
            }
        });

        function addCart() {
            @if(auth()->check())
                var mainForm = $("#main_form");
                var lis = mainForm.find("li");
                var fromData = {};

                var numbers = $("#text_box").val();
                fromData['number'] = numbers;

                var attrIDs = new Array();
                lis.each(function (k, v) {
                    var temp = $(v);
                    if (temp.hasClass("selected")) {
                        attrIDs.push(temp.attr('attrid'));
                    }
                });

                fromData['goods_attr_id'] = attrIDs.sort(function(a,b){return a<b?1:-1}).toString();
                fromData['goods_id'] = {{ $goods->id }};
                fromData['user_id'] = {{ auth()->user()->id }};

            $.ajax({
                type: "post",
                data: fromData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: "{{ url('/cart') }}",
                dataType: 'json',
                success: function (response) {
                    if (response['status']) {
//                        swal("添加成功!", "商品已经加入购物车.", "success");
                        swal({
                            title: "添加成功!",
                            text: "商品已经加入购物车,是否前往购物车?",
                            type: "success",
                            showCancelButton: true,
                            confirmButtonColor: "#3CB371",
                            confirmButtonText: "前往购物车!",
                            cancelButtonText: "取消!",
                            closeOnConfirm: false
                        },
                        function(){
                            window.location.href = "{{  url('/cart')}}";
                        });
                    }else {
                        swal("添加失败!", response['error'], "error");
                    }
                }
            });

            @else()
                window.location.href = "{{  url('login').'?redirectUrl=' . url()->full() }}";
            @endif

        }
    </script>
@endsection

@section('content')


    <div class="clear"></div>
    <div class="clear"></div>
    <b class="line"></b>
    <div class="listMain">

        <!--分类-->
        <div class="nav-table">
            <div class="long-title"><span class="all-goods">全部分类</span></div>
            <div class="nav-cont">
                <ul>
                    <li class="index"><a href="#">首页</a></li>
                    <li class="qc"><a href="#">闪购</a></li>
                    <li class="qc"><a href="#">限时抢</a></li>
                    <li class="qc"><a href="#">团购</a></li>
                    <li class="qc last"><a href="#">大包装</a></li>
                </ul>
            </div>
        </div>
        <ol class="am-breadcrumb am-breadcrumb-slash">
            <li><a href="#">首页</a></li>
            <li><a href="#">分类</a></li>
            <li class="am-active">内容</li>
        </ol>
        <script type="text/javascript">
            $(function () {
            });
            $(window).load(function () {
                $('.flexslider').flexslider({
                    animation: "slide",
                    start: function (slider) {
                        $('body').removeClass('loading');
                    }
                });
            });
        </script>
        <div class="scoll">
            <section class="slider">
                <div class="flexslider">
                    <ul class="slides">
                        <li>
                            {{--<img src="../images/01.jpg" title="pic"/>--}}
                            {{ showImg($goods->logo) }}
                        </li>
                        @foreach($goodsPics as $goodsPic)
                        <li>
                            {{ showImg($goodsPic->pic) }}
                        </li>
                        @endforeach
                        {{--<li>--}}
                            {{--<img src="../images/03.jpg"/>--}}
                        {{--</li>--}}
                    </ul>
                </div>
            </section>
        </div>

        <!--放大镜-->

        <div class="item-inform">
            <div class="clearfixLeft" id="clearcontent">

                <div class="box">
                    <script type="text/javascript">
                        $(document).ready(function () {
                            $(".jqzoom").imagezoom();
                            $("#thumblist li a").click(function () {
                                $(this).parents("li").addClass("tb-selected").siblings().removeClass("tb-selected");
                                $(".jqzoom").attr('src', $(this).find("img").attr("mid"));
                                $(".jqzoom").attr('rel', $(this).find("img").attr("big"));
                            });
                        });
                    </script>

                    <div class="tb-booth tb-pic tb-s310">
                        <a href="{{ '/' . $goods->logo }}">
                            <img src="{{ '/' . $goods->logo }}" alt="细节展示放大镜特效"
                                                        rel="{{ '/' . $goods->logo }}" class="jqzoom"/></a>
                    </div>
                    <ul class="tb-thumb" id="thumblist">
                        <li class="tb-selected">
                            <div class="tb-pic tb-s40">
                                <a href="javascript:void(0)">
                                    {{ showImg($goods->sm_logo, '', '', ['mid' => '/' . $goods->logo, 'big' => '/' . $goods->logo]) }}
                                </a>
                            </div>
                        </li>
                        @foreach($goodsPics as $goodsPic)
                        <li>
                            <div class="tb-pic tb-s40">
                                <a href="javascript:void(0)">
                                    {{ showImg($goodsPic->sm_pic, '', '', ['mid' => '/' . $goodsPic->pic, 'big' => '/' . $goodsPic->pic]) }}
                                </a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="clear"></div>
            </div>

            <div class="clearfixRight">

                <!--规格属性-->
                <!--名称-->
                <div class="tb-detail-hd">
                    <h1>
                        {{ $goods->name }}
                    </h1>
                </div>
                <div class="tb-detail-list">
                    <!--价格-->
                    <div class="tb-detail-price">
                        <li class="price iteminfo_price">
                            <dt>促销价</dt>
                            <dd><em>¥</em><b class="sys_item_price">{{ $goods->shop_price }}</b>
                            </dd>
                        </li>
                        <li class="price iteminfo_mktprice">
                            <dt>原价</dt>
                            <dd><em>¥</em><b
                                        class="sys_item_mktprice">{{ $goods->market_price }}</b>
                            </dd>
                        </li>
                        <div class="clear"></div>
                    </div>

                    <!--地址-->
                    <dl class="iteminfo_parameter freight">
                        <dt>配送至</dt>
                        <div class="iteminfo_freprice">
                            <div class="am-form-content address">
                                <select data-am-selected>
                                    <option value="a">浙江省</option>
                                    <option value="b">湖北省</option>
                                </select>
                                <select data-am-selected>
                                    <option value="a">温州市</option>
                                    <option value="b">武汉市</option>
                                </select>
                                <select data-am-selected>
                                    <option value="a">瑞安区</option>
                                    <option value="b">洪山区</option>
                                </select>
                            </div>
                            <div class="pay-logis">
                                快递<b class="sys_item_freprice">10</b>元
                            </div>
                        </div>
                    </dl>
                    <div class="clear"></div>

                    <!--销量-->
                    <ul class="tm-ind-panel">
                        <li class="tm-ind-item tm-ind-sellCount canClick">
                            <div class="tm-indcon"><span class="tm-label">月销量</span><span
                                        class="tm-count">1015</span></div>
                        </li>
                        <li class="tm-ind-item tm-ind-sumCount canClick">
                            <div class="tm-indcon"><span class="tm-label">累计销量</span><span
                                        class="tm-count">6015</span></div>
                        </li>
                        <li class="tm-ind-item tm-ind-reviewCount canClick tm-line3">
                            <div class="tm-indcon"><span class="tm-label">累计评价</span><span
                                        class="tm-count">640</span></div>
                        </li>
                    </ul>
                    <div class="clear"></div>

                    <!--各种规格-->
                    <dl class="iteminfo_parameter sys_item_specpara">
                        <dt class="theme-login">
                        <div class="cart-title">可选规格<span class="am-icon-angle-right"></span></div>
                        </dt>
                        <dd>
                            <!--操作页面-->

                            <div class="theme-popover-mask"></div>

                            <div class="theme-popover">
                                <div class="theme-span"></div>
                                <div class="theme-poptit">
                                    <a href="javascript:;" title="关闭" class="close">×</a>
                                </div>
                                <div class="theme-popbod dform">
                                    <form id="main_form" class="theme-signin" name="loginform" action="" method="post">

                                        <div class="theme-signin-left">

                                            @foreach($attributes as $name => $attribute)

                                            <div class="theme-options">
                                                <div class="cart-title">{{ $name }}</div>
                                                <ul>
                                                    {{-- */$isFirst=true;/* --}}
                                                    @foreach($attribute->goodsAttribute as $arrtID => $value)
                                                        @if($isFirst)
                                                            <li  class="sku-line selected" attrid="{{ $arrtID }}" >{{ $value }}
                                                                <i></i>
                                                            </li>
                                                            {{-- */$isFirst=false;/* --}}
                                                        @else
                                                            <li style="color: grey;" class="sku-line" attrid="{{ $arrtID }}" >{{ $value }}
                                                                <i></i>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>

                                            @endforeach


                                            <div class="theme-options">
                                            <div class="cart-title number">数量</div>
                                            <dd>
                                                <input id="min" class="am-btn am-btn-default" name="" type="button"
                                                       value="-"/>
                                                <input id="text_box" name="" type="text" value="1" style="width:30px;"/>
                                                <input id="add" class="am-btn am-btn-default" name="" type="button"
                                                       value="+"/>
                                                                        <span id="Stock" class="tb-hidden">库存<span
                                                                                    class="stock">1000</span>件</span>
                                            </dd>

                                        </div>
                <div class="clear"></div>

                <div class="btn-op">
                    <div title="关闭" class="btn am-btn am-btn-warning" onclick="addCart(this)">确认</div>
                    <div class="btn close am-btn am-btn-warning">取消</div>
                </div>
            </div>
            <div class="theme-signin-right">
                <div class="img-info">
                    <img src="../images/songzi.jpg"/>
                </div>
                <div class="text-info">
                    <span id="Stock" class="tb-hidden">库存<span class="stock">1000</span>件</span>
                </div>
            </div>

            </form>

        </div>
    </div>

    </dd>
    </dl>
    <div class="clear"></div>
    <!--活动	-->
    <div class="shopPromotion gold">
        <div class="hot">
            <dt class="tb-metatit">店铺优惠</dt>
            <div class="gold-list">
                <p>购物满2件打8折，满3件7折<span>点击领券<i class="am-icon-sort-down"></i></span></p>
            </div>
        </div>
        <div class="clear"></div>
        <div class="coupon">
            <dt class="tb-metatit">优惠券</dt>
            <div class="gold-list">
                <ul>
                    <li>125减5</li>
                    <li>198减10</li>
                    <li>298减20</li>
                </ul>
            </div>
        </div>
    </div>
    </div>

    <div class="pay">
        <div class="pay-opt">
            <a href="{{ url("/") }}"><span class="am-icon-home am-icon-fw">首页</span></a>
            <a><span class="am-icon-heart am-icon-fw">收藏</span></a>

        </div>
        <li>
            <div class="clearfix tb-btn tb-btn-buy theme-login">
                <a id="LikBuy" title="点此按钮到下一步确认购买信息" href="#">立即购买</a>
            </div>
        </li>
        <li>
            <div class="clearfix tb-btn tb-btn-basket theme-login">
                <a id="LikBasket" title="加入购物车""><i></i>加入购物车</a>
            </div>
        </li>
    </div>

    </div>

    <div class="clear"></div>

    </div>

    <!--优惠套装-->
    <div class="match">
        <div class="match-title">优惠套装</div>
        <div class="match-comment">
            <ul class="like_list">
                <li>
                    <div class="s_picBox">
                        <a class="s_pic" href="#"><img src="../images/cp.jpg"></a>
                    </div>
                    <a class="txt" target="_blank" href="#">萨拉米 1+1小鸡腿</a>

                    <div class="info-box"><span class="info-box-price">¥ 29.90</span> <span
                                class="info-original-price">￥ 199.00</span></div>
                </li>
                <li class="plus_icon"><i>+</i></li>
                <li>
                    <div class="s_picBox">
                        <a class="s_pic" href="#"><img src="../images/cp2.jpg"></a>
                    </div>
                    <a class="txt" target="_blank" href="#">ZEK 原味海苔</a>

                    <div class="info-box"><span class="info-box-price">¥ 8.90</span> <span
                                class="info-original-price">￥ 299.00</span></div>
                </li>
                <li class="plus_icon"><i>=</i></li>
                <li class="total_price">
                    <p class="combo_price"><span class="c-title">套餐价:</span><span>￥35.00</span></p>

                    <p class="save_all">共省:<span>￥463.00</span></p> <a href="#"
                                                                       class="buy_now">立即购买</a></li>
                <li class="plus_icon"><i class="am-icon-angle-right"></i></li>
            </ul>
        </div>
    </div>
    <div class="clear"></div>


    <!-- introduce-->

    <div class="introduce">
        <div class="browse">
            <div class="mc">
                <ul>
                    <div class="mt">
                        <h2>看了又看</h2>
                    </div>

                    <li class="first">
                        <div class="p-img">
                            <a href="#"> <img class="" src="../images/browse1.jpg"> </a>
                        </div>
                        <div class="p-name"><a href="#">
                                【三只松鼠_开口松子】零食坚果特产炒货东北红松子原味
                            </a>
                        </div>
                        <div class="p-price"><strong>￥35.90</strong></div>
                    </li>
                    <li>
                        <div class="p-img">
                            <a href="#"> <img class="" src="../images/browse1.jpg"> </a>
                        </div>
                        <div class="p-name"><a href="#">
                                【三只松鼠_开口松子】零食坚果特产炒货东北红松子原味
                            </a>
                        </div>
                        <div class="p-price"><strong>￥35.90</strong></div>
                    </li>
                    <li>
                        <div class="p-img">
                            <a href="#"> <img class="" src="../images/browse1.jpg"> </a>
                        </div>
                        <div class="p-name"><a href="#">
                                【三只松鼠_开口松子】零食坚果特产炒货东北红松子原味
                            </a>
                        </div>
                        <div class="p-price"><strong>￥35.90</strong></div>
                    </li>
                    <li>
                        <div class="p-img">
                            <a href="#"> <img class="" src="../images/browse1.jpg"> </a>
                        </div>
                        <div class="p-name"><a href="#">
                                【三只松鼠_开口松子】零食坚果特产炒货东北红松子原味
                            </a>
                        </div>
                        <div class="p-price"><strong>￥35.90</strong></div>
                    </li>
                    <li>
                        <div class="p-img">
                            <a href="#"> <img class="" src="../images/browse1.jpg"> </a>
                        </div>
                        <div class="p-name"><a href="#">
                                【三只松鼠_开口松子218g】零食坚果特产炒货东北红松子原味
                            </a>
                        </div>
                        <div class="p-price"><strong>￥35.90</strong></div>
                    </li>

                </ul>
            </div>
        </div>
        <div class="introduceMain">
            <div class="am-tabs" data-am-tabs>
                <ul class="am-avg-sm-3 am-tabs-nav am-nav am-nav-tabs">
                    <li class="am-active">
                        <a href="#">

                            <span class="index-needs-dt-txt">宝贝详情</span></a>

                    </li>

                    <li>
                        <a href="#">

                            <span class="index-needs-dt-txt">全部评价</span></a>

                    </li>

                    <li>
                        <a href="#">

                            <span class="index-needs-dt-txt">猜你喜欢</span></a>
                    </li>
                </ul>

                <div class="am-tabs-bd">

                    <div class="am-tab-panel am-fade am-in am-active">
                        <div class="J_Brand">

                            <div class="attr-list-hd tm-clear">
                                <h4>产品参数：</h4></div>
                            <div class="clear"></div>
                            <ul id="J_AttrUL">
                                @foreach($staticAttributes as $staticAttribute)
                                <li title="">{{$staticAttribute->name}}:&nbsp;{{ $staticAttribute->pivot->attr_value }}</li>
                                @endforeach
                            </ul>
                            <div class="clear"></div>
                        </div>

                        <div class="details">
                            <div class="attr-list-hd after-market-hd">
                                <h4>商品细节</h4>
                            </div>
                            <div class="twlistNews">
                                {!! $goods->goods_desc !!}
                            </div>
                        </div>
                        <div class="clear"></div>

                    </div>

                    <div class="am-tab-panel am-fade">

                        <div class="actor-new">
                            <div class="rate">
                                <strong>100<span>%</span></strong><br> <span>好评度</span>
                            </div>
                            <dl>
                                <dt>买家印象</dt>
                                <dd class="p-bfc">
                                    <q class="comm-tags"><span>味道不错</span><em>(2177)</em></q>
                                    <q class="comm-tags"><span>颗粒饱满</span><em>(1860)</em></q>
                                    <q class="comm-tags"><span>口感好</span><em>(1823)</em></q>
                                    <q class="comm-tags"><span>商品不错</span><em>(1689)</em></q>
                                    <q class="comm-tags"><span>香脆可口</span><em>(1488)</em></q>
                                    <q class="comm-tags"><span>个个开口</span><em>(1392)</em></q>
                                    <q class="comm-tags"><span>价格便宜</span><em>(1119)</em></q>
                                    <q class="comm-tags"><span>特价买的</span><em>(865)</em></q>
                                    <q class="comm-tags"><span>皮很薄</span><em>(831)</em></q>
                                </dd>
                            </dl>
                        </div>
                        <div class="clear"></div>
                        <div class="tb-r-filter-bar">
                            <ul class=" tb-taglist am-avg-sm-4">
                                <li class="tb-taglist-li tb-taglist-li-current">
                                    <div class="comment-info">
                                        <span>全部评价</span>
                                        <span class="tb-tbcr-num">(32)</span>
                                    </div>
                                </li>

                                <li class="tb-taglist-li tb-taglist-li-1">
                                    <div class="comment-info">
                                        <span>好评</span>
                                        <span class="tb-tbcr-num">(32)</span>
                                    </div>
                                </li>

                                <li class="tb-taglist-li tb-taglist-li-0">
                                    <div class="comment-info">
                                        <span>中评</span>
                                        <span class="tb-tbcr-num">(32)</span>
                                    </div>
                                </li>

                                <li class="tb-taglist-li tb-taglist-li--1">
                                    <div class="comment-info">
                                        <span>差评</span>
                                        <span class="tb-tbcr-num">(32)</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="clear"></div>

                        <ul class="am-comments-list am-comments-list-flip">
                            <li class="am-comment">
                                <!-- 评论容器 -->
                                <a href="">
                                    <img class="am-comment-avatar" src="../images/hwbn40x40.jpg"/>
                                    <!-- 评论者头像 -->
                                </a>

                                <div class="am-comment-main">
                                    <!-- 评论内容容器 -->
                                    <header class="am-comment-hd">
                                        <!--<h3 class="am-comment-title">评论标题</h3>-->
                                        <div class="am-comment-meta">
                                            <!-- 评论元数据 -->
                                            <a href="#link-to-user" class="am-comment-author">b***1
                                                (匿名)</a>
                                            <!-- 评论者 -->
                                            评论于
                                            <time datetime="">2015年11月02日 17:46</time>
                                        </div>
                                    </header>

                                    <div class="am-comment-bd">
                                        <div class="tb-rev-item " data-id="255776406962">
                                            <div class="J_TbcRate_ReviewContent tb-tbcr-content ">
                                                摸起来丝滑柔软，不厚，没色差，颜色好看！买这个衣服还接到诈骗电话，我很好奇他们是怎么知道我买了这件衣服，并且还知道我的电话的！
                                            </div>
                                            <div class="tb-r-act-bar">
                                                颜色分类：柠檬黄&nbsp;&nbsp;尺码：S
                                            </div>
                                        </div>

                                    </div>
                                    <!-- 评论内容 -->
                                </div>
                            </li>
                            <li class="am-comment">
                                <!-- 评论容器 -->
                                <a href="">
                                    <img class="am-comment-avatar" src="../images/hwbn40x40.jpg"/>
                                    <!-- 评论者头像 -->
                                </a>

                                <div class="am-comment-main">
                                    <!-- 评论内容容器 -->
                                    <header class="am-comment-hd">
                                        <!--<h3 class="am-comment-title">评论标题</h3>-->
                                        <div class="am-comment-meta">
                                            <!-- 评论元数据 -->
                                            <a href="#link-to-user" class="am-comment-author">l***4
                                                (匿名)</a>
                                            <!-- 评论者 -->
                                            评论于
                                            <time datetime="">2015年10月28日 11:33</time>
                                        </div>
                                    </header>

                                    <div class="am-comment-bd">
                                        <div class="tb-rev-item " data-id="255095758792">
                                            <div class="J_TbcRate_ReviewContent tb-tbcr-content ">
                                                没有色差，很暖和……美美的
                                            </div>
                                            <div class="tb-r-act-bar">
                                                颜色分类：蓝调灰&nbsp;&nbsp;尺码：2XL
                                            </div>
                                        </div>

                                    </div>
                                    <!-- 评论内容 -->
                                </div>
                            </li>
                            <li class="am-comment">
                                <!-- 评论容器 -->
                                <a href="">
                                    <img class="am-comment-avatar" src="../images/hwbn40x40.jpg"/>
                                    <!-- 评论者头像 -->
                                </a>

                                <div class="am-comment-main">
                                    <!-- 评论内容容器 -->
                                    <header class="am-comment-hd">
                                        <!--<h3 class="am-comment-title">评论标题</h3>-->
                                        <div class="am-comment-meta">
                                            <!-- 评论元数据 -->
                                            <a href="#link-to-user" class="am-comment-author">b***1
                                                (匿名)</a>
                                            <!-- 评论者 -->
                                            评论于
                                            <time datetime="">2015年11月02日 17:46</time>
                                        </div>
                                    </header>

                                    <div class="am-comment-bd">
                                        <div class="tb-rev-item " data-id="255776406962">
                                            <div class="J_TbcRate_ReviewContent tb-tbcr-content ">
                                                摸起来丝滑柔软，不厚，没色差，颜色好看！买这个衣服还接到诈骗电话，我很好奇他们是怎么知道我买了这件衣服，并且还知道我的电话的！
                                            </div>
                                            <div class="tb-r-act-bar">
                                                颜色分类：柠檬黄&nbsp;&nbsp;尺码：S
                                            </div>
                                        </div>

                                    </div>
                                    <!-- 评论内容 -->
                                </div>
                            </li>
                            <li class="am-comment">
                                <!-- 评论容器 -->
                                <a href="">
                                    <img class="am-comment-avatar" src="../images/hwbn40x40.jpg"/>
                                    <!-- 评论者头像 -->
                                </a>

                                <div class="am-comment-main">
                                    <!-- 评论内容容器 -->
                                    <header class="am-comment-hd">
                                        <!--<h3 class="am-comment-title">评论标题</h3>-->
                                        <div class="am-comment-meta">
                                            <!-- 评论元数据 -->
                                            <a href="#link-to-user" class="am-comment-author">h***n
                                                (匿名)</a>
                                            <!-- 评论者 -->
                                            评论于
                                            <time datetime="">2015年11月25日 12:48</time>
                                        </div>
                                    </header>

                                    <div class="am-comment-bd">
                                        <div class="tb-rev-item " data-id="258040417670">
                                            <div class="J_TbcRate_ReviewContent tb-tbcr-content ">
                                                式样不错，初冬穿
                                            </div>
                                            <div class="tb-r-act-bar">
                                                颜色分类：柠檬黄&nbsp;&nbsp;尺码：L
                                            </div>
                                        </div>
                                    </div>
                                    <!-- 评论内容 -->
                                </div>
                            </li>

                            <li class="am-comment">
                                <!-- 评论容器 -->
                                <a href="">
                                    <img class="am-comment-avatar" src="../images/hwbn40x40.jpg"/>
                                    <!-- 评论者头像 -->
                                </a>

                                <div class="am-comment-main">
                                    <!-- 评论内容容器 -->
                                    <header class="am-comment-hd">
                                        <!--<h3 class="am-comment-title">评论标题</h3>-->
                                        <div class="am-comment-meta">
                                            <!-- 评论元数据 -->
                                            <a href="#link-to-user" class="am-comment-author">b***1
                                                (匿名)</a>
                                            <!-- 评论者 -->
                                            评论于
                                            <time datetime="">2015年11月02日 17:46</time>
                                        </div>
                                    </header>

                                    <div class="am-comment-bd">
                                        <div class="tb-rev-item " data-id="255776406962">
                                            <div class="J_TbcRate_ReviewContent tb-tbcr-content ">
                                                摸起来丝滑柔软，不厚，没色差，颜色好看！买这个衣服还接到诈骗电话，我很好奇他们是怎么知道我买了这件衣服，并且还知道我的电话的！
                                            </div>
                                            <div class="tb-r-act-bar">
                                                颜色分类：柠檬黄&nbsp;&nbsp;尺码：S
                                            </div>
                                        </div>

                                    </div>
                                    <!-- 评论内容 -->
                                </div>
                            </li>
                            <li class="am-comment">
                                <!-- 评论容器 -->
                                <a href="">
                                    <img class="am-comment-avatar" src="../images/hwbn40x40.jpg"/>
                                    <!-- 评论者头像 -->
                                </a>

                                <div class="am-comment-main">
                                    <!-- 评论内容容器 -->
                                    <header class="am-comment-hd">
                                        <!--<h3 class="am-comment-title">评论标题</h3>-->
                                        <div class="am-comment-meta">
                                            <!-- 评论元数据 -->
                                            <a href="#link-to-user" class="am-comment-author">l***4
                                                (匿名)</a>
                                            <!-- 评论者 -->
                                            评论于
                                            <time datetime="">2015年10月28日 11:33</time>
                                        </div>
                                    </header>

                                    <div class="am-comment-bd">
                                        <div class="tb-rev-item " data-id="255095758792">
                                            <div class="J_TbcRate_ReviewContent tb-tbcr-content ">
                                                没有色差，很暖和……美美的
                                            </div>
                                            <div class="tb-r-act-bar">
                                                颜色分类：蓝调灰&nbsp;&nbsp;尺码：2XL
                                            </div>
                                        </div>

                                    </div>
                                    <!-- 评论内容 -->
                                </div>
                            </li>
                            <li class="am-comment">
                                <!-- 评论容器 -->
                                <a href="">
                                    <img class="am-comment-avatar" src="../images/hwbn40x40.jpg"/>
                                    <!-- 评论者头像 -->
                                </a>

                                <div class="am-comment-main">
                                    <!-- 评论内容容器 -->
                                    <header class="am-comment-hd">
                                        <!--<h3 class="am-comment-title">评论标题</h3>-->
                                        <div class="am-comment-meta">
                                            <!-- 评论元数据 -->
                                            <a href="#link-to-user" class="am-comment-author">b***1
                                                (匿名)</a>
                                            <!-- 评论者 -->
                                            评论于
                                            <time datetime="">2015年11月02日 17:46</time>
                                        </div>
                                    </header>

                                    <div class="am-comment-bd">
                                        <div class="tb-rev-item " data-id="255776406962">
                                            <div class="J_TbcRate_ReviewContent tb-tbcr-content ">
                                                摸起来丝滑柔软，不厚，没色差，颜色好看！买这个衣服还接到诈骗电话，我很好奇他们是怎么知道我买了这件衣服，并且还知道我的电话的！
                                            </div>
                                            <div class="tb-r-act-bar">
                                                颜色分类：柠檬黄&nbsp;&nbsp;尺码：S
                                            </div>
                                        </div>

                                    </div>
                                    <!-- 评论内容 -->
                                </div>
                            </li>
                            <li class="am-comment">
                                <!-- 评论容器 -->
                                <a href="">
                                    <img class="am-comment-avatar" src="../images/hwbn40x40.jpg"/>
                                    <!-- 评论者头像 -->
                                </a>

                                <div class="am-comment-main">
                                    <!-- 评论内容容器 -->
                                    <header class="am-comment-hd">
                                        <!--<h3 class="am-comment-title">评论标题</h3>-->
                                        <div class="am-comment-meta">
                                            <!-- 评论元数据 -->
                                            <a href="#link-to-user" class="am-comment-author">h***n
                                                (匿名)</a>
                                            <!-- 评论者 -->
                                            评论于
                                            <time datetime="">2015年11月25日 12:48</time>
                                        </div>
                                    </header>

                                    <div class="am-comment-bd">
                                        <div class="tb-rev-item " data-id="258040417670">
                                            <div class="J_TbcRate_ReviewContent tb-tbcr-content ">
                                                式样不错，初冬穿
                                            </div>
                                            <div class="tb-r-act-bar">
                                                颜色分类：柠檬黄&nbsp;&nbsp;尺码：L
                                            </div>
                                        </div>
                                    </div>
                                    <!-- 评论内容 -->
                                </div>
                            </li>
                            <li class="am-comment">
                                <!-- 评论容器 -->
                                <a href="">
                                    <img class="am-comment-avatar" src="../images/hwbn40x40.jpg"/>
                                    <!-- 评论者头像 -->
                                </a>

                                <div class="am-comment-main">
                                    <!-- 评论内容容器 -->
                                    <header class="am-comment-hd">
                                        <!--<h3 class="am-comment-title">评论标题</h3>-->
                                        <div class="am-comment-meta">
                                            <!-- 评论元数据 -->
                                            <a href="#link-to-user" class="am-comment-author">b***1
                                                (匿名)</a>
                                            <!-- 评论者 -->
                                            评论于
                                            <time datetime="">2015年11月02日 17:46</time>
                                        </div>
                                    </header>

                                    <div class="am-comment-bd">
                                        <div class="tb-rev-item " data-id="255776406962">
                                            <div class="J_TbcRate_ReviewContent tb-tbcr-content ">
                                                摸起来丝滑柔软，不厚，没色差，颜色好看！买这个衣服还接到诈骗电话，我很好奇他们是怎么知道我买了这件衣服，并且还知道我的电话的！
                                            </div>
                                            <div class="tb-r-act-bar">
                                                颜色分类：柠檬黄&nbsp;&nbsp;尺码：S
                                            </div>
                                        </div>

                                    </div>
                                    <!-- 评论内容 -->
                                </div>
                            </li>
                            <li class="am-comment">
                                <!-- 评论容器 -->
                                <a href="">
                                    <img class="am-comment-avatar" src="../images/hwbn40x40.jpg"/>
                                    <!-- 评论者头像 -->
                                </a>

                                <div class="am-comment-main">
                                    <!-- 评论内容容器 -->
                                    <header class="am-comment-hd">
                                        <!--<h3 class="am-comment-title">评论标题</h3>-->
                                        <div class="am-comment-meta">
                                            <!-- 评论元数据 -->
                                            <a href="#link-to-user" class="am-comment-author">l***4
                                                (匿名)</a>
                                            <!-- 评论者 -->
                                            评论于
                                            <time datetime="">2015年10月28日 11:33</time>
                                        </div>
                                    </header>

                                    <div class="am-comment-bd">
                                        <div class="tb-rev-item " data-id="255095758792">
                                            <div class="J_TbcRate_ReviewContent tb-tbcr-content ">
                                                没有色差，很暖和……美美的
                                            </div>
                                            <div class="tb-r-act-bar">
                                                颜色分类：蓝调灰&nbsp;&nbsp;尺码：2XL
                                            </div>
                                        </div>

                                    </div>
                                    <!-- 评论内容 -->
                                </div>
                            </li>
                            <li class="am-comment">
                                <!-- 评论容器 -->
                                <a href="">
                                    <img class="am-comment-avatar" src="../images/hwbn40x40.jpg"/>
                                    <!-- 评论者头像 -->
                                </a>

                                <div class="am-comment-main">
                                    <!-- 评论内容容器 -->
                                    <header class="am-comment-hd">
                                        <!--<h3 class="am-comment-title">评论标题</h3>-->
                                        <div class="am-comment-meta">
                                            <!-- 评论元数据 -->
                                            <a href="#link-to-user" class="am-comment-author">b***1
                                                (匿名)</a>
                                            <!-- 评论者 -->
                                            评论于
                                            <time datetime="">2015年11月02日 17:46</time>
                                        </div>
                                    </header>

                                    <div class="am-comment-bd">
                                        <div class="tb-rev-item " data-id="255776406962">
                                            <div class="J_TbcRate_ReviewContent tb-tbcr-content ">
                                                摸起来丝滑柔软，不厚，没色差，颜色好看！买这个衣服还接到诈骗电话，我很好奇他们是怎么知道我买了这件衣服，并且还知道我的电话的！
                                            </div>
                                            <div class="tb-r-act-bar">
                                                颜色分类：柠檬黄&nbsp;&nbsp;尺码：S
                                            </div>
                                        </div>

                                    </div>
                                    <!-- 评论内容 -->
                                </div>
                            </li>
                            <li class="am-comment">
                                <!-- 评论容器 -->
                                <a href="">
                                    <img class="am-comment-avatar" src="../images/hwbn40x40.jpg"/>
                                    <!-- 评论者头像 -->
                                </a>

                                <div class="am-comment-main">
                                    <!-- 评论内容容器 -->
                                    <header class="am-comment-hd">
                                        <!--<h3 class="am-comment-title">评论标题</h3>-->
                                        <div class="am-comment-meta">
                                            <!-- 评论元数据 -->
                                            <a href="#link-to-user" class="am-comment-author">h***n
                                                (匿名)</a>
                                            <!-- 评论者 -->
                                            评论于
                                            <time datetime="">2015年11月25日 12:48</time>
                                        </div>
                                    </header>

                                    <div class="am-comment-bd">
                                        <div class="tb-rev-item " data-id="258040417670">
                                            <div class="J_TbcRate_ReviewContent tb-tbcr-content ">
                                                式样不错，初冬穿
                                            </div>
                                            <div class="tb-r-act-bar">
                                                颜色分类：柠檬黄&nbsp;&nbsp;尺码：L
                                            </div>
                                        </div>
                                    </div>
                                    <!-- 评论内容 -->
                                </div>
                            </li>

                        </ul>

                        <div class="clear"></div>

                        <!--分页 -->
                        <ul class="am-pagination am-pagination-right">
                            <li class="am-disabled"><a href="#">&laquo;</a></li>
                            <li class="am-active"><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li><a href="#">&raquo;</a></li>
                        </ul>
                        <div class="clear"></div>

                        <div class="tb-reviewsft">
                            <div class="tb-rate-alert type-attention">购买前请查看该商品的 <a href="#"
                                                                                    target="_blank">购物保障</a>，明确您的售后保障权益。
                            </div>
                        </div>

                    </div>

                    <div class="am-tab-panel am-fade">
                        <div class="like">
                            <ul class="am-avg-sm-2 am-avg-md-3 am-avg-lg-4 boxes">
                                <li>
                                    <div class="i-pic limit">
                                        <img src="../images/imgsearch1.jpg"/>

                                        <p>【良品铺子_开口松子】零食坚果特产炒货
                                            <span>东北红松子奶油味</span></p>

                                        <p class="price fl">
                                            <b>¥</b>
                                            <strong>298.00</strong>
                                        </p>
                                    </div>
                                </li>
                                <li>
                                    <div class="i-pic limit">
                                        <img src="../images/imgsearch1.jpg"/>

                                        <p>【良品铺子_开口松子】零食坚果特产炒货
                                            <span>东北红松子奶油味</span></p>

                                        <p class="price fl">
                                            <b>¥</b>
                                            <strong>298.00</strong>
                                        </p>
                                    </div>
                                </li>
                                <li>
                                    <div class="i-pic limit">
                                        <img src="../images/imgsearch1.jpg"/>

                                        <p>【良品铺子_开口松子】零食坚果特产炒货
                                            <span>东北红松子奶油味</span></p>

                                        <p class="price fl">
                                            <b>¥</b>
                                            <strong>298.00</strong>
                                        </p>
                                    </div>
                                </li>
                                <li>
                                    <div class="i-pic limit">
                                        <img src="../images/imgsearch1.jpg"/>

                                        <p>【良品铺子_开口松子】零食坚果特产炒货
                                            <span>东北红松子奶油味</span></p>

                                        <p class="price fl">
                                            <b>¥</b>
                                            <strong>298.00</strong>
                                        </p>
                                    </div>
                                </li>
                                <li>
                                    <div class="i-pic limit">
                                        <img src="../images/imgsearch1.jpg"/>

                                        <p>【良品铺子_开口松子】零食坚果特产炒货
                                            <span>东北红松子奶油味</span></p>

                                        <p class="price fl">
                                            <b>¥</b>
                                            <strong>298.00</strong>
                                        </p>
                                    </div>
                                </li>
                                <li>
                                    <div class="i-pic limit">
                                        <img src="../images/imgsearch1.jpg"/>

                                        <p>【良品铺子_开口松子】零食坚果特产炒货
                                            <span>东北红松子奶油味</span></p>

                                        <p class="price fl">
                                            <b>¥</b>
                                            <strong>298.00</strong>
                                        </p>
                                    </div>
                                </li>
                                <li>
                                    <div class="i-pic limit">
                                        <img src="../images/imgsearch1.jpg"/>

                                        <p>【良品铺子_开口松子】零食坚果特产炒货
                                            <span>东北红松子奶油味</span></p>

                                        <p class="price fl">
                                            <b>¥</b>
                                            <strong>298.00</strong>
                                        </p>
                                    </div>
                                </li>
                                <li>
                                    <div class="i-pic limit">
                                        <img src="../images/imgsearch1.jpg"/>

                                        <p>【良品铺子_开口松子】零食坚果特产炒货
                                            <span>东北红松子奶油味</span></p>

                                        <p class="price fl">
                                            <b>¥</b>
                                            <strong>298.00</strong>
                                        </p>
                                    </div>
                                </li>
                                <li>
                                    <div class="i-pic limit">
                                        <img src="../images/imgsearch1.jpg"/>

                                        <p>【良品铺子_开口松子】零食坚果特产炒货
                                            <span>东北红松子奶油味</span></p>

                                        <p class="price fl">
                                            <b>¥</b>
                                            <strong>298.00</strong>
                                        </p>
                                    </div>
                                </li>
                                <li>
                                    <div class="i-pic limit">
                                        <img src="../images/imgsearch1.jpg"/>

                                        <p>【良品铺子_开口松子】零食坚果特产炒货
                                            <span>东北红松子奶油味</span></p>

                                        <p class="price fl">
                                            <b>¥</b>
                                            <strong>298.00</strong>
                                        </p>
                                    </div>
                                </li>
                                <li>
                                    <div class="i-pic limit">
                                        <img src="../images/imgsearch1.jpg"/>

                                        <p>【良品铺子_开口松子】零食坚果特产炒货
                                            <span>东北红松子奶油味</span></p>

                                        <p class="price fl">
                                            <b>¥</b>
                                            <strong>298.00</strong>
                                        </p>
                                    </div>
                                </li>
                                <li>
                                    <div class="i-pic limit">
                                        <img src="../images/imgsearch1.jpg"/>

                                        <p>【良品铺子_开口松子】零食坚果特产炒货
                                            <span>东北红松子奶油味</span></p>

                                        <p class="price fl">
                                            <b>¥</b>
                                            <strong>298.00</strong>
                                        </p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="clear"></div>

                        <!--分页 -->
                        <ul class="am-pagination am-pagination-right">
                            <li class="am-disabled"><a href="#">&laquo;</a></li>
                            <li class="am-active"><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li><a href="#">&raquo;</a></li>
                        </ul>
                        <div class="clear"></div>

                    </div>

                </div>

            </div>

            <div class="clear"></div>

            @include('home.layouts.footer')
        </div>

    </div>
    </div>
    <!--菜单 -->

@endsection
