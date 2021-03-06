/*
 @功能：购物车页面js
 @作者：diamondwang
 @时间：2013年11月14日
 */


$(function(){
    //减少
    $(".reduce_num").click(function(){
        var li = $(this).closest('li');
        var amount = li.find('#amount');
        if (parseInt($(amount).val()) <= 1){
            alert("商品数量最少为1");
        } else{
            $(amount).val(parseInt($(amount).val()) - 1);
            var ul = $(li).parent();
            var cartId = ul.attr('cart_id');
            ajaxUpDateCartData(cartId, $(amount).val());
        }
        //小计
        var subtotal = parseFloat($(li).prev().find(".price-now").text()) * parseInt($(amount).val());
        $(li).next('.td-sum').find('em').text(subtotal.toFixed(2));
        //总计金额
        var total = 0;
        $(".td-sum").find('em').each(function(){
            total += parseFloat($(this).text());
        });

        $("#J_Total").text(total.toFixed(2));
        $("#J_ActualFee").text(total.toFixed(2));
    });

    //增加
    $(".add_num").click(function(){

        var li = $(this).closest('li');
        var amount = li.find('#amount');
        $(amount).val(parseInt($(amount).val()) + 1);

        var ul = $(li).parent();
        var cartId = ul.attr('cart_id');
        ajaxUpDateCartData(cartId, $(amount).val());

        //小计
        var subtotal = parseFloat($(li).prev().find(".price-now").text()) * parseInt($(amount).val());
        $(li).next('.td-sum').find('em').text(subtotal.toFixed(2));
        //总计金额
        var total = 0;
        $(".td-sum").find('em').each(function(){
            total += parseFloat($(this).text());
        });

        $("#J_Total").text(total.toFixed(2));
        $("#J_ActualFee").text(total.toFixed(2));

    });

    //直接输入
    $(".amount").blur(function(){
        if (parseInt($(this).val()) < 1){
            alert("商品数量最少为1");
            $(this).val(1);
        }
        //小计
        var subtotal = parseFloat($(this).parent().parent().find(".col3 span").text()) * parseInt($(this).val());
        $(this).parent().parent().find(".col5 span").text(subtotal.toFixed(2));
        //总计金额
        var total = 0;
        $(".col5 span").each(function(){
            total += parseFloat($(this).text());
        });

        $("#total").text(total.toFixed(2));

    });

    $(".check-all").click(function() {
        if($(".check-all").attr("checked")){
            $(".check").attr("checked", 'checked');
        }else{
            $(".check").removeAttr("checked");
        }
    });
    $(".check").click(function() {
        $(".check-all").removeAttr("checked");
    });

});