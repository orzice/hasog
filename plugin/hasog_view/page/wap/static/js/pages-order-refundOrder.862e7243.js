(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-order-refundOrder"],{1943:function(t,e,r){"use strict";var n=r("4ea4");r("99af"),r("4de4"),r("4160"),r("c975"),r("ac1f"),r("5319"),r("159b"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0,r("96cf");var i=n(r("1da1")),o={data:function(){return{loaded:!1,orderList:[],page:0,isMore:!0,refresh:!1}},onLoad:function(){this.getList()},onShow:function(){uni.getStorage({key:"version",success:function(t){document.title="".concat(document.title," - ").concat(JSON.parse(t.data).site.name)}})},watch:{refresh:function(t){t&&(this.page=0,this.getList())}},methods:{getList:function(){var t=this;return(0,i.default)(regeneratorRuntime.mark((function e(){var r,n;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,t.$request.get("/api/order/order_list",{status:-2,page:t.page});case 2:if(r=e.sent,!r.url||-1==r.url.indexOf("login")){e.next=6;break}return uni.showModal({title:"温馨提示",content:r.msg,success:function(e){e.confirm?t.$Router.push({name:"Login"}):t.$Router.back(1)}}),e.abrupt("return");case 6:if(1!=r.code){e.next=15;break}if(0!=t.page||0!=r.data.order_list.length){e.next=10;break}return t.loaded=!0,e.abrupt("return");case 10:n=r.data.order_list,t.page+=1,0==r.data.order_list.length&&(t.isMore=!1),e.next=16;break;case 15:t.$api.modal(r.msg);case 16:setTimeout((function(){1==t.page&&(t.orderList=[]),n.filter((function(e){return t.$set(e,"state",t.orderStateExp(e.status)),e})),n.forEach((function(e){t.orderList.push(e)}))}),600);case 17:case"end":return e.stop()}}),e)})))()},operationOrder:function(t,e){var r=this;return(0,i.default)(regeneratorRuntime.mark((function n(){var i,o;return regeneratorRuntime.wrap((function(n){while(1)switch(n.prev=n.next){case 0:n.t0=t,n.next="delete"===n.t0?3:"cancel"===n.t0?5:"refund"===n.t0?7:"confirm"===n.t0?9:11;break;case 3:return i="/api/order/delete_order",n.abrupt("break",11);case 5:return i="/api/order/cancel_order",n.abrupt("break",11);case 7:return i="/api/order/apply_refund",n.abrupt("break",11);case 9:return i="/api/order/confirm_receipt",n.abrupt("break",11);case 11:return n.next=13,r.$request.post(i,{order_id:e},"请稍后");case 13:if(o=n.sent,!o.url||-1==o.url.indexOf("login")){n.next=17;break}return uni.showModal({title:"温馨提示",content:o.msg,success:function(t){t.confirm?r.$Router.push({name:"Login"}):r.$Router.back(1)}}),n.abrupt("return");case 17:1==o.code?(r.$api.msg(o.msg),setTimeout((function(){r.$Router.replace({name:"RefundOrder"})}),1500)):r.$api.modal(o.msg);case 18:case"end":return n.stop()}}),n)})))()},goPay:function(t,e){this.$Router.push({name:"OrderPay",params:{money:t,oid:e}})},orderStateExp:function(t){var e="",r="#fa436a";switch(t){case 0:e="待付款";break;case 1:e="待发货";break;case 2:e="待收货";break;case 3:e="交易完成",r="#4cd964";break;case-1:e="订单关闭",r="#909399";break;case-2:e="申请退款",r="#dd524d";break}return{stateTip:e,stateTipColor:r}}}};e.default=o},"1da1":function(t,e,r){"use strict";function n(t,e,r,n,i,o,a){try{var s=t[o](a),c=s.value}catch(l){return void r(l)}s.done?e(c):Promise.resolve(c).then(n,i)}function i(t){return function(){var e=this,r=arguments;return new Promise((function(i,o){var a=t.apply(e,r);function s(t){n(a,i,o,s,c,"next",t)}function c(t){n(a,i,o,s,c,"throw",t)}s(void 0)}))}}r("d3b7"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=i},"24ec":function(t,e,r){"use strict";var n=r("b92c"),i=r.n(n);i.a},2842:function(t,e,r){"use strict";var n;r.d(e,"b",(function(){return i})),r.d(e,"c",(function(){return o})),r.d(e,"a",(function(){return n}));var i=function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("v-uni-view",{staticClass:"content"},[!0===t.loaded&&0===t.orderList.length?r("empty"):t._e(),t._l(t.orderList,(function(e,n){return r("v-uni-view",{key:n,staticClass:"order-item"},[r("v-uni-view",{staticClass:"i-top b-b"},[r("v-uni-text",{staticClass:"time"},[t._v(t._s(e.order_sn))]),r("v-uni-text",{staticClass:"state",style:{color:e.state.stateTipColor}},[t._v(t._s(e.state.stateTip))]),e.enable_delete?r("v-uni-text",{staticClass:"del-btn yticon icon-iconfontshanchu1",on:{click:function(r){arguments[0]=r=t.$handleEvent(r),t.operationOrder("delete",e.id)}}}):t._e()],1),t._l(e.goods,(function(n,i){return r("v-uni-view",{key:i,staticClass:"goods-box-single",on:{click:function(r){arguments[0]=r=t.$handleEvent(r),t.toDetail(e.id)}}},[r("v-uni-image",{staticClass:"goods-img",attrs:{src:n.thumb||"/static/errorImage.jpg",mode:"aspectFill"}}),r("v-uni-view",{staticClass:"right"},[r("v-uni-view",{staticClass:"middle"},[r("v-uni-text",{staticClass:"title clamp"},[t._v(t._s(n.title))]),n.goods_option?r("v-uni-view",{staticClass:"spec"},t._l(JSON.parse(n.goods_option),(function(e,n){return r("v-uni-text",[t._v(t._s(e.value))])})),1):t._e()],1),r("v-uni-view",{staticClass:"rRight"},[r("v-uni-text",{staticClass:"price"},[t._v(t._s(n.price*n.total))]),r("v-uni-text",{staticClass:"attr-box"},[t._v("x "+t._s(n.total))])],1)],1)],1)})),r("v-uni-view",{staticClass:"price-box"},[t._v("共"),r("v-uni-text",{staticClass:"num"},[t._v(t._s(e.goods_total))]),t._v("件商品 实付款"),r("v-uni-text",{staticClass:"price"},[t._v(t._s(e.price))])],1),r("v-uni-view",{staticClass:"action-box b-t"},[e.enable_cancel?r("v-uni-button",{staticClass:"action-btn",on:{click:function(r){arguments[0]=r=t.$handleEvent(r),t.operationOrder("cancel",e.id)}}},[t._v("取消订单")]):t._e(),e.enable_refund?r("v-uni-button",{staticClass:"action-btn",on:{click:function(r){arguments[0]=r=t.$handleEvent(r),t.operationOrder("refund",e.id)}}},[t._v("申请退款")]):t._e(),2==e.status?r("v-uni-button",{staticClass:"action-btn",on:{click:function(r){arguments[0]=r=t.$handleEvent(r),t.operationOrder("confirm",e.id)}}},[t._v("确认收货")]):t._e(),0==e.status?r("v-uni-button",{staticClass:"action-btn recom",on:{click:function(r){arguments[0]=r=t.$handleEvent(r),t.goPay(e.price,e.id)}}},[t._v("立即支付")]):t._e()],1)],2)})),t.isMore?t._e():r("v-uni-view",{staticClass:"noMore"},[t._v("没有更多数据了")])],2)},o=[]},"784e":function(t,e,r){var n=r("24fb");e=n(!1),e.push([t.i,'@charset "UTF-8";\n/* 页面左右间距 */\n/* 文字尺寸 */\n/*文字颜色*/\n/* 边框颜色 */\n/* 图片加载中颜色 */\n/* 行为相关颜色 */.order-item[data-v-7b2f4342]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;padding-left:%?30?%;background:#fff;margin-top:%?16?%\n  /* 多条商品 */\n  /* 单条商品 */}.order-item .i-top[data-v-7b2f4342]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;height:%?80?%;padding-right:%?30?%;font-size:%?28?%;color:#303133;position:relative}.order-item .i-top .time[data-v-7b2f4342]{-webkit-box-flex:1;-webkit-flex:1;flex:1}.order-item .i-top .state[data-v-7b2f4342]{color:#fa436a}.order-item .i-top .del-btn[data-v-7b2f4342]{padding:%?10?% 0 %?10?% %?36?%;font-size:%?32?%;color:#909399;position:relative}.order-item .i-top .del-btn[data-v-7b2f4342]:after{content:"";width:0;height:%?30?%;border-left:1px solid #dcdfe6;position:absolute;left:%?20?%;top:50%;-webkit-transform:translateY(-50%);transform:translateY(-50%)}.order-item .goods-box[data-v-7b2f4342]{height:%?160?%;padding:%?20?% 0;white-space:nowrap}.order-item .goods-box .goods-item[data-v-7b2f4342]{width:%?120?%;height:%?120?%;display:inline-block;margin-right:%?24?%}.order-item .goods-box .goods-img[data-v-7b2f4342]{display:block;width:100%;height:100%}.order-item .goods-box-single[data-v-7b2f4342]{display:-webkit-box;display:-webkit-flex;display:flex;padding:%?20?% 0}.order-item .goods-box-single .goods-img[data-v-7b2f4342]{display:block;width:%?160?%;height:%?160?%}.order-item .goods-box-single .right[data-v-7b2f4342]{-webkit-box-flex:1;-webkit-flex:1;flex:1;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between;padding:0 %?30?% 0 %?24?%;overflow:hidden}.order-item .goods-box-single .right .middle[data-v-7b2f4342]{margin-right:%?10?%}.order-item .goods-box-single .right .middle .title[data-v-7b2f4342]{font-size:%?30?%;color:#303133;line-height:%?40?%;white-space:pre-wrap;word-break:break-all;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;overflow:hidden}.order-item .goods-box-single .right .middle .spec[data-v-7b2f4342]{padding:%?10?% 0;font-size:%?26?%;color:#909399}.order-item .goods-box-single .right .middle .spec uni-text[data-v-7b2f4342]{margin-right:%?10?%}.order-item .goods-box-single .right .rRight[data-v-7b2f4342]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;-webkit-box-align:end;-webkit-align-items:flex-end;align-items:flex-end}.order-item .goods-box-single .right .rRight .attr-box[data-v-7b2f4342]{text-align:right;font-size:%?26?%;color:#909399;padding:%?10?% 0}.order-item .goods-box-single .right .rRight .price[data-v-7b2f4342]{text-align:right;font-size:%?30?%;color:#303133}.order-item .goods-box-single .right .rRight .price[data-v-7b2f4342]:before{content:"￥";font-size:%?24?%;margin:0 %?2?% 0 %?8?%}.order-item .price-box[data-v-7b2f4342]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:end;-webkit-justify-content:flex-end;justify-content:flex-end;-webkit-box-align:baseline;-webkit-align-items:baseline;align-items:baseline;padding:%?20?% %?30?%;font-size:%?26?%;color:#909399}.order-item .price-box .num[data-v-7b2f4342]{margin:0 %?8?%;color:#303133}.order-item .price-box .price[data-v-7b2f4342]{font-size:%?32?%;color:#fa436a}.order-item .price-box .price[data-v-7b2f4342]:before{content:"￥";font-size:%?24?%;margin:0 %?2?% 0 %?8?%}.order-item .action-box[data-v-7b2f4342]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:end;-webkit-justify-content:flex-end;justify-content:flex-end;-webkit-box-align:center;-webkit-align-items:center;align-items:center;position:relative;padding-right:%?30?%}.order-item .action-btn[data-v-7b2f4342]{width:%?160?%;height:%?60?%;margin:%?20?% 0;margin-left:%?24?%;padding:0;text-align:center;line-height:%?60?%;font-size:%?26?%;color:#303133;background:#fff;border-radius:100px}.order-item .action-btn[data-v-7b2f4342]:after{border-radius:100px}.order-item .action-btn.recom[data-v-7b2f4342]{background:#fff9f9;color:#fa436a}.order-item .action-btn.recom[data-v-7b2f4342]:after{border-color:#f7bcc8}',""]),t.exports=e},"96cf":function(t,e){!function(e){"use strict";var r,n=Object.prototype,i=n.hasOwnProperty,o="function"===typeof Symbol?Symbol:{},a=o.iterator||"@@iterator",s=o.asyncIterator||"@@asyncIterator",c=o.toStringTag||"@@toStringTag",l="object"===typeof t,u=e.regeneratorRuntime;if(u)l&&(t.exports=u);else{u=e.regeneratorRuntime=l?t.exports:{},u.wrap=w;var d="suspendedStart",f="suspendedYield",p="executing",h="completed",b={},g={};g[a]=function(){return this};var v=Object.getPrototypeOf,m=v&&v(v(S([])));m&&m!==n&&i.call(m,a)&&(g=m);var x=L.prototype=k.prototype=Object.create(g);_.prototype=x.constructor=L,L.constructor=_,L[c]=_.displayName="GeneratorFunction",u.isGeneratorFunction=function(t){var e="function"===typeof t&&t.constructor;return!!e&&(e===_||"GeneratorFunction"===(e.displayName||e.name))},u.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,L):(t.__proto__=L,c in t||(t[c]="GeneratorFunction")),t.prototype=Object.create(x),t},u.awrap=function(t){return{__await:t}},E(C.prototype),C.prototype[s]=function(){return this},u.AsyncIterator=C,u.async=function(t,e,r,n){var i=new C(w(t,e,r,n));return u.isGeneratorFunction(e)?i:i.next().then((function(t){return t.done?t.value:i.next()}))},E(x),x[c]="Generator",x[a]=function(){return this},x.toString=function(){return"[object Generator]"},u.keys=function(t){var e=[];for(var r in t)e.push(r);return e.reverse(),function r(){while(e.length){var n=e.pop();if(n in t)return r.value=n,r.done=!1,r}return r.done=!0,r}},u.values=S,P.prototype={constructor:P,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=r,this.done=!1,this.delegate=null,this.method="next",this.arg=r,this.tryEntries.forEach(R),!t)for(var e in this)"t"===e.charAt(0)&&i.call(this,e)&&!isNaN(+e.slice(1))&&(this[e]=r)},stop:function(){this.done=!0;var t=this.tryEntries[0],e=t.completion;if("throw"===e.type)throw e.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var e=this;function n(n,i){return s.type="throw",s.arg=t,e.next=n,i&&(e.method="next",e.arg=r),!!i}for(var o=this.tryEntries.length-1;o>=0;--o){var a=this.tryEntries[o],s=a.completion;if("root"===a.tryLoc)return n("end");if(a.tryLoc<=this.prev){var c=i.call(a,"catchLoc"),l=i.call(a,"finallyLoc");if(c&&l){if(this.prev<a.catchLoc)return n(a.catchLoc,!0);if(this.prev<a.finallyLoc)return n(a.finallyLoc)}else if(c){if(this.prev<a.catchLoc)return n(a.catchLoc,!0)}else{if(!l)throw new Error("try statement without catch or finally");if(this.prev<a.finallyLoc)return n(a.finallyLoc)}}}},abrupt:function(t,e){for(var r=this.tryEntries.length-1;r>=0;--r){var n=this.tryEntries[r];if(n.tryLoc<=this.prev&&i.call(n,"finallyLoc")&&this.prev<n.finallyLoc){var o=n;break}}o&&("break"===t||"continue"===t)&&o.tryLoc<=e&&e<=o.finallyLoc&&(o=null);var a=o?o.completion:{};return a.type=t,a.arg=e,o?(this.method="next",this.next=o.finallyLoc,b):this.complete(a)},complete:function(t,e){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&e&&(this.next=e),b},finish:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var r=this.tryEntries[e];if(r.finallyLoc===t)return this.complete(r.completion,r.afterLoc),R(r),b}},catch:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var r=this.tryEntries[e];if(r.tryLoc===t){var n=r.completion;if("throw"===n.type){var i=n.arg;R(r)}return i}}throw new Error("illegal catch attempt")},delegateYield:function(t,e,n){return this.delegate={iterator:S(t),resultName:e,nextLoc:n},"next"===this.method&&(this.arg=r),b}}}function w(t,e,r,n){var i=e&&e.prototype instanceof k?e:k,o=Object.create(i.prototype),a=new P(n||[]);return o._invoke=O(t,r,a),o}function y(t,e,r){try{return{type:"normal",arg:t.call(e,r)}}catch(n){return{type:"throw",arg:n}}}function k(){}function _(){}function L(){}function E(t){["next","throw","return"].forEach((function(e){t[e]=function(t){return this._invoke(e,t)}}))}function C(t){function e(r,n,o,a){var s=y(t[r],t,n);if("throw"!==s.type){var c=s.arg,l=c.value;return l&&"object"===typeof l&&i.call(l,"__await")?Promise.resolve(l.__await).then((function(t){e("next",t,o,a)}),(function(t){e("throw",t,o,a)})):Promise.resolve(l).then((function(t){c.value=t,o(c)}),(function(t){return e("throw",t,o,a)}))}a(s.arg)}var r;function n(t,n){function i(){return new Promise((function(r,i){e(t,n,r,i)}))}return r=r?r.then(i,i):i()}this._invoke=n}function O(t,e,r){var n=d;return function(i,o){if(n===p)throw new Error("Generator is already running");if(n===h){if("throw"===i)throw o;return T()}r.method=i,r.arg=o;while(1){var a=r.delegate;if(a){var s=j(a,r);if(s){if(s===b)continue;return s}}if("next"===r.method)r.sent=r._sent=r.arg;else if("throw"===r.method){if(n===d)throw n=h,r.arg;r.dispatchException(r.arg)}else"return"===r.method&&r.abrupt("return",r.arg);n=p;var c=y(t,e,r);if("normal"===c.type){if(n=r.done?h:f,c.arg===b)continue;return{value:c.arg,done:r.done}}"throw"===c.type&&(n=h,r.method="throw",r.arg=c.arg)}}}function j(t,e){var n=t.iterator[e.method];if(n===r){if(e.delegate=null,"throw"===e.method){if(t.iterator.return&&(e.method="return",e.arg=r,j(t,e),"throw"===e.method))return b;e.method="throw",e.arg=new TypeError("The iterator does not provide a 'throw' method")}return b}var i=y(n,t.iterator,e.arg);if("throw"===i.type)return e.method="throw",e.arg=i.arg,e.delegate=null,b;var o=i.arg;return o?o.done?(e[t.resultName]=o.value,e.next=t.nextLoc,"return"!==e.method&&(e.method="next",e.arg=r),e.delegate=null,b):o:(e.method="throw",e.arg=new TypeError("iterator result is not an object"),e.delegate=null,b)}function $(t){var e={tryLoc:t[0]};1 in t&&(e.catchLoc=t[1]),2 in t&&(e.finallyLoc=t[2],e.afterLoc=t[3]),this.tryEntries.push(e)}function R(t){var e=t.completion||{};e.type="normal",delete e.arg,t.completion=e}function P(t){this.tryEntries=[{tryLoc:"root"}],t.forEach($,this),this.reset(!0)}function S(t){if(t){var e=t[a];if(e)return e.call(t);if("function"===typeof t.next)return t;if(!isNaN(t.length)){var n=-1,o=function e(){while(++n<t.length)if(i.call(t,n))return e.value=t[n],e.done=!1,e;return e.value=r,e.done=!0,e};return o.next=o}}return{next:T}}function T(){return{value:r,done:!0}}}(function(){return this||"object"===typeof self&&self}()||Function("return this")())},b92c:function(t,e,r){var n=r("784e");"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var i=r("4f06").default;i("4ef0c90a",n,!0,{sourceMap:!1,shadowMode:!1})},cb4b:function(t,e,r){"use strict";r.r(e);var n=r("2842"),i=r("d211");for(var o in i)"default"!==o&&function(t){r.d(e,t,(function(){return i[t]}))}(o);r("24ec");var a,s=r("f0c5"),c=Object(s["a"])(i["default"],n["b"],n["c"],!1,null,"7b2f4342",null,!1,n["a"],a);e["default"]=c.exports},d211:function(t,e,r){"use strict";r.r(e);var n=r("1943"),i=r.n(n);for(var o in n)"default"!==o&&function(t){r.d(e,t,(function(){return n[t]}))}(o);e["default"]=i.a}}]);