(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-income-fy_cent"],{"17b1":function(t,e,a){"use strict";a.r(e);var i=a("f404"),n=a("4aa5");for(var o in n)"default"!==o&&function(t){a.d(e,t,(function(){return n[t]}))}(o);a("e73d");var r,d=a("f0c5"),l=Object(d["a"])(n["default"],i["b"],i["c"],!1,null,"552338a7",null,!1,i["a"],r);e["default"]=l.exports},"1f28":function(t,e,a){"use strict";var i=a("4ea4");a("99af"),a("4de4"),a("4160"),a("c975"),a("159b"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0,a("96cf");var n=i(a("1da1")),o=i(a("00a0")),r={components:{uniLoadMore:o.default},data:function(){return{cloneHeight:0,tabCurrentIndex:0,refresh:!1,page:0,oldId:null,navList:[{state:0,text:"全部",loadingType:"more",orderList:[]},{state:1,text:"区域",loadingType:"more",orderList:[]},{state:2,text:"拼团推广",loadingType:"more",orderList:[]},{state:3,text:"推广收益",loadingType:"more",orderList:[]}]}},onReady:function(){this.cloneHeight=document.documentElement.clientHeight||document.body.clientHeight},onLoad:function(){this.getCent(0)},onShow:function(){uni.getStorage({key:"version",success:function(t){document.title="".concat(document.title," - ").concat(JSON.parse(t.data).site.name)}})},watch:{refresh:function(t){t&&(this.refresh=!1,this.getCent(0))}},methods:{getCent:function(t,e){var a=this;return(0,n.default)(regeneratorRuntime.mark((function i(){var n,o,r,d;return regeneratorRuntime.wrap((function(i){while(1)switch(i.prev=i.next){case 0:if(n=a.tabCurrentIndex,o=a.navList[n],o.state,"tabChange"!==e||!0!==o.loaded){i.next=5;break}return i.abrupt("return");case 5:if("loading"!==o.loadingType){i.next=7;break}return i.abrupt("return");case 7:if("noMore"!==o.loadingType){i.next=10;break}return a.page-=1,i.abrupt("return");case 10:if(a.oldId!=t&&(a.page=0),o.loadingType="loading",0!=t){i.next=18;break}return i.next=15,a.$request.post("/api/plugin.hasog_pintuan-index-log-index",{page:a.page});case 15:r=i.sent,i.next=21;break;case 18:return i.next=20,a.$request.post("/api/plugin.hasog_pintuan-index-log-index",{id:t,page:a.page});case 20:r=i.sent;case 21:if(!r.url||-1==r.url.indexOf("login")){i.next=24;break}return uni.showModal({title:"温馨提示",content:r.msg,success:function(t){t.confirm?a.$Router.push({name:"Login"}):a.$Router.back(1)}}),i.abrupt("return");case 24:1==r.code?(a.oldId=t,d=r.data,a.page+=1,0==r.data.length?o.loadingType="noMore":o.loadingType="more"):a.$api.modal(r.msg),setTimeout((function(){1==a.page&&(o.orderList=[]),d.filter((function(t){return a.$set(t,"state",a.orderStateExp(t.fy)),t})),d.forEach((function(t){o.orderList.push(t)})),a.$set(o,"loaded",!0)}),600);case 26:case"end":return i.stop()}}),i)})))()},changeTab:function(t){this.tabCurrentIndex=t.target.current,this.getCent(this.tabCurrentIndex,"tabChange")},tabClick:function(t){this.tabCurrentIndex=t,this.getCent(this.tabCurrentIndex)},orderStateExp:function(t){var e="",a="#fa436a";switch(t){case 0:e="";break;case 1:e="待结算";break;case 2:e="已结算",a="#4cd964";break}return{stateTip:e,stateTipColor:a}}}};e.default=r},"4aa5":function(t,e,a){"use strict";a.r(e);var i=a("1f28"),n=a.n(i);for(var o in i)"default"!==o&&function(t){a.d(e,t,(function(){return i[t]}))}(o);e["default"]=n.a},6535:function(t,e,a){var i=a("994e");"string"===typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);var n=a("4f06").default;n("73f246a8",i,!0,{sourceMap:!1,shadowMode:!1})},"994e":function(t,e,a){var i=a("24fb");e=i(!1),e.push([t.i,'@charset "UTF-8";\n/* 页面左右间距 */\n/* 文字尺寸 */\n/*文字颜色*/\n/* 边框颜色 */\n/* 图片加载中颜色 */\n/* 行为相关颜色 */.navbar[data-v-552338a7]{display:-webkit-box;display:-webkit-flex;display:flex;height:40px;padding:0 5px;background:#fff;box-shadow:0 1px 5px rgba(0,0,0,.06);position:relative;z-index:10}.navbar .nav-item[data-v-552338a7]{-webkit-box-flex:1;-webkit-flex:1;flex:1;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;align-items:center;height:100%;font-size:15px;color:#303133;position:relative}.navbar .nav-item.current[data-v-552338a7]{color:#fa436a}.navbar .nav-item.current[data-v-552338a7]:after{content:"";position:absolute;left:50%;bottom:0;-webkit-transform:translateX(-50%);transform:translateX(-50%);width:44px;height:0;border-bottom:2px solid #fa436a}.order-item[data-v-552338a7]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;padding-left:%?30?%;background:#fff;margin-top:%?16?%\n  /* 多条商品 */\n  /* 单条商品 */}.order-item .i-top[data-v-552338a7]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;height:%?80?%;padding-right:%?30?%;font-size:%?28?%;color:#303133;position:relative}.order-item .i-top .time[data-v-552338a7]{-webkit-box-flex:1;-webkit-flex:1;flex:1}.order-item .i-top .state[data-v-552338a7]{color:#fa436a}.order-item .i-top .del-btn[data-v-552338a7]{padding:%?10?% 0 %?10?% %?36?%;font-size:%?32?%;color:#909399;position:relative}.order-item .i-top .del-btn[data-v-552338a7]:after{content:"";width:0;height:%?30?%;border-left:1px solid #dcdfe6;position:absolute;left:%?20?%;top:50%;-webkit-transform:translateY(-50%);transform:translateY(-50%)}.order-item .goods-box[data-v-552338a7]{height:%?160?%;padding:%?20?% 0;white-space:nowrap}.order-item .goods-box .goods-item[data-v-552338a7]{width:%?120?%;height:%?120?%;display:inline-block;margin-right:%?24?%}.order-item .goods-box .goods-img[data-v-552338a7]{display:block;width:100%;height:100%}.order-item .goods-box-single[data-v-552338a7]{display:-webkit-box;display:-webkit-flex;display:flex;padding:%?20?% 0}.order-item .goods-box-single .goods-img[data-v-552338a7]{display:block;width:%?160?%;height:%?160?%}.order-item .goods-box-single .right[data-v-552338a7]{-webkit-box-flex:1;-webkit-flex:1;flex:1;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between;padding:0 %?30?% 0 %?24?%;overflow:hidden}.order-item .goods-box-single .right .middle[data-v-552338a7]{margin-right:%?10?%}.order-item .goods-box-single .right .middle .title[data-v-552338a7]{font-size:%?30?%;color:#303133;line-height:%?40?%;white-space:pre-wrap;word-break:break-all;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;overflow:hidden}.order-item .goods-box-single .right .middle .spec[data-v-552338a7]{padding:%?10?% 0;font-size:%?26?%;color:#909399}.order-item .goods-box-single .right .middle .spec uni-text[data-v-552338a7]{margin-right:%?10?%}.order-item .goods-box-single .right .rRight[data-v-552338a7]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;-webkit-box-align:end;-webkit-align-items:flex-end;align-items:flex-end}.order-item .goods-box-single .right .rRight .attr-box[data-v-552338a7]{text-align:right;font-size:%?26?%;color:#909399;padding:%?10?% 0}.order-item .goods-box-single .right .rRight .price[data-v-552338a7]{text-align:right;font-size:%?30?%;color:#303133}.order-item .goods-box-single .right .rRight .price[data-v-552338a7]:before{content:"￥";font-size:%?24?%;margin:0 %?2?% 0 %?8?%}.order-item .price-box[data-v-552338a7]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:end;-webkit-justify-content:flex-end;justify-content:flex-end;-webkit-box-align:baseline;-webkit-align-items:baseline;align-items:baseline;padding:%?20?% %?30?%;font-size:%?26?%;color:#909399}.order-item .price-box .num[data-v-552338a7]{margin:0 %?8?%;color:#303133}.order-item .price-box .price[data-v-552338a7]{font-size:%?32?%;color:#fa436a}.order-item .price-box .price[data-v-552338a7]:before{content:"￥";font-size:%?24?%;margin:0 %?2?% 0 %?8?%}.order-item .action-box[data-v-552338a7]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:end;-webkit-justify-content:flex-end;justify-content:flex-end;-webkit-box-align:center;-webkit-align-items:center;align-items:center;position:relative;padding-right:%?30?%}.order-item .action-btn[data-v-552338a7]{width:%?160?%;height:%?60?%;margin:%?20?% 0;margin-left:%?24?%;padding:0;text-align:center;line-height:%?60?%;font-size:%?26?%;color:#303133;background:#fff;border-radius:100px}.order-item .action-btn[data-v-552338a7]:after{border-radius:100px}.order-item .action-btn.recom[data-v-552338a7]{background:#fff9f9;color:#fa436a}.order-item .action-btn.recom[data-v-552338a7]:after{border-color:#f7bcc8}\n/* load-more */.uni-load-more[data-v-552338a7]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;flex-direction:row;height:%?80?%;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center}.uni-load-more__text[data-v-552338a7]{font-size:%?28?%;color:#999}.uni-load-more__img[data-v-552338a7]{height:24px;width:24px;margin-right:10px}.uni-load-more__img > uni-view[data-v-552338a7]{position:absolute}.uni-load-more__img > uni-view uni-view[data-v-552338a7]{width:6px;height:2px;border-top-left-radius:1px;border-bottom-left-radius:1px;background:#999;position:absolute;opacity:.2;-webkit-transform-origin:50%;transform-origin:50%;-webkit-animation:load-data-v-552338a7 1.56s ease infinite;animation:load-data-v-552338a7 1.56s ease infinite}.uni-load-more__img > uni-view uni-view[data-v-552338a7]:nth-child(1){-webkit-transform:rotate(90deg);transform:rotate(90deg);top:2px;left:9px}.uni-load-more__img > uni-view uni-view[data-v-552338a7]:nth-child(2){-webkit-transform:rotate(180deg);transform:rotate(180deg);top:11px;right:0}.uni-load-more__img > uni-view uni-view[data-v-552338a7]:nth-child(3){-webkit-transform:rotate(270deg);transform:rotate(270deg);bottom:2px;left:9px}.uni-load-more__img > uni-view uni-view[data-v-552338a7]:nth-child(4){top:11px;left:0}.load1[data-v-552338a7],\n.load2[data-v-552338a7],\n.load3[data-v-552338a7]{height:24px;width:24px}.load2[data-v-552338a7]{-webkit-transform:rotate(30deg);transform:rotate(30deg)}.load3[data-v-552338a7]{-webkit-transform:rotate(60deg);transform:rotate(60deg)}.load1 uni-view[data-v-552338a7]:nth-child(1){-webkit-animation-delay:0s;animation-delay:0s}.load2 uni-view[data-v-552338a7]:nth-child(1){-webkit-animation-delay:.13s;animation-delay:.13s}.load3 uni-view[data-v-552338a7]:nth-child(1){-webkit-animation-delay:.26s;animation-delay:.26s}.load1 uni-view[data-v-552338a7]:nth-child(2){-webkit-animation-delay:.39s;animation-delay:.39s}.load2 uni-view[data-v-552338a7]:nth-child(2){-webkit-animation-delay:.52s;animation-delay:.52s}.load3 uni-view[data-v-552338a7]:nth-child(2){-webkit-animation-delay:.65s;animation-delay:.65s}.load1 uni-view[data-v-552338a7]:nth-child(3){-webkit-animation-delay:.78s;animation-delay:.78s}.load2 uni-view[data-v-552338a7]:nth-child(3){-webkit-animation-delay:.91s;animation-delay:.91s}.load3 uni-view[data-v-552338a7]:nth-child(3){-webkit-animation-delay:1.04s;animation-delay:1.04s}.load1 uni-view[data-v-552338a7]:nth-child(4){-webkit-animation-delay:1.17s;animation-delay:1.17s}.load2 uni-view[data-v-552338a7]:nth-child(4){-webkit-animation-delay:1.3s;animation-delay:1.3s}.load3 uni-view[data-v-552338a7]:nth-child(4){-webkit-animation-delay:1.43s;animation-delay:1.43s}@-webkit-keyframes load-data-v-552338a7{0%{opacity:1}100%{opacity:.2}}uni-page-body[data-v-552338a7], .content[data-v-552338a7]{background:#f8f8f8;height:100%}.swiper-box[data-v-552338a7]{height:calc(100% - 40px)}.list-scroll-content[data-v-552338a7]{height:100%}.uni-swiper-item[data-v-552338a7]{height:auto}.order-item .center[data-v-552338a7]{padding-top:%?20?%;padding-right:%?30?%}body.?%PAGE?%[data-v-552338a7]{background:#f8f8f8}',""]),t.exports=e},e73d:function(t,e,a){"use strict";var i=a("6535"),n=a.n(i);n.a},f404:function(t,e,a){"use strict";a.d(e,"b",(function(){return n})),a.d(e,"c",(function(){return o})),a.d(e,"a",(function(){return i}));var i={uniLoadMore:a("00a0").default},n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("v-uni-view",{staticClass:"content"},[a("nav-bar",[t._v("收益记录")]),a("v-uni-view",{staticClass:"navbar"},t._l(t.navList,(function(e,i){return a("v-uni-view",{key:i,staticClass:"nav-item",class:{current:t.tabCurrentIndex===i},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.tabClick(i)}}},[t._v(t._s(e.text))])})),1),a("v-uni-swiper",{staticClass:"swiper-box",style:{height:t.cloneHeight-90+"px"},attrs:{current:t.tabCurrentIndex,duration:"300"},on:{change:function(e){arguments[0]=e=t.$handleEvent(e),t.changeTab.apply(void 0,arguments)}}},t._l(t.navList,(function(e,i){return a("v-uni-swiper-item",{key:i,staticClass:"tab-content"},[a("v-uni-scroll-view",{staticClass:"list-scroll-content",attrs:{"scroll-y":!0},on:{scrolltolower:function(e){arguments[0]=e=t.$handleEvent(e),t.getCent(i)}}},[!0===e.loaded&&0===e.orderList.length?a("empty"):t._e(),t._l(e.orderList,(function(e,i){return a("v-uni-view",{key:i,staticClass:"order-item"},[a("v-uni-view",{staticClass:"i-top b-b"},[a("v-uni-text",{staticClass:"time"},[t._v("购买者ID: "+t._s(e.child_uid))]),a("v-uni-text",{staticClass:"state"},[a("v-uni-text",{staticClass:"price-icon"},[t._v("￥")]),t._v(t._s(e.je))],1)],1),a("v-uni-view",{staticClass:"center"},[a("v-uni-view",{staticClass:"desc"},[t._v(t._s(e.data))])],1),a("v-uni-view",{staticClass:"price-box"},[t._v(t._s(t.$api.tier(e.time)))])],1)})),a("uni-load-more",{attrs:{status:e.loadingType}})],2)],1)})),1)],1)},o=[]}}]);