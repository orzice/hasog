(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-paotui-get_task"],{"0920":function(t,e,i){"use strict";i.r(e);var n=i("5e38"),r=i("d920");for(var o in r)"default"!==o&&function(t){i.d(e,t,(function(){return r[t]}))}(o);i("d998");var a,s=i("f0c5"),l=Object(s["a"])(r["default"],n["b"],n["c"],!1,null,"060b7eff",null,!1,n["a"],a);e["default"]=l.exports},"1da1":function(t,e,i){"use strict";function n(t,e,i,n,r,o,a){try{var s=t[o](a),l=s.value}catch(f){return void i(f)}s.done?e(l):Promise.resolve(l).then(n,r)}function r(t){return function(){var e=this,i=arguments;return new Promise((function(r,o){var a=t.apply(e,i);function s(t){n(a,r,o,s,l,"next",t)}function l(t){n(a,r,o,s,l,"throw",t)}s(void 0)}))}}i("d3b7"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=r},"5e38":function(t,e,i){"use strict";var n;i.d(e,"b",(function(){return r})),i.d(e,"c",(function(){return o})),i.d(e,"a",(function(){return n}));var r=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",[i("nav-bar",{attrs:{title:"任务大厅"}},[i("v-uni-view",{staticClass:"nav-icon",attrs:{slot:"right"},slot:"right"},[i("v-uni-text",{staticClass:"iconfont icon-order-list",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.navTo("RunOrder")}}})],1)],1),t._l(t.list,(function(e,n){return i("v-uni-view",{key:n,staticClass:"order-item",on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.toDetail(e.id)}}},[i("v-uni-view",{staticClass:"i-top b-b"},[i("v-uni-text",{staticClass:"time"},[t._v(t._s(e.type))]),i("v-uni-text",{staticClass:"state"},[t._v(t._s(e.money))])],1),i("v-uni-view",{staticClass:"goods-box-single"},[t._v(t._s(e.s_type)+": 小于"+t._s(e.weight)+"公斤")]),i("v-uni-view",{staticClass:"price-box"},[t._v(t._s(e.create_time))]),i("v-uni-view",{staticClass:"action-box b-t"},[i("v-uni-button",{staticClass:"action-btn recom",on:{click:function(i){i.stopPropagation(),arguments[0]=i=t.$handleEvent(i),t.take(e.id)}}},[t._v("确认接单")])],1)],1)})),t.isMore?t._e():i("v-uni-view",{staticClass:"noMore"},[t._v("没有更多任务了")]),i("back-top",{attrs:{scrollTop:t.scrollTop}})],2)},o=[]},6183:function(t,e,i){"use strict";var n=i("4ea4");i("99af"),i("c975"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var r=n(i("2909"));i("96cf");var o=n(i("1da1")),a={data:function(){return{list:[],order_type:null,item_type:null,refresh:!1,scrollTop:0,page:0,isMore:!0}},onLoad:function(){this.page=0,this.getTask()},onShow:function(){uni.getStorage({key:"version",success:function(t){document.title="".concat(document.title," - ").concat(JSON.parse(t.data).site.name)}})},onPageScroll:function(t){this.scrollTop=t.scrollTop},onReachBottom:function(){this.isMore&&(this.page++,this.getTask())},watch:{refresh:function(t){t&&(this.refresh=!1,this.page=0,this.getTask())}},methods:{navTo:function(t){this.$Router.push({name:t})},getTask:function(){var t=this;return(0,o.default)(regeneratorRuntime.mark((function e(){var i;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,t.$request.post("/api/plugin.hasog_paotui-index-index-renwu",{page:t.page});case 2:if(i=e.sent,!i.url||-1==i.url.indexOf("login")){e.next=6;break}return uni.showModal({title:"温馨提示",content:i.msg,success:function(e){e.confirm?t.$Router.push({name:"Login"}):t.$Router.back(1)}}),e.abrupt("return");case 6:if(0!=i.data.length){e.next=9;break}return t.isMore=!1,e.abrupt("return");case 9:1==i.code?t.list=[].concat((0,r.default)(t.list),(0,r.default)(i.data)):uni.showModal({title:"温馨提示",content:i.msg,showCancel:!1,success:function(){t.$Router.back(1)}});case 10:case"end":return e.stop()}}),e)})))()},toDetail:function(t){this.$Router.push({name:"TaskDetail",params:{id:t,isRun:!0}})},take:function(t){var e=this;return(0,o.default)(regeneratorRuntime.mark((function i(){var n;return regeneratorRuntime.wrap((function(i){while(1)switch(i.prev=i.next){case 0:return i.next=2,e.$request.post("/api/plugin.hasog_paotui-index-index-jierenwu",{id:t});case 2:if(n=i.sent,!n.url||-1==n.url.indexOf("login")){i.next=6;break}return uni.showModal({title:"温馨提示",content:n.msg,success:function(t){t.confirm?e.$Router.push({name:"Login"}):e.$Router.back(1)}}),i.abrupt("return");case 6:1==n.code?(e.$api.msg(n.msg),setTimeout((function(){e.getTask(),e.$Router.push({name:"RunOrder"})}),1500)):e.$api.modal(n.msg);case 7:case"end":return i.stop()}}),i)})))()}}};e.default=a},"96cf":function(t,e){!function(e){"use strict";var i,n=Object.prototype,r=n.hasOwnProperty,o="function"===typeof Symbol?Symbol:{},a=o.iterator||"@@iterator",s=o.asyncIterator||"@@asyncIterator",l=o.toStringTag||"@@toStringTag",f="object"===typeof t,d=e.regeneratorRuntime;if(d)f&&(t.exports=d);else{d=e.regeneratorRuntime=f?t.exports:{},d.wrap=x;var c="suspendedStart",u="suspendedYield",b="executing",h="completed",p={},g={};g[a]=function(){return this};var v=Object.getPrototypeOf,m=v&&v(v(P([])));m&&m!==n&&r.call(m,a)&&(g=m);var w=L.prototype=k.prototype=Object.create(g);_.prototype=w.constructor=L,L.constructor=_,L[l]=_.displayName="GeneratorFunction",d.isGeneratorFunction=function(t){var e="function"===typeof t&&t.constructor;return!!e&&(e===_||"GeneratorFunction"===(e.displayName||e.name))},d.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,L):(t.__proto__=L,l in t||(t[l]="GeneratorFunction")),t.prototype=Object.create(w),t},d.awrap=function(t){return{__await:t}},j(E.prototype),E.prototype[s]=function(){return this},d.AsyncIterator=E,d.async=function(t,e,i,n){var r=new E(x(t,e,i,n));return d.isGeneratorFunction(e)?r:r.next().then((function(t){return t.done?t.value:r.next()}))},j(w),w[l]="Generator",w[a]=function(){return this},w.toString=function(){return"[object Generator]"},d.keys=function(t){var e=[];for(var i in t)e.push(i);return e.reverse(),function i(){while(e.length){var n=e.pop();if(n in t)return i.value=n,i.done=!1,i}return i.done=!0,i}},d.values=P,$.prototype={constructor:$,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=i,this.done=!1,this.delegate=null,this.method="next",this.arg=i,this.tryEntries.forEach(z),!t)for(var e in this)"t"===e.charAt(0)&&r.call(this,e)&&!isNaN(+e.slice(1))&&(this[e]=i)},stop:function(){this.done=!0;var t=this.tryEntries[0],e=t.completion;if("throw"===e.type)throw e.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var e=this;function n(n,r){return s.type="throw",s.arg=t,e.next=n,r&&(e.method="next",e.arg=i),!!r}for(var o=this.tryEntries.length-1;o>=0;--o){var a=this.tryEntries[o],s=a.completion;if("root"===a.tryLoc)return n("end");if(a.tryLoc<=this.prev){var l=r.call(a,"catchLoc"),f=r.call(a,"finallyLoc");if(l&&f){if(this.prev<a.catchLoc)return n(a.catchLoc,!0);if(this.prev<a.finallyLoc)return n(a.finallyLoc)}else if(l){if(this.prev<a.catchLoc)return n(a.catchLoc,!0)}else{if(!f)throw new Error("try statement without catch or finally");if(this.prev<a.finallyLoc)return n(a.finallyLoc)}}}},abrupt:function(t,e){for(var i=this.tryEntries.length-1;i>=0;--i){var n=this.tryEntries[i];if(n.tryLoc<=this.prev&&r.call(n,"finallyLoc")&&this.prev<n.finallyLoc){var o=n;break}}o&&("break"===t||"continue"===t)&&o.tryLoc<=e&&e<=o.finallyLoc&&(o=null);var a=o?o.completion:{};return a.type=t,a.arg=e,o?(this.method="next",this.next=o.finallyLoc,p):this.complete(a)},complete:function(t,e){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&e&&(this.next=e),p},finish:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var i=this.tryEntries[e];if(i.finallyLoc===t)return this.complete(i.completion,i.afterLoc),z(i),p}},catch:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var i=this.tryEntries[e];if(i.tryLoc===t){var n=i.completion;if("throw"===n.type){var r=n.arg;z(i)}return r}}throw new Error("illegal catch attempt")},delegateYield:function(t,e,n){return this.delegate={iterator:P(t),resultName:e,nextLoc:n},"next"===this.method&&(this.arg=i),p}}}function x(t,e,i,n){var r=e&&e.prototype instanceof k?e:k,o=Object.create(r.prototype),a=new $(n||[]);return o._invoke=R(t,i,a),o}function y(t,e,i){try{return{type:"normal",arg:t.call(e,i)}}catch(n){return{type:"throw",arg:n}}}function k(){}function _(){}function L(){}function j(t){["next","throw","return"].forEach((function(e){t[e]=function(t){return this._invoke(e,t)}}))}function E(t){function e(i,n,o,a){var s=y(t[i],t,n);if("throw"!==s.type){var l=s.arg,f=l.value;return f&&"object"===typeof f&&r.call(f,"__await")?Promise.resolve(f.__await).then((function(t){e("next",t,o,a)}),(function(t){e("throw",t,o,a)})):Promise.resolve(f).then((function(t){l.value=t,o(l)}),(function(t){return e("throw",t,o,a)}))}a(s.arg)}var i;function n(t,n){function r(){return new Promise((function(i,r){e(t,n,i,r)}))}return i=i?i.then(r,r):r()}this._invoke=n}function R(t,e,i){var n=c;return function(r,o){if(n===b)throw new Error("Generator is already running");if(n===h){if("throw"===r)throw o;return C()}i.method=r,i.arg=o;while(1){var a=i.delegate;if(a){var s=T(a,i);if(s){if(s===p)continue;return s}}if("next"===i.method)i.sent=i._sent=i.arg;else if("throw"===i.method){if(n===c)throw n=h,i.arg;i.dispatchException(i.arg)}else"return"===i.method&&i.abrupt("return",i.arg);n=b;var l=y(t,e,i);if("normal"===l.type){if(n=i.done?h:u,l.arg===p)continue;return{value:l.arg,done:i.done}}"throw"===l.type&&(n=h,i.method="throw",i.arg=l.arg)}}}function T(t,e){var n=t.iterator[e.method];if(n===i){if(e.delegate=null,"throw"===e.method){if(t.iterator.return&&(e.method="return",e.arg=i,T(t,e),"throw"===e.method))return p;e.method="throw",e.arg=new TypeError("The iterator does not provide a 'throw' method")}return p}var r=y(n,t.iterator,e.arg);if("throw"===r.type)return e.method="throw",e.arg=r.arg,e.delegate=null,p;var o=r.arg;return o?o.done?(e[t.resultName]=o.value,e.next=t.nextLoc,"return"!==e.method&&(e.method="next",e.arg=i),e.delegate=null,p):o:(e.method="throw",e.arg=new TypeError("iterator result is not an object"),e.delegate=null,p)}function O(t){var e={tryLoc:t[0]};1 in t&&(e.catchLoc=t[1]),2 in t&&(e.finallyLoc=t[2],e.afterLoc=t[3]),this.tryEntries.push(e)}function z(t){var e=t.completion||{};e.type="normal",delete e.arg,t.completion=e}function $(t){this.tryEntries=[{tryLoc:"root"}],t.forEach(O,this),this.reset(!0)}function P(t){if(t){var e=t[a];if(e)return e.call(t);if("function"===typeof t.next)return t;if(!isNaN(t.length)){var n=-1,o=function e(){while(++n<t.length)if(r.call(t,n))return e.value=t[n],e.done=!1,e;return e.value=i,e.done=!0,e};return o.next=o}}return{next:C}}function C(){return{value:i,done:!0}}}(function(){return this||"object"===typeof self&&self}()||Function("return this")())},a216:function(t,e,i){var n=i("24fb");e=n(!1),e.push([t.i,'@charset "UTF-8";\n/* 页面左右间距 */\n/* 文字尺寸 */\n/*文字颜色*/\n/* 边框颜色 */\n/* 图片加载中颜色 */\n/* 行为相关颜色 */.navbar[data-v-060b7eff]{display:-webkit-box;display:-webkit-flex;display:flex;height:40px;padding:0 5px;background:#fff;-webkit-box-shadow:0 1px 5px rgba(0,0,0,.06);box-shadow:0 1px 5px rgba(0,0,0,.06);position:relative;z-index:10}.navbar .nav-item[data-v-060b7eff]{-webkit-box-flex:1;-webkit-flex:1;flex:1;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;align-items:center;height:100%;font-size:15px;color:#303133;position:relative}.navbar .nav-item.current[data-v-060b7eff]{color:#fa436a}.navbar .nav-item.current[data-v-060b7eff]:after{content:"";position:absolute;left:50%;bottom:0;-webkit-transform:translateX(-50%);transform:translateX(-50%);width:44px;height:0;border-bottom:2px solid #fa436a}.order-item[data-v-060b7eff]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;padding-left:%?30?%;background:#fff;margin-top:%?16?%\n  /* 多条商品 */\n  /* 单条商品 */}.order-item .i-top[data-v-060b7eff]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;height:%?80?%;padding-right:%?30?%;font-size:%?28?%;color:#303133;position:relative}.order-item .i-top .time[data-v-060b7eff]{-webkit-box-flex:1;-webkit-flex:1;flex:1}.order-item .i-top .state[data-v-060b7eff]{color:#fa436a}.order-item .i-top .del-btn[data-v-060b7eff]{padding:%?10?% 0 %?10?% %?36?%;font-size:%?32?%;color:#909399;position:relative}.order-item .i-top .del-btn[data-v-060b7eff]:after{content:"";width:0;height:%?30?%;border-left:1px solid #dcdfe6;position:absolute;left:%?20?%;top:50%;-webkit-transform:translateY(-50%);transform:translateY(-50%)}.order-item .goods-box[data-v-060b7eff]{height:%?160?%;padding:%?20?% 0;white-space:nowrap}.order-item .goods-box .goods-item[data-v-060b7eff]{width:%?120?%;height:%?120?%;display:inline-block;margin-right:%?24?%}.order-item .goods-box .goods-img[data-v-060b7eff]{display:block;width:100%;height:100%}.order-item .goods-box-single[data-v-060b7eff]{display:-webkit-box;display:-webkit-flex;display:flex;padding:%?20?% 0}.order-item .goods-box-single .goods-img[data-v-060b7eff]{display:block;width:%?160?%;height:%?160?%}.order-item .goods-box-single .right[data-v-060b7eff]{-webkit-box-flex:1;-webkit-flex:1;flex:1;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between;padding:0 %?30?% 0 %?24?%;overflow:hidden}.order-item .goods-box-single .right .middle[data-v-060b7eff]{margin-right:%?10?%}.order-item .goods-box-single .right .middle .title[data-v-060b7eff]{font-size:%?30?%;color:#303133;line-height:%?40?%;white-space:pre-wrap;word-break:break-all;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;overflow:hidden}.order-item .goods-box-single .right .middle .spec[data-v-060b7eff]{padding:%?10?% 0;font-size:%?26?%;color:#909399}.order-item .goods-box-single .right .middle .spec uni-text[data-v-060b7eff]{margin-right:%?10?%}.order-item .goods-box-single .right .rRight[data-v-060b7eff]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;-webkit-box-align:end;-webkit-align-items:flex-end;align-items:flex-end}.order-item .goods-box-single .right .rRight .attr-box[data-v-060b7eff]{text-align:right;font-size:%?26?%;color:#909399;padding:%?10?% 0}.order-item .goods-box-single .right .rRight .price[data-v-060b7eff]{text-align:right;font-size:%?30?%;color:#303133}.order-item .goods-box-single .right .rRight .price[data-v-060b7eff]:before{content:"￥";font-size:%?24?%;margin:0 %?2?% 0 %?8?%}.order-item .price-box[data-v-060b7eff]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:end;-webkit-justify-content:flex-end;justify-content:flex-end;-webkit-box-align:baseline;-webkit-align-items:baseline;align-items:baseline;padding:%?20?% %?30?%;font-size:%?26?%;color:#909399}.order-item .price-box .num[data-v-060b7eff]{margin:0 %?8?%;color:#303133}.order-item .price-box .price[data-v-060b7eff]{font-size:%?32?%;color:#fa436a}.order-item .price-box .price[data-v-060b7eff]:before{content:"￥";font-size:%?24?%;margin:0 %?2?% 0 %?8?%}.order-item .action-box[data-v-060b7eff]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:end;-webkit-justify-content:flex-end;justify-content:flex-end;-webkit-box-align:center;-webkit-align-items:center;align-items:center;position:relative;padding-right:%?30?%}.order-item .action-btn[data-v-060b7eff]{width:%?160?%;height:%?60?%;margin:%?20?% 0;margin-left:%?24?%;padding:0;text-align:center;line-height:%?60?%;font-size:%?26?%;color:#303133;background:#fff;-webkit-border-radius:100px;border-radius:100px}.order-item .action-btn[data-v-060b7eff]:after{-webkit-border-radius:100px;border-radius:100px}.order-item .action-btn.recom[data-v-060b7eff]{background:#fff9f9;color:#fa436a}.order-item .action-btn.recom[data-v-060b7eff]:after{border-color:#f7bcc8}\n/* load-more */.uni-load-more[data-v-060b7eff]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;flex-direction:row;height:%?80?%;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center}.uni-load-more__text[data-v-060b7eff]{font-size:%?28?%;color:#999}.uni-load-more__img[data-v-060b7eff]{height:24px;width:24px;margin-right:10px}.uni-load-more__img > uni-view[data-v-060b7eff]{position:absolute}.uni-load-more__img > uni-view uni-view[data-v-060b7eff]{width:6px;height:2px;-webkit-border-top-left-radius:1px;border-top-left-radius:1px;-webkit-border-bottom-left-radius:1px;border-bottom-left-radius:1px;background:#999;position:absolute;opacity:.2;-webkit-transform-origin:50%;transform-origin:50%;-webkit-animation:load-data-v-060b7eff 1.56s ease infinite;animation:load-data-v-060b7eff 1.56s ease infinite}.uni-load-more__img > uni-view uni-view[data-v-060b7eff]:nth-child(1){-webkit-transform:rotate(90deg);transform:rotate(90deg);top:2px;left:9px}.uni-load-more__img > uni-view uni-view[data-v-060b7eff]:nth-child(2){-webkit-transform:rotate(180deg);transform:rotate(180deg);top:11px;right:0}.uni-load-more__img > uni-view uni-view[data-v-060b7eff]:nth-child(3){-webkit-transform:rotate(270deg);transform:rotate(270deg);bottom:2px;left:9px}.uni-load-more__img > uni-view uni-view[data-v-060b7eff]:nth-child(4){top:11px;left:0}.load1[data-v-060b7eff],\n.load2[data-v-060b7eff],\n.load3[data-v-060b7eff]{height:24px;width:24px}.load2[data-v-060b7eff]{-webkit-transform:rotate(30deg);transform:rotate(30deg)}.load3[data-v-060b7eff]{-webkit-transform:rotate(60deg);transform:rotate(60deg)}.load1 uni-view[data-v-060b7eff]:nth-child(1){-webkit-animation-delay:0s;animation-delay:0s}.load2 uni-view[data-v-060b7eff]:nth-child(1){-webkit-animation-delay:.13s;animation-delay:.13s}.load3 uni-view[data-v-060b7eff]:nth-child(1){-webkit-animation-delay:.26s;animation-delay:.26s}.load1 uni-view[data-v-060b7eff]:nth-child(2){-webkit-animation-delay:.39s;animation-delay:.39s}.load2 uni-view[data-v-060b7eff]:nth-child(2){-webkit-animation-delay:.52s;animation-delay:.52s}.load3 uni-view[data-v-060b7eff]:nth-child(2){-webkit-animation-delay:.65s;animation-delay:.65s}.load1 uni-view[data-v-060b7eff]:nth-child(3){-webkit-animation-delay:.78s;animation-delay:.78s}.load2 uni-view[data-v-060b7eff]:nth-child(3){-webkit-animation-delay:.91s;animation-delay:.91s}.load3 uni-view[data-v-060b7eff]:nth-child(3){-webkit-animation-delay:1.04s;animation-delay:1.04s}.load1 uni-view[data-v-060b7eff]:nth-child(4){-webkit-animation-delay:1.17s;animation-delay:1.17s}.load2 uni-view[data-v-060b7eff]:nth-child(4){-webkit-animation-delay:1.3s;animation-delay:1.3s}.load3 uni-view[data-v-060b7eff]:nth-child(4){-webkit-animation-delay:1.43s;animation-delay:1.43s}@-webkit-keyframes load-data-v-060b7eff{0%{opacity:1}100%{opacity:.2}}.nav-icon .iconfont[data-v-060b7eff]{font-size:%?28?%}.order-item .state[data-v-060b7eff]{font-size:%?32?%}.order-item .state[data-v-060b7eff]::before{content:"￥";font-size:%?28?%}',""]),t.exports=e},ad21:function(t,e,i){var n=i("a216");"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var r=i("4f06").default;r("2d26b4a2",n,!0,{sourceMap:!1,shadowMode:!1})},d920:function(t,e,i){"use strict";i.r(e);var n=i("6183"),r=i.n(n);for(var o in n)"default"!==o&&function(t){i.d(e,t,(function(){return n[t]}))}(o);e["default"]=r.a},d998:function(t,e,i){"use strict";var n=i("ad21"),r=i.n(n);r.a}}]);