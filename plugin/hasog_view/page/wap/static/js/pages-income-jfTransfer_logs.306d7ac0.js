(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-income-jfTransfer_logs"],{5668:function(t,e,i){"use strict";var a=i("8dcf"),n=i.n(a);n.a},"65a8":function(t,e,i){"use strict";var a=i("4ea4");i("99af"),i("4160"),i("c975"),i("159b"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0,i("96cf");var n=a(i("1da1")),o=a(i("2e09")),r={components:{uniLoadMore:o.default},data:function(){return{cloneHeight:0,isNo:!1,scrollTop:0,logs:[],page:0,tabCurrentIndex:0,navList:[{state:0,text:"转入",loadingType:"more",orderList:[]},{state:1,text:"转出",loadingType:"more",orderList:[]}],refresh:!1}},onReady:function(){this.cloneHeight=document.documentElement.clientHeight||document.body.clientHeight},onLoad:function(){this.page=0,this.getData(this.tabCurrentIndex)},onShow:function(){uni.getStorage({key:"version",success:function(t){document.title="".concat(document.title," - ").concat(JSON.parse(t.data).site.name)}})},watch:{refresh:function(t){t&&(this.refresh=!1,this.page=0,this.getData(this.tabCurrentIndex))}},methods:{getData:function(t,e){var i=this;return(0,n.default)(regeneratorRuntime.mark((function a(){var n,o,r,d;return regeneratorRuntime.wrap((function(a){while(1)switch(a.prev=a.next){case 0:if(n=i.tabCurrentIndex,o=i.navList[n],o.state,"tabChange"!==e||!0!==o.loaded){a.next=5;break}return a.abrupt("return");case 5:if("loading"!==o.loadingType){a.next=7;break}return a.abrupt("return");case 7:if("noMore"!==o.loadingType){a.next=9;break}return a.abrupt("return");case 9:if(i.oldId!=t&&(i.page=0),o.loadingType="loading",0!=t){a.next=17;break}return a.next=14,i.$request.get("/api/transfer_credit/be_transfer_list",{page:i.page});case 14:r=a.sent,a.next=20;break;case 17:return a.next=19,i.$request.get("/api/transfer_credit/transfer_list",{page:i.page});case 19:r=a.sent;case 20:if(!r.url||-1==r.url.indexOf("login")){a.next=23;break}return uni.showModal({title:"温馨提示",content:r.msg,success:function(t){t.confirm?i.$Router.push({name:"Login"}):i.$Router.back(1)}}),a.abrupt("return");case 23:1==r.code?(i.oldId=t,d=r.data.order_list,i.page+=1,0==r.data.order_list.length?o.loadingType="noMore":o.loadingType="more"):i.$api.modal(r.msg),setTimeout((function(){1==i.page&&(o.orderList=[]),d.forEach((function(t){o.orderList.push(t)})),i.$set(o,"loaded",!0)}),600);case 25:case"end":return a.stop()}}),a)})))()},changeTab:function(t){this.tabCurrentIndex=t.target.current,this.getData(this.tabCurrentIndex,"tabChange")},tabClick:function(t){this.tabCurrentIndex=t,this.getData(this.tabCurrentIndex)},channel:function(t){switch(t){case 0:return"微信";case 1:return"支付宝";case 2:return"余额";case 3:return"手动"}},orderStateExp:function(t){var e="",i="#fa436a";switch(t){case 0:e="待审核";break;case 1:e="待打款";break;case 2:e="打款中";break;case 3:e="已打款",i="#4cd964";break;case 5:e="无效提现",i="#909399";break;case 4:e="已驳回",i="#dd524d";break}return{stateTip:e,stateTipColor:i}}},updated:function(){}};e.default=r},"6c6b":function(t,e,i){"use strict";i.r(e);var a=i("65a8"),n=i.n(a);for(var o in a)"default"!==o&&function(t){i.d(e,t,(function(){return a[t]}))}(o);e["default"]=n.a},"8dcf":function(t,e,i){var a=i("efcf");"string"===typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);var n=i("4f06").default;n("0439a25c",a,!0,{sourceMap:!1,shadowMode:!1})},c192:function(t,e,i){"use strict";i.r(e);var a=i("c95a"),n=i("6c6b");for(var o in n)"default"!==o&&function(t){i.d(e,t,(function(){return n[t]}))}(o);i("5668");var r,d=i("f0c5"),s=Object(d["a"])(n["default"],a["b"],a["c"],!1,null,"c7b53526",null,!1,a["a"],r);e["default"]=s.exports},c95a:function(t,e,i){"use strict";i.d(e,"b",(function(){return n})),i.d(e,"c",(function(){return o})),i.d(e,"a",(function(){return a}));var a={uniLoadMore:i("2e09").default},n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",{staticClass:"content"},[i("nav-bar",[t._v("积分转账记录")]),i("v-uni-view",{staticClass:"navbar"},t._l(t.navList,(function(e,a){return i("v-uni-view",{key:a,staticClass:"nav-item",class:{current:t.tabCurrentIndex===a},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.tabClick(a)}}},[t._v(t._s(e.text))])})),1),i("v-uni-swiper",{staticClass:"swiper-box",style:{height:t.cloneHeight-90+"px"},attrs:{current:t.tabCurrentIndex,duration:"300"},on:{change:function(e){arguments[0]=e=t.$handleEvent(e),t.changeTab.apply(void 0,arguments)}}},t._l(t.navList,(function(e,a){return i("v-uni-swiper-item",{key:a,staticClass:"tab-content"},[i("v-uni-scroll-view",{staticClass:"list-scroll-content",attrs:{"scroll-y":!0},on:{scrolltolower:function(e){arguments[0]=e=t.$handleEvent(e),t.getData(a)}}},[!0===e.loaded&&0===e.orderList.length?i("empty"):t._e(),t._l(e.orderList,(function(e,a){return i("v-uni-view",{key:a,staticClass:"items"},[i("v-uni-view",{staticClass:"top"},[i("v-uni-text",[t._v(t._s(0==t.tabCurrentIndex?"转入":"目标")+"用户id: "+t._s(0==t.tabCurrentIndex?e.uid:e.target_uid))]),i("v-uni-text",{staticClass:"state"},[t._v("转账类型: "+t._s(e.credit_type))])],1),i("v-uni-view",{staticClass:"bottom"},[i("v-uni-view",[t._v(t._s(0==t.tabCurrentIndex?"转入":"目标")+"用户: "+t._s(e.target_mobile))]),i("v-uni-view",[t._v("积分数额:"),i("v-uni-text",{staticClass:"price"},[i("v-uni-text",{staticClass:"price-icon"},[t._v("￥")]),t._v(t._s(e.amount))],1)],1),i("v-uni-view",{staticClass:"time"},[t._v("时间: "+t._s(e.create_time))])],1)],1)})),i("uni-load-more",{attrs:{status:e.loadingType}})],2)],1)})),1)],1)},o=[]},efcf:function(t,e,i){var a=i("24fb");e=a(!1),e.push([t.i,'@charset "UTF-8";\n/* 页面左右间距 */\n/* 文字尺寸 */\n/*文字颜色*/\n/* 边框颜色 */\n/* 图片加载中颜色 */\n/* 行为相关颜色 */.navbar[data-v-c7b53526]{display:-webkit-box;display:-webkit-flex;display:flex;height:40px;padding:0 5px;background:#fff;-webkit-box-shadow:0 1px 5px rgba(0,0,0,.06);box-shadow:0 1px 5px rgba(0,0,0,.06);position:relative;z-index:10}.navbar .nav-item[data-v-c7b53526]{-webkit-box-flex:1;-webkit-flex:1;flex:1;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;align-items:center;height:100%;font-size:15px;color:#303133;position:relative}.navbar .nav-item.current[data-v-c7b53526]{color:#fa436a}.navbar .nav-item.current[data-v-c7b53526]:after{content:"";position:absolute;left:50%;bottom:0;-webkit-transform:translateX(-50%);transform:translateX(-50%);width:44px;height:0;border-bottom:2px solid #fa436a}.order-item[data-v-c7b53526]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;padding-left:%?30?%;background:#fff;margin-top:%?16?%\n  /* 多条商品 */\n  /* 单条商品 */}.order-item .i-top[data-v-c7b53526]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;height:%?80?%;padding-right:%?30?%;font-size:%?28?%;color:#303133;position:relative}.order-item .i-top .time[data-v-c7b53526]{-webkit-box-flex:1;-webkit-flex:1;flex:1}.order-item .i-top .state[data-v-c7b53526]{color:#fa436a}.order-item .i-top .del-btn[data-v-c7b53526]{padding:%?10?% 0 %?10?% %?36?%;font-size:%?32?%;color:#909399;position:relative}.order-item .i-top .del-btn[data-v-c7b53526]:after{content:"";width:0;height:%?30?%;border-left:1px solid #dcdfe6;position:absolute;left:%?20?%;top:50%;-webkit-transform:translateY(-50%);transform:translateY(-50%)}.order-item .goods-box[data-v-c7b53526]{height:%?160?%;padding:%?20?% 0;white-space:nowrap}.order-item .goods-box .goods-item[data-v-c7b53526]{width:%?120?%;height:%?120?%;display:inline-block;margin-right:%?24?%}.order-item .goods-box .goods-img[data-v-c7b53526]{display:block;width:100%;height:100%}.order-item .goods-box-single[data-v-c7b53526]{display:-webkit-box;display:-webkit-flex;display:flex;padding:%?20?% 0}.order-item .goods-box-single .goods-img[data-v-c7b53526]{display:block;width:%?160?%;height:%?160?%}.order-item .goods-box-single .right[data-v-c7b53526]{-webkit-box-flex:1;-webkit-flex:1;flex:1;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between;padding:0 %?30?% 0 %?24?%;overflow:hidden}.order-item .goods-box-single .right .middle[data-v-c7b53526]{margin-right:%?10?%}.order-item .goods-box-single .right .middle .title[data-v-c7b53526]{font-size:%?30?%;color:#303133;line-height:%?40?%;white-space:pre-wrap;word-break:break-all;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;overflow:hidden}.order-item .goods-box-single .right .middle .spec[data-v-c7b53526]{padding:%?10?% 0;font-size:%?26?%;color:#909399}.order-item .goods-box-single .right .middle .spec uni-text[data-v-c7b53526]{margin-right:%?10?%}.order-item .goods-box-single .right .rRight[data-v-c7b53526]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;-webkit-box-align:end;-webkit-align-items:flex-end;align-items:flex-end}.order-item .goods-box-single .right .rRight .attr-box[data-v-c7b53526]{text-align:right;font-size:%?26?%;color:#909399;padding:%?10?% 0}.order-item .goods-box-single .right .rRight .price[data-v-c7b53526]{text-align:right;font-size:%?30?%;color:#303133}.order-item .goods-box-single .right .rRight .price[data-v-c7b53526]:before{content:"￥";font-size:%?24?%;margin:0 %?2?% 0 %?8?%}.order-item .price-box[data-v-c7b53526]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:end;-webkit-justify-content:flex-end;justify-content:flex-end;-webkit-box-align:baseline;-webkit-align-items:baseline;align-items:baseline;padding:%?20?% %?30?%;font-size:%?26?%;color:#909399}.order-item .price-box .num[data-v-c7b53526]{margin:0 %?8?%;color:#303133}.order-item .price-box .price[data-v-c7b53526]{font-size:%?32?%;color:#fa436a}.order-item .price-box .price[data-v-c7b53526]:before{content:"￥";font-size:%?24?%;margin:0 %?2?% 0 %?8?%}.order-item .action-box[data-v-c7b53526]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:end;-webkit-justify-content:flex-end;justify-content:flex-end;-webkit-box-align:center;-webkit-align-items:center;align-items:center;position:relative;padding-right:%?30?%}.order-item .action-btn[data-v-c7b53526]{width:%?160?%;height:%?60?%;margin:%?20?% 0;margin-left:%?24?%;padding:0;text-align:center;line-height:%?60?%;font-size:%?26?%;color:#303133;background:#fff;-webkit-border-radius:100px;border-radius:100px}.order-item .action-btn[data-v-c7b53526]:after{-webkit-border-radius:100px;border-radius:100px}.order-item .action-btn.recom[data-v-c7b53526]{background:#fff9f9;color:#fa436a}.order-item .action-btn.recom[data-v-c7b53526]:after{border-color:#f7bcc8}\n/* load-more */.uni-load-more[data-v-c7b53526]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;flex-direction:row;height:%?80?%;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center}.uni-load-more__text[data-v-c7b53526]{font-size:%?28?%;color:#999}.uni-load-more__img[data-v-c7b53526]{height:24px;width:24px;margin-right:10px}.uni-load-more__img > uni-view[data-v-c7b53526]{position:absolute}.uni-load-more__img > uni-view uni-view[data-v-c7b53526]{width:6px;height:2px;-webkit-border-top-left-radius:1px;border-top-left-radius:1px;-webkit-border-bottom-left-radius:1px;border-bottom-left-radius:1px;background:#999;position:absolute;opacity:.2;-webkit-transform-origin:50%;transform-origin:50%;-webkit-animation:load-data-v-c7b53526 1.56s ease infinite;animation:load-data-v-c7b53526 1.56s ease infinite}.uni-load-more__img > uni-view uni-view[data-v-c7b53526]:nth-child(1){-webkit-transform:rotate(90deg);transform:rotate(90deg);top:2px;left:9px}.uni-load-more__img > uni-view uni-view[data-v-c7b53526]:nth-child(2){-webkit-transform:rotate(180deg);transform:rotate(180deg);top:11px;right:0}.uni-load-more__img > uni-view uni-view[data-v-c7b53526]:nth-child(3){-webkit-transform:rotate(270deg);transform:rotate(270deg);bottom:2px;left:9px}.uni-load-more__img > uni-view uni-view[data-v-c7b53526]:nth-child(4){top:11px;left:0}.load1[data-v-c7b53526],\n.load2[data-v-c7b53526],\n.load3[data-v-c7b53526]{height:24px;width:24px}.load2[data-v-c7b53526]{-webkit-transform:rotate(30deg);transform:rotate(30deg)}.load3[data-v-c7b53526]{-webkit-transform:rotate(60deg);transform:rotate(60deg)}.load1 uni-view[data-v-c7b53526]:nth-child(1){-webkit-animation-delay:0s;animation-delay:0s}.load2 uni-view[data-v-c7b53526]:nth-child(1){-webkit-animation-delay:.13s;animation-delay:.13s}.load3 uni-view[data-v-c7b53526]:nth-child(1){-webkit-animation-delay:.26s;animation-delay:.26s}.load1 uni-view[data-v-c7b53526]:nth-child(2){-webkit-animation-delay:.39s;animation-delay:.39s}.load2 uni-view[data-v-c7b53526]:nth-child(2){-webkit-animation-delay:.52s;animation-delay:.52s}.load3 uni-view[data-v-c7b53526]:nth-child(2){-webkit-animation-delay:.65s;animation-delay:.65s}.load1 uni-view[data-v-c7b53526]:nth-child(3){-webkit-animation-delay:.78s;animation-delay:.78s}.load2 uni-view[data-v-c7b53526]:nth-child(3){-webkit-animation-delay:.91s;animation-delay:.91s}.load3 uni-view[data-v-c7b53526]:nth-child(3){-webkit-animation-delay:1.04s;animation-delay:1.04s}.load1 uni-view[data-v-c7b53526]:nth-child(4){-webkit-animation-delay:1.17s;animation-delay:1.17s}.load2 uni-view[data-v-c7b53526]:nth-child(4){-webkit-animation-delay:1.3s;animation-delay:1.3s}.load3 uni-view[data-v-c7b53526]:nth-child(4){-webkit-animation-delay:1.43s;animation-delay:1.43s}@-webkit-keyframes load-data-v-c7b53526{0%{opacity:1}100%{opacity:.2}}uni-page-body[data-v-c7b53526], .content[data-v-c7b53526]{background:#f8f8f8;height:100%}.swiper-box[data-v-c7b53526]{height:calc(100% - 40px)}.list-scroll-content[data-v-c7b53526]{height:100%}.uni-swiper-item[data-v-c7b53526]{height:auto}.items[data-v-c7b53526]{margin:%?20?%;padding:%?10?% %?20?%;-webkit-border-radius:%?20?%;border-radius:%?20?%;background-color:#fff}.items .top[data-v-c7b53526]{height:%?60?%;font-size:%?28?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between;border-bottom:%?1?% solid #f5f5f5}.items .top .state[data-v-c7b53526]{color:#fa436a}.items .bottom[data-v-c7b53526]{line-height:%?50?%;margin-top:%?4?%}.items .bottom .price[data-v-c7b53526]{color:#fa436a}.items .bottom .time[data-v-c7b53526]{color:#909399;text-align:right;font-size:%?28?%}body.?%PAGE?%[data-v-c7b53526]{background:#f8f8f8}',""]),t.exports=e}}]);