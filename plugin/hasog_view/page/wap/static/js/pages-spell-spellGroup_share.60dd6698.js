(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-spell-spellGroup_share"],{1081:function(t,e,a){"use strict";var i=a("fcce"),n=a.n(i);n.a},"2a58":function(t,e,a){"use strict";var i;a.d(e,"b",(function(){return n})),a.d(e,"c",(function(){return d})),a.d(e,"a",(function(){return i}));var n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("v-uni-view",[t.datas?a("v-uni-view",{staticClass:"list-item"},[a("v-uni-view",{staticClass:"item"},[a("v-uni-view",{staticClass:"img"},[a("v-uni-image",{attrs:{src:t.datas.pic||"/static/errorImage.jpg"}}),a("v-uni-view",{staticClass:"state"})],1),a("v-uni-view",{staticClass:"d"},[a("v-uni-view",{staticClass:"title"},[a("v-uni-view",[t._v(t._s(t.datas.title))])],1),a("v-uni-view",{staticClass:"peple"},[a("v-uni-view",[a("v-uni-text",{staticClass:"iconfont icon-ziyuan1"}),t._v(t._s(t.datas.goods_max)+"人团")],1)],1),a("v-uni-view",{staticClass:"price"},[a("v-uni-view",{staticClass:"price-l"},[a("v-uni-view",{staticClass:"goods_price"},[a("v-uni-text",{staticClass:"price-icon"},[t._v("￥")]),t._v(t._s(t.datas.price))],1),a("v-uni-view",{staticClass:"progress"},[a("v-uni-view",{staticClass:"txt",style:{width:(Math.round(t.datas.goods_num/t.datas.goods_max*100*100)/100).toFixed(2)+"%"}})],1),a("v-uni-view",{staticStyle:{color:"#999"}},[t._v("进度 "+t._s((Math.round(t.datas.goods_num/t.datas.goods_max*100*100)/100).toFixed(2))+"%")])],1),a("v-uni-view",{staticClass:"exchange",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.toggleSpec(t.datas)}}},[t._v("去参团"),a("v-uni-text",{staticClass:"yticon icon-you"})],1)],1)],1)],1)],1):t._e(),t.datas?a("v-uni-view",{staticClass:"notice"},[t._v("团长"),a("v-uni-text",[t._v(t._s(t.datas.tuanzhang))]),t._v("诚邀您参团")],1):t._e(),a("v-uni-view",{staticClass:"popup spec",class:t.specClass,on:{touchmove:function(e){e.stopPropagation(),e.preventDefault(),arguments[0]=e=t.$handleEvent(e),t.stopPrevent.apply(void 0,arguments)},click:function(e){arguments[0]=e=t.$handleEvent(e),t.toggleSpec.apply(void 0,arguments)}}},[a("v-uni-view",{staticClass:"mask"}),a("v-uni-view",{staticClass:"layer attr-content",on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.stopPrevent.apply(void 0,arguments)}}},[a("v-uni-view",{staticClass:"a-t"},[a("v-uni-image",{attrs:{src:t.datas.pic}}),a("v-uni-view",{staticClass:"right"},[a("v-uni-text",{staticClass:"price"},[t._v("¥"+t._s(t.datas.price))]),a("v-uni-text",{staticClass:"stock"},[t._v("单人购买最大份数："+t._s(t.datas.price_max))])],1),a("uni-number-box",{staticClass:"step",attrs:{min:1,max:t.datas.price_max,value:t.number,isMax:t.number>=t.datas.price_max,isMin:1===t.number,disabled:!0},on:{eventChange:function(e){arguments[0]=e=t.$handleEvent(e),t.numberChange.apply(void 0,arguments)}}})],1),a("v-uni-button",{staticClass:"btn",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.joinGroup()}}},[t._v("确定")])],1)],1)],1)},d=[]},"87d6":function(t,e,a){var i=a("24fb");e=i(!1),e.push([t.i,'@charset "UTF-8";\n/* 页面左右间距 */\n/* 文字尺寸 */\n/*文字颜色*/\n/* 边框颜色 */\n/* 图片加载中颜色 */\n/* 行为相关颜色 */.status_bar[data-v-4d5bd2d2]{height:0;width:100%}.list-item[data-v-4d5bd2d2]{min-height:%?160?%;margin:%?20?%;box-sizing:border-box;background-color:#fff;overflow:hidden}.list-item .item[data-v-4d5bd2d2]{display:-webkit-box;display:-webkit-flex;display:flex;padding:%?16?%}.list-item .item .img[data-v-4d5bd2d2]{position:relative;width:%?200?%;height:%?200?%;margin-right:%?16?%}.list-item .item .img uni-image[data-v-4d5bd2d2]{width:100%;height:100%;object-fit:cover;border-radius:10px}.list-item .item .d[data-v-4d5bd2d2]{-webkit-box-flex:1;-webkit-flex:1;flex:1;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-flow:column;flex-flow:column;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between}.list-item .item .d .title[data-v-4d5bd2d2]{height:auto;font-size:%?28?%;text-align:left;line-height:%?40?%;color:#333;overflow:hidden}.list-item .item .d .title uni-view[data-v-4d5bd2d2]{height:%?80?%;text-align:left;overflow:hidden;text-overflow:ellipsis;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;color:#333}.list-item .item .d .price[data-v-4d5bd2d2]{font-size:%?24?%;overflow:hidden;position:relative;text-align:left;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between}.list-item .item .d .price .price-l[data-v-4d5bd2d2]{-webkit-box-flex:1;-webkit-flex:1;flex:1}.list-item .item .d .price .price-l .goods_price[data-v-4d5bd2d2]{color:#fa436a;font-size:%?32?%;font-weight:700}.list-item .item .d .price .price-l .progress[data-v-4d5bd2d2]{color:#fff;width:80%;height:%?20?%;line-height:%?20?%;background-color:#febdbb;border-radius:5px}.list-item .item .d .price .price-l .progress .txt[data-v-4d5bd2d2]{height:100%;border-radius:5px;background-image:-webkit-linear-gradient(45deg,#ff530e,#fe3763);background-image:linear-gradient(45deg,#ff530e,#fe3763)}.list-item .item .d .price .exchange[data-v-4d5bd2d2]{color:#fff;height:%?56?%;line-height:%?56?%;padding:0 %?14?%;border-radius:5px;box-sizing:border-box;background-color:#fa436a}.list-item .item .d .price .exchange .yticon[data-v-4d5bd2d2]{font-size:%?28?%}.notice[data-v-4d5bd2d2]{text-align:center}.notice uni-text[data-v-4d5bd2d2]{margin:0 %?10?%;color:#fa436a}\n/* 规格选择弹窗 */.attr-content[data-v-4d5bd2d2]{padding:%?10?% %?30?%;min-height:20vh!important}.attr-content .a-t[data-v-4d5bd2d2]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:end;-webkit-align-items:flex-end;align-items:flex-end}.attr-content .a-t uni-image[data-v-4d5bd2d2]{width:%?170?%;height:%?170?%;-webkit-flex-shrink:0;flex-shrink:0;margin-top:%?-40?%;border-radius:%?8?%}.attr-content .a-t .right[data-v-4d5bd2d2]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;padding-left:%?24?%;margin-right:%?8?%;font-size:%?26?%;color:#606266;line-height:%?42?%}.attr-content .a-t .right .price[data-v-4d5bd2d2]{font-size:%?32?%;color:#fa436a;margin-bottom:%?10?%}.attr-content .a-t .uni-numbox[data-v-4d5bd2d2]{position:static;left:unset;right:0}\n/*  弹出层 */.popup[data-v-4d5bd2d2]{position:fixed;left:0;top:0;right:0;bottom:0;z-index:99}.popup.show[data-v-4d5bd2d2]{display:block}.popup.show .mask[data-v-4d5bd2d2]{-webkit-animation:showPopup-data-v-4d5bd2d2 .2s linear both;animation:showPopup-data-v-4d5bd2d2 .2s linear both}.popup.show .layer[data-v-4d5bd2d2]{-webkit-animation:showLayer-data-v-4d5bd2d2 .2s linear both;animation:showLayer-data-v-4d5bd2d2 .2s linear both}.popup.hide .mask[data-v-4d5bd2d2]{-webkit-animation:hidePopup-data-v-4d5bd2d2 .2s linear both;animation:hidePopup-data-v-4d5bd2d2 .2s linear both}.popup.hide .layer[data-v-4d5bd2d2]{-webkit-animation:hideLayer-data-v-4d5bd2d2 .2s linear both;animation:hideLayer-data-v-4d5bd2d2 .2s linear both}.popup.none[data-v-4d5bd2d2]{display:none}.popup .mask[data-v-4d5bd2d2]{position:fixed;top:0;width:100%;height:100%;z-index:1;background-color:rgba(0,0,0,.4)}.popup .layer[data-v-4d5bd2d2]{position:fixed;z-index:99;bottom:0;width:100%;min-height:40vh;border-radius:%?10?% %?10?% 0 0;background-color:#fff}.popup .layer .btn[data-v-4d5bd2d2]{height:%?66?%;line-height:%?66?%;border-radius:%?100?%;background:#fa436a;font-size:%?30?%;color:#fff;margin:%?30?% auto %?20?%}@-webkit-keyframes showPopup-data-v-4d5bd2d2{0%{opacity:0}100%{opacity:1}}@keyframes showPopup-data-v-4d5bd2d2{0%{opacity:0}100%{opacity:1}}@-webkit-keyframes hidePopup-data-v-4d5bd2d2{0%{opacity:1}100%{opacity:0}}@keyframes hidePopup-data-v-4d5bd2d2{0%{opacity:1}100%{opacity:0}}@-webkit-keyframes showLayer-data-v-4d5bd2d2{0%{-webkit-transform:translateY(120%);transform:translateY(120%)}100%{-webkit-transform:translateY(0);transform:translateY(0)}}@keyframes showLayer-data-v-4d5bd2d2{0%{-webkit-transform:translateY(120%);transform:translateY(120%)}100%{-webkit-transform:translateY(0);transform:translateY(0)}}@-webkit-keyframes hideLayer-data-v-4d5bd2d2{0%{-webkit-transform:translateY(0);transform:translateY(0)}100%{-webkit-transform:translateY(120%);transform:translateY(120%)}}@keyframes hideLayer-data-v-4d5bd2d2{0%{-webkit-transform:translateY(0);transform:translateY(0)}100%{-webkit-transform:translateY(120%);transform:translateY(120%)}}',""]),t.exports=e},da4a:function(t,e,a){"use strict";a.r(e);var i=a("2a58"),n=a("dee0");for(var d in n)"default"!==d&&function(t){a.d(e,t,(function(){return n[t]}))}(d);a("1081");var s,o=a("f0c5"),r=Object(o["a"])(n["default"],i["b"],i["c"],!1,null,"4d5bd2d2",null,!1,i["a"],s);e["default"]=r.exports},dee0:function(t,e,a){"use strict";a.r(e);var i=a("fde0"),n=a.n(i);for(var d in i)"default"!==d&&function(t){a.d(e,t,(function(){return i[t]}))}(d);e["default"]=n.a},fcce:function(t,e,a){var i=a("87d6");"string"===typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);var n=a("4f06").default;n("492aea89",i,!0,{sourceMap:!1,shadowMode:!1})},fde0:function(t,a,i){"use strict";(function(t){var n=i("4ea4");i("99af"),i("c975"),Object.defineProperty(a,"__esModule",{value:!0}),a.default=void 0,i("96cf");var d=n(i("1da1")),s=n(i("e3bb")),o={components:{uniNumberBox:s.default},data:function(){return{ptId:"",parent_id:0,datas:null,number:1,specClass:"none",refresh:!1}},onLoad:function(){this.ptId=this.$Route.query.id,this.parent_id=this.$Route.query.parent_id,this.getDetail()},onShow:function(){var t=this;return(0,d.default)(regeneratorRuntime.mark((function a(){var i;return regeneratorRuntime.wrap((function(a){while(1)switch(a.prev=a.next){case 0:return a.next=2,t.$request.get("/api/");case 2:i=a.sent,1==i.code&&(document.title="".concat(document.title," - ").concat(JSON.parse(e.data).site.name),uni.setStorage({key:"version",data:JSON.stringify(i.data)}));case 4:case"end":return a.stop()}}),a)})))()},watch:{refresh:function(t){t&&(this.refresh=!1,this.getDetail())}},beforeRouteLeave:function(e,a,i){t("log",e,a," at pages/spell/spellGroup_share.vue:108"),i()},mounted:function(){var t=document.getElementsByClassName("uni-page-head-hd")[0];t.style.display="none"},methods:{getDetail:function(){var t=this;return(0,d.default)(regeneratorRuntime.mark((function e(){var a;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,t.$request.get("/api/plugin.hasog_pintuan-index-index-shop",{id:t.ptId});case 2:a=e.sent,1==a.code?t.datas=a.data:uni.showModal({title:"温馨提示",content:a.msg,success:function(e){e.confirm&&t.$Router.push({name:"Home"})}});case 4:case"end":return e.stop()}}),e)})))()},toggleSpec:function(){var t=this;"show"===this.specClass?(this.specClass="hide",setTimeout((function(){t.specClass="none"}),250)):"none"===this.specClass&&(this.specClass="show")},numberChange:function(t){this.number=t.number},stopPrevent:function(){},joinGroup:function(){var t=this;return(0,d.default)(regeneratorRuntime.mark((function e(){var a;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,t.$request.post("/api/plugin.hasog_pintuan-index-index-post",{id:t.datas.pid,num:t.number,pid:t.datas.id});case 2:if(a=e.sent,t.number=1,t.toggleSpec({}),!a.url||-1==a.url.indexOf("login")){e.next=9;break}return uni.setStorage({key:"sharePT",data:"".concat(t.$request.baseUrl,"/#/spellGroupShare?id=").concat(t.ptId,"&parent_id=").concat(t.parent_id)}),t.$Router.push({name:"Login"}),e.abrupt("return");case 9:1==a.code?(t.$api.msg(a.msg),setTimeout((function(){t.$Router.replaceAll({name:"Home"})}),1500)):t.$api.modal(a.msg);case 10:case"end":return e.stop()}}),e)})))()}}};a.default=o}).call(this,i("0de9")["log"])}}]);