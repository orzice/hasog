(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-signUp-apply_detail"],{"0ef4":function(t,e,n){var i=n("6093");"string"===typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);var r=n("4f06").default;r("bf1c576c",i,!0,{sourceMap:!1,shadowMode:!1})},"15c7":function(t,e,n){"use strict";var i=n("4ea4");n("99af"),n("c975"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0,n("96cf");var r=i(n("1da1")),a=i(n("c079")),o={data:function(){return{scrollTop:0,applyId:null,detail:{},isApply:!1,refresh:!1,signOk:{}}},onShow:function(){uni.getStorage({key:"version",success:function(t){document.title="".concat(document.title," - ").concat(JSON.parse(t.data).site.name)}})},onLoad:function(){this.applyId=this.$Route.query.applyId,this.getData(this.$Route.query.applyId)},onPageScroll:function(t){this.scrollTop=t.scrollTop},onNavigationBarButtonTap:function(t){var e=this,n=t.index;if(0===n){var i;uni.getStorage({key:"userInfo",success:function(t){i=t.data.user_info.id}});var r="".concat(this.$request.baseUrl,"/#/applyDetail/").concat(this.applyId,"?parent_id=").concat(i);(0,a.default)({content:r,success:function(t){e.$api.msg(t)},error:function(t){e.$api.msg(t,"none")}})}},watch:{refresh:function(t){t&&(this.refresh=!1,this.getData(this.applyId))}},methods:{copy:function(){var t,e=this;uni.getStorage({key:"userInfo",success:function(e){t=e.data.user_info.id}});var n="".concat(this.$request.baseUrl,"/#/applyDetail/").concat(this.applyId,"?parent_id=").concat(t);(0,a.default)({content:n,success:function(t){e.$api.msg(t)},error:function(t){e.$api.msg(t,"none")}})},getData:function(t){var e=this;return(0,r.default)(regeneratorRuntime.mark((function n(){var i;return regeneratorRuntime.wrap((function(n){while(1)switch(n.prev=n.next){case 0:return n.next=2,e.$request.get("/api/plugin.hasog_entry-index-index-getentrypage",{id:t});case 2:if(i=n.sent,-1==i.msg.indexOf("登录")){n.next=6;break}return uni.showModal({title:"温馨提示",content:i.msg,success:function(t){t.confirm?e.$Router.push({name:"Login"}):e.$Router.back(1)}}),n.abrupt("return");case 6:1==i.code?(e.detail=i.data,uni.setNavigationBarTitle({title:i.data.q_title}),1==i.data.b_state&&e.getSign(i.data.id)):e.$api.modal(i.msg);case 7:case"end":return n.stop()}}),n)})))()},goInfo:function(t){var e=this;return(0,r.default)(regeneratorRuntime.mark((function n(){return regeneratorRuntime.wrap((function(n){while(1)switch(n.prev=n.next){case 0:if(1!=t){n.next=3;break}return e.$Router.push({name:"ApplyInfo",params:{applyId:e.detail.id}}),n.abrupt("return");case 3:0==t&&e.signUp();case 4:case"end":return n.stop()}}),n)})))()},signUp:function(){var t=this;return(0,r.default)(regeneratorRuntime.mark((function e(){var n;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,t.$request.post("/api/plugin.hasog_entry-index-index-entryapply",{h_id:t.detail.id});case 2:if(n=e.sent,-1==n.msg.indexOf("登录")){e.next=6;break}return uni.showModal({title:"温馨提示",content:n.msg,success:function(e){e.confirm?t.$Router.push({name:"Login"}):t.$Router.back(1)}}),e.abrupt("return");case 6:1==n.code?(t.$api.msg(n.msg),setTimeout((function(){t.getData(t.applyId)}),1200)):t.$api.modal(n.msg);case 7:case"end":return e.stop()}}),e)})))()},getSign:function(t){var e=this;return(0,r.default)(regeneratorRuntime.mark((function n(){var i;return regeneratorRuntime.wrap((function(n){while(1)switch(n.prev=n.next){case 0:return n.next=2,e.$request.get("/api/plugin.hasog_entry-index-index-entrywin",{id:t});case 2:i=n.sent,1==i.code&&(e.signOk=i.data);case 4:case"end":return n.stop()}}),n)})))()},signIn:function(){var t=this;return(0,r.default)(regeneratorRuntime.mark((function e(){var n;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,t.$request.get("/api/plugin.hasog_entry-index-index-entrysign",{id:t.applyId});case 2:n=e.sent,1==n.code?(t.$api.msg(n.msg),setTimeout((function(){t.getData(t.applyId)}),1200)):t.$api.modal(n.msg);case 4:case"end":return e.stop()}}),e)})))()}}};e.default=o},"192c":function(t,e,n){"use strict";n.r(e);var i=n("891f"),r=n("7bb9");for(var a in r)"default"!==a&&function(t){n.d(e,t,(function(){return r[t]}))}(a);n("3f01");var o,s=n("f0c5"),c=Object(s["a"])(r["default"],i["b"],i["c"],!1,null,"17d8bbfa",null,!1,i["a"],o);e["default"]=c.exports},"1da1":function(t,e,n){"use strict";function i(t,e,n,i,r,a,o){try{var s=t[a](o),c=s.value}catch(u){return void n(u)}s.done?e(c):Promise.resolve(c).then(i,r)}function r(t){return function(){var e=this,n=arguments;return new Promise((function(r,a){var o=t.apply(e,n);function s(t){i(o,r,a,s,c,"next",t)}function c(t){i(o,r,a,s,c,"throw",t)}s(void 0)}))}}n("d3b7"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=r},"3f01":function(t,e,n){"use strict";var i=n("0ef4"),r=n.n(i);r.a},6093:function(t,e,n){var i=n("24fb");e=i(!1),e.push([t.i,'@charset "UTF-8";\n/* 页面左右间距 */\n/* 文字尺寸 */\n/*文字颜色*/\n/* 边框颜色 */\n/* 图片加载中颜色 */\n/* 行为相关颜色 */uni-page-body[data-v-17d8bbfa]{background:#f8f8f8}.container[data-v-17d8bbfa]{padding-bottom:%?160?%}.icon-you[data-v-17d8bbfa]{font-size:%?30?%;color:#888}.carousel[data-v-17d8bbfa]{height:%?600?%;position:relative}.carousel uni-swiper[data-v-17d8bbfa]{height:100%}.carousel .image-wrapper[data-v-17d8bbfa]{width:100%;height:100%}.carousel .swiper-item[data-v-17d8bbfa]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-align-content:center;align-content:center;height:%?750?%;overflow:hidden}.carousel .swiper-item uni-image[data-v-17d8bbfa]{width:100%;height:100%}\n/* 标题简介 */.introduce-section[data-v-17d8bbfa]{background:#fff;padding:%?20?% %?30?%}.introduce-section .title[data-v-17d8bbfa]{font-size:%?32?%;color:#303133;\n  /* height: 50upx; */line-height:%?50?%;white-space:pre-wrap;word-break:break-all;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;overflow:hidden}.introduce-section .desc[data-v-17d8bbfa]{color:#909399;font-size:%?28?%}.introduce-section .price-box[data-v-17d8bbfa]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:baseline;-webkit-align-items:baseline;align-items:baseline;height:%?64?%;padding:%?10?% 0;font-size:%?26?%;color:#fa436a}.introduce-section .price[data-v-17d8bbfa]{font-size:%?34?%}.introduce-section .m-price[data-v-17d8bbfa]{margin:0 %?12?%;color:#909399;text-decoration:line-through}.introduce-section .coupon-tip[data-v-17d8bbfa]{-webkit-box-align:center;-webkit-align-items:center;align-items:center;padding:%?6?% %?10?%;background-color:#fa436a;opacity:.8;font-size:%?24?%;color:#fff;border-radius:%?8?%;line-height:1;-webkit-transform:translateY(%?-4?%);transform:translateY(%?-4?%)}.introduce-section .bot-row[data-v-17d8bbfa]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;height:%?50?%;font-size:%?24?%;color:#909399}.introduce-section .bot-row uni-text[data-v-17d8bbfa]{-webkit-box-flex:1;-webkit-flex:1;flex:1}\n/*  详情 */.detail-desc[data-v-17d8bbfa]{background:#fff;margin-top:%?16?%;padding:0 %?20?% %?20?%}.detail-desc .d-header[data-v-17d8bbfa]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;align-items:center;height:%?80?%;font-size:%?30?%;color:#303133;position:relative}.detail-desc .d-header uni-text[data-v-17d8bbfa]{padding:0 %?20?%;background:#fff;position:relative;z-index:1}.detail-desc .d-header[data-v-17d8bbfa]:after{position:absolute;left:50%;top:50%;-webkit-transform:translateX(-50%);transform:translateX(-50%);width:%?300?%;height:0;content:"";border-bottom:1px solid #ccc}.detail-desc .sign[data-v-17d8bbfa]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;padding-bottom:%?20?%}.detail-desc .sign uni-image[data-v-17d8bbfa]{width:%?120?%;height:%?120?%}.detail-desc .sign .right[data-v-17d8bbfa]{-webkit-box-flex:1;-webkit-flex:1;flex:1;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between;margin-left:%?16?%;font-size:%?28?%}.detail-desc .sign .right .time[data-v-17d8bbfa]{color:#fa436a}.detail-desc .desc[data-v-17d8bbfa] table{width:100%!important}.detail-desc .desc[data-v-17d8bbfa] img{width:100%!important;height:100%!important}\n/* 底部操作菜单 */.page-bottom[data-v-17d8bbfa]{position:fixed;left:%?30?%;bottom:%?30?%;z-index:95;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;align-items:center;width:%?690?%;height:%?100?%;\n  /* background: rgba(255,255,255,.9);\n\tbox-shadow: 0 0 20upx 0 rgba(0,0,0,.5); */border-radius:%?16?%}.action-btn-group[data-v-17d8bbfa]{width:100%;height:%?76?%;border-radius:100px;overflow:hidden;box-shadow:0 %?20?% %?40?% %?-16?% #fa436a;box-shadow:1px 2px 5px rgba(219,63,96,.4);background:-webkit-linear-gradient(left,#ffac30,#fa436a,#f56c6c);background:linear-gradient(90deg,#ffac30,#fa436a,#f56c6c);position:relative}.action-btn-group .action-btn[data-v-17d8bbfa]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;width:100%;height:100%;font-size:%?28?%;padding:0;border-radius:0;background:transparent}.action-btn-group .is[data-v-17d8bbfa]{color:#fff;background-color:#c0c4cc;box-shadow:1px 2px 5px rgba(219,63,96,.1)}body.?%PAGE?%[data-v-17d8bbfa]{background:#f8f8f8}',""]),t.exports=e},"7bb9":function(t,e,n){"use strict";n.r(e);var i=n("15c7"),r=n.n(i);for(var a in i)"default"!==a&&function(t){n.d(e,t,(function(){return i[t]}))}(a);e["default"]=r.a},"891f":function(t,e,n){"use strict";var i;n.d(e,"b",(function(){return r})),n.d(e,"c",(function(){return a})),n.d(e,"a",(function(){return i}));var r=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("v-uni-view",{staticClass:"container"},[n("nav-bar",{attrs:{type:"transparentFixed",transparentFixedFontColor:"rgba(0,0,0,0)",scrollTop:t.scrollTop,title:t.detail.q_title}},[n("v-uni-view",{staticClass:"nav-icon",attrs:{slot:"right"},slot:"right"},[n("v-uni-text",{staticClass:"yticon icon-fenxiang2",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.copy()}}})],1),n("v-uni-view",{staticClass:"nav-icon",attrs:{slot:"transparentFixedRight"},slot:"transparentFixedRight"},[n("v-uni-text",{staticClass:"yticon icon-fenxiang2",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.copy()}}})],1)],1),n("v-uni-view",{staticClass:"carousel"},[n("v-uni-swiper",{attrs:{"indicator-dots":!0,circular:"true",duration:"400"}},[n("v-uni-swiper-item",{staticClass:"swiper-item"},[n("v-uni-view",{staticClass:"image-wrapper"},[n("v-uni-image",{staticClass:"loaded",attrs:{src:t.detail.q_thumb,mode:"aspectFill"}})],1)],1)],1)],1),n("v-uni-view",{staticClass:"introduce-section"},[n("v-uni-text",{staticClass:"title"},[t._v(t._s(t.detail.q_title))]),n("v-uni-text",{staticClass:"desc"},[t._v(t._s(t.detail.q_intr))]),n("v-uni-view",{staticClass:"price-box"},[n("v-uni-text",{staticClass:"price-tip"},[t._v("¥")]),n("v-uni-text",{staticClass:"price"},[t._v(t._s(t.detail.price))])],1)],1),1==t.detail.b_state?n("v-uni-view",{staticClass:"detail-desc"},[n("v-uni-view",{staticClass:"d-header",staticStyle:{"font-size":"32upx"}},[n("v-uni-text",[t._v("预约时间")])],1),n("v-uni-view",{staticClass:"sign"},[n("v-uni-image",{attrs:{src:t.signOk.h_thumb,mode:""}}),n("v-uni-view",{staticClass:"right"},[n("v-uni-text",{staticClass:"address"},[t._v(t._s(t.signOk.h_site))]),n("v-uni-text",{staticClass:"time"},[t._v(t._s(t.signOk.h_time))])],1)],1),n("v-uni-view",{staticClass:"action-btn-group"},[0==t.signOk.b_state?n("v-uni-button",{staticClass:" action-btn no-border",attrs:{type:"primary",disabled:t.isApply},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.signIn.apply(void 0,arguments)}}},[t._v("立即签到")]):t._e(),1==t.signOk.b_state?n("v-uni-button",{staticClass:" action-btn no-border is",attrs:{type:"primary",disabled:!0}},[t._v("已签到")]):t._e()],1)],1):t._e(),n("v-uni-view",{staticClass:"detail-desc"},[n("v-uni-view",{staticClass:"d-header"},[n("v-uni-text",[t._v("介绍")])],1),n("v-uni-rich-text",{staticClass:"desc",attrs:{nodes:t.detail.q_data}})],1),n("v-uni-view",{staticClass:"page-bottom"},[0==t.detail.b_state?n("v-uni-view",{staticClass:"action-btn-group"},[n("v-uni-button",{staticClass:" action-btn no-border",attrs:{type:"primary",disabled:t.isApply},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.goInfo(t.detail.s_state)}}},[t._v("立即报名")])],1):t._e()],1)],1)},a=[]},"96cf":function(t,e){!function(e){"use strict";var n,i=Object.prototype,r=i.hasOwnProperty,a="function"===typeof Symbol?Symbol:{},o=a.iterator||"@@iterator",s=a.asyncIterator||"@@asyncIterator",c=a.toStringTag||"@@toStringTag",u="object"===typeof t,l=e.regeneratorRuntime;if(l)u&&(t.exports=l);else{l=e.regeneratorRuntime=u?t.exports:{},l.wrap=m;var d="suspendedStart",f="suspendedYield",p="executing",h="completed",b={},g={};g[o]=function(){return this};var v=Object.getPrototypeOf,y=v&&v(v(S([])));y&&y!==i&&r.call(y,o)&&(g=y);var w=C.prototype=k.prototype=Object.create(g);_.prototype=w.constructor=C,C.constructor=_,C[c]=_.displayName="GeneratorFunction",l.isGeneratorFunction=function(t){var e="function"===typeof t&&t.constructor;return!!e&&(e===_||"GeneratorFunction"===(e.displayName||e.name))},l.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,C):(t.__proto__=C,c in t||(t[c]="GeneratorFunction")),t.prototype=Object.create(w),t},l.awrap=function(t){return{__await:t}},L(E.prototype),E.prototype[s]=function(){return this},l.AsyncIterator=E,l.async=function(t,e,n,i){var r=new E(m(t,e,n,i));return l.isGeneratorFunction(e)?r:r.next().then((function(t){return t.done?t.value:r.next()}))},L(w),w[c]="Generator",w[o]=function(){return this},w.toString=function(){return"[object Generator]"},l.keys=function(t){var e=[];for(var n in t)e.push(n);return e.reverse(),function n(){while(e.length){var i=e.pop();if(i in t)return n.value=i,n.done=!1,n}return n.done=!0,n}},l.values=S,I.prototype={constructor:I,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=n,this.done=!1,this.delegate=null,this.method="next",this.arg=n,this.tryEntries.forEach(R),!t)for(var e in this)"t"===e.charAt(0)&&r.call(this,e)&&!isNaN(+e.slice(1))&&(this[e]=n)},stop:function(){this.done=!0;var t=this.tryEntries[0],e=t.completion;if("throw"===e.type)throw e.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var e=this;function i(i,r){return s.type="throw",s.arg=t,e.next=i,r&&(e.method="next",e.arg=n),!!r}for(var a=this.tryEntries.length-1;a>=0;--a){var o=this.tryEntries[a],s=o.completion;if("root"===o.tryLoc)return i("end");if(o.tryLoc<=this.prev){var c=r.call(o,"catchLoc"),u=r.call(o,"finallyLoc");if(c&&u){if(this.prev<o.catchLoc)return i(o.catchLoc,!0);if(this.prev<o.finallyLoc)return i(o.finallyLoc)}else if(c){if(this.prev<o.catchLoc)return i(o.catchLoc,!0)}else{if(!u)throw new Error("try statement without catch or finally");if(this.prev<o.finallyLoc)return i(o.finallyLoc)}}}},abrupt:function(t,e){for(var n=this.tryEntries.length-1;n>=0;--n){var i=this.tryEntries[n];if(i.tryLoc<=this.prev&&r.call(i,"finallyLoc")&&this.prev<i.finallyLoc){var a=i;break}}a&&("break"===t||"continue"===t)&&a.tryLoc<=e&&e<=a.finallyLoc&&(a=null);var o=a?a.completion:{};return o.type=t,o.arg=e,a?(this.method="next",this.next=a.finallyLoc,b):this.complete(o)},complete:function(t,e){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&e&&(this.next=e),b},finish:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var n=this.tryEntries[e];if(n.finallyLoc===t)return this.complete(n.completion,n.afterLoc),R(n),b}},catch:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var n=this.tryEntries[e];if(n.tryLoc===t){var i=n.completion;if("throw"===i.type){var r=i.arg;R(n)}return r}}throw new Error("illegal catch attempt")},delegateYield:function(t,e,i){return this.delegate={iterator:S(t),resultName:e,nextLoc:i},"next"===this.method&&(this.arg=n),b}}}function m(t,e,n,i){var r=e&&e.prototype instanceof k?e:k,a=Object.create(r.prototype),o=new I(i||[]);return a._invoke=j(t,n,o),a}function x(t,e,n){try{return{type:"normal",arg:t.call(e,n)}}catch(i){return{type:"throw",arg:i}}}function k(){}function _(){}function C(){}function L(t){["next","throw","return"].forEach((function(e){t[e]=function(t){return this._invoke(e,t)}}))}function E(t){function e(n,i,a,o){var s=x(t[n],t,i);if("throw"!==s.type){var c=s.arg,u=c.value;return u&&"object"===typeof u&&r.call(u,"__await")?Promise.resolve(u.__await).then((function(t){e("next",t,a,o)}),(function(t){e("throw",t,a,o)})):Promise.resolve(u).then((function(t){c.value=t,a(c)}),(function(t){return e("throw",t,a,o)}))}o(s.arg)}var n;function i(t,i){function r(){return new Promise((function(n,r){e(t,i,n,r)}))}return n=n?n.then(r,r):r()}this._invoke=i}function j(t,e,n){var i=d;return function(r,a){if(i===p)throw new Error("Generator is already running");if(i===h){if("throw"===r)throw a;return q()}n.method=r,n.arg=a;while(1){var o=n.delegate;if(o){var s=O(o,n);if(s){if(s===b)continue;return s}}if("next"===n.method)n.sent=n._sent=n.arg;else if("throw"===n.method){if(i===d)throw i=h,n.arg;n.dispatchException(n.arg)}else"return"===n.method&&n.abrupt("return",n.arg);i=p;var c=x(t,e,n);if("normal"===c.type){if(i=n.done?h:f,c.arg===b)continue;return{value:c.arg,done:n.done}}"throw"===c.type&&(i=h,n.method="throw",n.arg=c.arg)}}}function O(t,e){var i=t.iterator[e.method];if(i===n){if(e.delegate=null,"throw"===e.method){if(t.iterator.return&&(e.method="return",e.arg=n,O(t,e),"throw"===e.method))return b;e.method="throw",e.arg=new TypeError("The iterator does not provide a 'throw' method")}return b}var r=x(i,t.iterator,e.arg);if("throw"===r.type)return e.method="throw",e.arg=r.arg,e.delegate=null,b;var a=r.arg;return a?a.done?(e[t.resultName]=a.value,e.next=t.nextLoc,"return"!==e.method&&(e.method="next",e.arg=n),e.delegate=null,b):a:(e.method="throw",e.arg=new TypeError("iterator result is not an object"),e.delegate=null,b)}function $(t){var e={tryLoc:t[0]};1 in t&&(e.catchLoc=t[1]),2 in t&&(e.finallyLoc=t[2],e.afterLoc=t[3]),this.tryEntries.push(e)}function R(t){var e=t.completion||{};e.type="normal",delete e.arg,t.completion=e}function I(t){this.tryEntries=[{tryLoc:"root"}],t.forEach($,this),this.reset(!0)}function S(t){if(t){var e=t[o];if(e)return e.call(t);if("function"===typeof t.next)return t;if(!isNaN(t.length)){var i=-1,a=function e(){while(++i<t.length)if(r.call(t,i))return e.value=t[i],e.done=!1,e;return e.value=n,e.done=!0,e};return a.next=a}}return{next:q}}function q(){return{value:n,done:!0}}}(function(){return this||"object"===typeof self&&self}()||Function("return this")())},c079:function(t,e,n){"use strict";function i(t){var e=t.content,n=t.success,i=t.error;if(!e)return i("复制的内容不能为空 !");e="string"===typeof e?e:e.toString(),document.queryCommandSupported("copy")||i("浏览器不支持");var r=document.createElement("textarea");r.value=e,r.readOnly="readOnly",document.body.appendChild(r),r.select(),r.setSelectionRange(0,e.length);var a=document.execCommand("copy");a?n("复制成功~"):i("复制失败，请检查h5中调用该方法的方式，是不是用户点击的方式调用的，如果不是请改为用户点击的方式触发该方法，因为h5中安全性，不能js直接调用！"),r.remove()}n("d3b7"),n("25f0"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=i}}]);