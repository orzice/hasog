(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-spell-spell_group"],{"08d7":function(t,e,a){"use strict";var n=a("3143"),i=a.n(n);i.a},"1da1":function(t,e,a){"use strict";function n(t,e,a,n,i,r,o){try{var s=t[r](o),c=s.value}catch(u){return void a(u)}s.done?e(c):Promise.resolve(c).then(n,i)}function i(t){return function(){var e=this,a=arguments;return new Promise((function(i,r){var o=t.apply(e,a);function s(t){n(o,i,r,s,c,"next",t)}function c(t){n(o,i,r,s,c,"throw",t)}s(void 0)}))}}a("d3b7"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=i},"2c13":function(t,e,a){var n=a("24fb");e=n(!1),e.push([t.i,'@charset "UTF-8";\n/* 页面左右间距 */\n/* 文字尺寸 */\n/*文字颜色*/\n/* 边框颜色 */\n/* 图片加载中颜色 */\n/* 行为相关颜色 */uni-page-body[data-v-a9faba62]{background-color:#fff!important}\n/* 分类 */.cate-section[data-v-a9faba62]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-justify-content:space-around;justify-content:space-around;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-flex-wrap:wrap;flex-wrap:wrap;padding:%?30?% %?22?%;background:#fff\n  /* 原图标颜色太深,不想改图了,所以加了透明度 */}.cate-section .cate-item[data-v-a9faba62]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;-webkit-box-align:center;-webkit-align-items:center;align-items:center;font-size:%?26?%;color:#303133}.cate-section uni-image[data-v-a9faba62]{width:%?88?%;height:%?88?%;margin-bottom:%?14?%;-webkit-border-radius:50%;border-radius:50%;opacity:.7;-webkit-box-shadow:%?4?% %?4?% %?20?% rgba(250,67,106,.3);box-shadow:%?4?% %?4?% %?20?% rgba(250,67,106,.3)}\n/* 规格选择弹窗 */.attr-content[data-v-a9faba62]{padding:%?10?% %?30?%;min-height:20vh!important}.attr-content .a-t[data-v-a9faba62]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:end;-webkit-align-items:flex-end;align-items:flex-end}.attr-content .a-t uni-image[data-v-a9faba62]{width:%?170?%;height:%?170?%;-webkit-flex-shrink:0;flex-shrink:0;margin-top:%?-40?%;-webkit-border-radius:%?8?%;border-radius:%?8?%}.attr-content .a-t .right[data-v-a9faba62]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;padding-left:%?24?%;margin-right:%?8?%;font-size:%?26?%;color:#606266;line-height:%?42?%}.attr-content .a-t .right .price[data-v-a9faba62]{font-size:%?32?%;color:#fa436a;margin-bottom:%?10?%}.attr-content .a-t .uni-numbox[data-v-a9faba62]{position:static;left:unset;right:0}\n/*  弹出层 */.popup[data-v-a9faba62]{position:fixed;left:0;top:0;right:0;bottom:0;z-index:99}.popup.show[data-v-a9faba62]{display:block}.popup.show .mask[data-v-a9faba62]{-webkit-animation:showPopup-data-v-a9faba62 .2s linear both;animation:showPopup-data-v-a9faba62 .2s linear both}.popup.show .layer[data-v-a9faba62]{-webkit-animation:showLayer-data-v-a9faba62 .2s linear both;animation:showLayer-data-v-a9faba62 .2s linear both}.popup.hide .mask[data-v-a9faba62]{-webkit-animation:hidePopup-data-v-a9faba62 .2s linear both;animation:hidePopup-data-v-a9faba62 .2s linear both}.popup.hide .layer[data-v-a9faba62]{-webkit-animation:hideLayer-data-v-a9faba62 .2s linear both;animation:hideLayer-data-v-a9faba62 .2s linear both}.popup.none[data-v-a9faba62]{display:none}.popup .mask[data-v-a9faba62]{position:fixed;top:0;width:100%;height:100%;z-index:1;background-color:rgba(0,0,0,.4)}.popup .layer[data-v-a9faba62]{position:fixed;z-index:99;bottom:0;width:100%;min-height:40vh;-webkit-border-radius:%?10?% %?10?% 0 0;border-radius:%?10?% %?10?% 0 0;background-color:#fff}.popup .layer .btn[data-v-a9faba62]{height:%?66?%;line-height:%?66?%;-webkit-border-radius:%?100?%;border-radius:%?100?%;background:#fa436a;font-size:%?30?%;color:#fff;margin:%?30?% auto %?20?%}@-webkit-keyframes showPopup-data-v-a9faba62{0%{opacity:0}100%{opacity:1}}@keyframes showPopup-data-v-a9faba62{0%{opacity:0}100%{opacity:1}}@-webkit-keyframes hidePopup-data-v-a9faba62{0%{opacity:1}100%{opacity:0}}@keyframes hidePopup-data-v-a9faba62{0%{opacity:1}100%{opacity:0}}@-webkit-keyframes showLayer-data-v-a9faba62{0%{-webkit-transform:translateY(120%);transform:translateY(120%)}100%{-webkit-transform:translateY(0);transform:translateY(0)}}@keyframes showLayer-data-v-a9faba62{0%{-webkit-transform:translateY(120%);transform:translateY(120%)}100%{-webkit-transform:translateY(0);transform:translateY(0)}}@-webkit-keyframes hideLayer-data-v-a9faba62{0%{-webkit-transform:translateY(0);transform:translateY(0)}100%{-webkit-transform:translateY(120%);transform:translateY(120%)}}@keyframes hideLayer-data-v-a9faba62{0%{-webkit-transform:translateY(0);transform:translateY(0)}100%{-webkit-transform:translateY(120%);transform:translateY(120%)}}body.?%PAGE?%[data-v-a9faba62]{background-color:#fff!important}',""]),t.exports=e},3143:function(t,e,a){var n=a("2c13");"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var i=a("4f06").default;i("12dd4e16",n,!0,{sourceMap:!1,shadowMode:!1})},"6fa6":function(t,e,a){"use strict";var n=a("4ea4");a("99af"),a("c975"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var i=n(a("2909"));a("96cf");var r=n(a("1da1")),o={data:function(){return{titleNViewBackground:"",swiperCurrent:0,swiperLength:0,carouselList:[],list:[],joinData:{},number:1,specClass:"none",noFlag:!1,refresh:!1,ptFlag:!0}},watch:{refresh:function(t){t&&(this.refresh=!0)}},onLoad:function(){this.getList()},onShow:function(){uni.getStorage({key:"version",success:function(t){document.title="".concat(document.title," - ").concat(JSON.parse(t.data).site.name)}})},methods:{navTo:function(t){this.$Router.push({name:t})},getList:function(){var t=this;return(0,r.default)(regeneratorRuntime.mark((function e(){var a;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,t.$request.get("/api/plugin.hasog_pintuan-index-index-shoplist");case 2:if(a=e.sent,!a.url||-1==a.url.indexOf("login")){e.next=6;break}return uni.showModal({title:"温馨提示",content:a.msg,success:function(e){e.confirm&&t.$Router.push({name:"Login"})}}),e.abrupt("return");case 6:1==a.code?t.list=(0,i.default)(a.data):t.$api.modal(a.msg);case 7:case"end":return e.stop()}}),e)})))()},toggleSpec:function(t){var e=this;this.joinData=t,"show"===this.specClass?(this.specClass="hide",setTimeout((function(){e.specClass="none"}),250)):"none"===this.specClass&&(this.specClass="show")},numberChange:function(t){this.number=t.number},stopPrevent:function(){},joinGroup:function(t){var e=this;return(0,r.default)(regeneratorRuntime.mark((function a(){var n;return regeneratorRuntime.wrap((function(a){while(1)switch(a.prev=a.next){case 0:if(e.ptFlag){a.next=3;break}return e.$api.msg("您操作的太快啦","loading"),a.abrupt("return");case 3:return e.ptFlag=!1,a.next=6,e.$request.post("/api/plugin.hasog_pintuan-index-index-post",{id:t,num:e.number});case 6:if(n=a.sent,e.number=1,e.toggleSpec({}),!n.url||-1==n.url.indexOf("login")){a.next=12;break}return uni.showModal({title:"温馨提示",content:n.msg,success:function(t){e.ptFlag=!0,t.confirm&&e.$Router.push({name:"Login"})}}),a.abrupt("return");case 12:1==n.code?(e.$api.msg(n.msg),setTimeout((function(){e.ptFlag=!0}),600)):(e.$api.modal(n.msg),setTimeout((function(){e.ptFlag=!0}),600));case 13:case"end":return a.stop()}}),a)})))()}}};e.default=o},"96cf":function(t,e){!function(e){"use strict";var a,n=Object.prototype,i=n.hasOwnProperty,r="function"===typeof Symbol?Symbol:{},o=r.iterator||"@@iterator",s=r.asyncIterator||"@@asyncIterator",c=r.toStringTag||"@@toStringTag",u="object"===typeof t,l=e.regeneratorRuntime;if(l)u&&(t.exports=l);else{l=e.regeneratorRuntime=u?t.exports:{},l.wrap=y;var f="suspendedStart",p="suspendedYield",h="executing",d="completed",v={},m={};m[o]=function(){return this};var b=Object.getPrototypeOf,g=b&&b(b(O([])));g&&g!==n&&i.call(g,o)&&(m=g);var w=C.prototype=k.prototype=Object.create(m);_.prototype=w.constructor=C,C.constructor=_,C[c]=_.displayName="GeneratorFunction",l.isGeneratorFunction=function(t){var e="function"===typeof t&&t.constructor;return!!e&&(e===_||"GeneratorFunction"===(e.displayName||e.name))},l.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,C):(t.__proto__=C,c in t||(t[c]="GeneratorFunction")),t.prototype=Object.create(w),t},l.awrap=function(t){return{__await:t}},L(E.prototype),E.prototype[s]=function(){return this},l.AsyncIterator=E,l.async=function(t,e,a,n){var i=new E(y(t,e,a,n));return l.isGeneratorFunction(e)?i:i.next().then((function(t){return t.done?t.value:i.next()}))},L(w),w[c]="Generator",w[o]=function(){return this},w.toString=function(){return"[object Generator]"},l.keys=function(t){var e=[];for(var a in t)e.push(a);return e.reverse(),function a(){while(e.length){var n=e.pop();if(n in t)return a.value=n,a.done=!1,a}return a.done=!0,a}},l.values=O,Y.prototype={constructor:Y,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=a,this.done=!1,this.delegate=null,this.method="next",this.arg=a,this.tryEntries.forEach(S),!t)for(var e in this)"t"===e.charAt(0)&&i.call(this,e)&&!isNaN(+e.slice(1))&&(this[e]=a)},stop:function(){this.done=!0;var t=this.tryEntries[0],e=t.completion;if("throw"===e.type)throw e.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var e=this;function n(n,i){return s.type="throw",s.arg=t,e.next=n,i&&(e.method="next",e.arg=a),!!i}for(var r=this.tryEntries.length-1;r>=0;--r){var o=this.tryEntries[r],s=o.completion;if("root"===o.tryLoc)return n("end");if(o.tryLoc<=this.prev){var c=i.call(o,"catchLoc"),u=i.call(o,"finallyLoc");if(c&&u){if(this.prev<o.catchLoc)return n(o.catchLoc,!0);if(this.prev<o.finallyLoc)return n(o.finallyLoc)}else if(c){if(this.prev<o.catchLoc)return n(o.catchLoc,!0)}else{if(!u)throw new Error("try statement without catch or finally");if(this.prev<o.finallyLoc)return n(o.finallyLoc)}}}},abrupt:function(t,e){for(var a=this.tryEntries.length-1;a>=0;--a){var n=this.tryEntries[a];if(n.tryLoc<=this.prev&&i.call(n,"finallyLoc")&&this.prev<n.finallyLoc){var r=n;break}}r&&("break"===t||"continue"===t)&&r.tryLoc<=e&&e<=r.finallyLoc&&(r=null);var o=r?r.completion:{};return o.type=t,o.arg=e,r?(this.method="next",this.next=r.finallyLoc,v):this.complete(o)},complete:function(t,e){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&e&&(this.next=e),v},finish:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var a=this.tryEntries[e];if(a.finallyLoc===t)return this.complete(a.completion,a.afterLoc),S(a),v}},catch:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var a=this.tryEntries[e];if(a.tryLoc===t){var n=a.completion;if("throw"===n.type){var i=n.arg;S(a)}return i}}throw new Error("illegal catch attempt")},delegateYield:function(t,e,n){return this.delegate={iterator:O(t),resultName:e,nextLoc:n},"next"===this.method&&(this.arg=a),v}}}function y(t,e,a,n){var i=e&&e.prototype instanceof k?e:k,r=Object.create(i.prototype),o=new Y(n||[]);return r._invoke=j(t,a,o),r}function x(t,e,a){try{return{type:"normal",arg:t.call(e,a)}}catch(n){return{type:"throw",arg:n}}}function k(){}function _(){}function C(){}function L(t){["next","throw","return"].forEach((function(e){t[e]=function(t){return this._invoke(e,t)}}))}function E(t){function e(a,n,r,o){var s=x(t[a],t,n);if("throw"!==s.type){var c=s.arg,u=c.value;return u&&"object"===typeof u&&i.call(u,"__await")?Promise.resolve(u.__await).then((function(t){e("next",t,r,o)}),(function(t){e("throw",t,r,o)})):Promise.resolve(u).then((function(t){c.value=t,r(c)}),(function(t){return e("throw",t,r,o)}))}o(s.arg)}var a;function n(t,n){function i(){return new Promise((function(a,i){e(t,n,a,i)}))}return a=a?a.then(i,i):i()}this._invoke=n}function j(t,e,a){var n=f;return function(i,r){if(n===h)throw new Error("Generator is already running");if(n===d){if("throw"===i)throw r;return G()}a.method=i,a.arg=r;while(1){var o=a.delegate;if(o){var s=P(o,a);if(s){if(s===v)continue;return s}}if("next"===a.method)a.sent=a._sent=a.arg;else if("throw"===a.method){if(n===f)throw n=d,a.arg;a.dispatchException(a.arg)}else"return"===a.method&&a.abrupt("return",a.arg);n=h;var c=x(t,e,a);if("normal"===c.type){if(n=a.done?d:p,c.arg===v)continue;return{value:c.arg,done:a.done}}"throw"===c.type&&(n=d,a.method="throw",a.arg=c.arg)}}}function P(t,e){var n=t.iterator[e.method];if(n===a){if(e.delegate=null,"throw"===e.method){if(t.iterator.return&&(e.method="return",e.arg=a,P(t,e),"throw"===e.method))return v;e.method="throw",e.arg=new TypeError("The iterator does not provide a 'throw' method")}return v}var i=x(n,t.iterator,e.arg);if("throw"===i.type)return e.method="throw",e.arg=i.arg,e.delegate=null,v;var r=i.arg;return r?r.done?(e[t.resultName]=r.value,e.next=t.nextLoc,"return"!==e.method&&(e.method="next",e.arg=a),e.delegate=null,v):r:(e.method="throw",e.arg=new TypeError("iterator result is not an object"),e.delegate=null,v)}function $(t){var e={tryLoc:t[0]};1 in t&&(e.catchLoc=t[1]),2 in t&&(e.finallyLoc=t[2],e.afterLoc=t[3]),this.tryEntries.push(e)}function S(t){var e=t.completion||{};e.type="normal",delete e.arg,t.completion=e}function Y(t){this.tryEntries=[{tryLoc:"root"}],t.forEach($,this),this.reset(!0)}function O(t){if(t){var e=t[o];if(e)return e.call(t);if("function"===typeof t.next)return t;if(!isNaN(t.length)){var n=-1,r=function e(){while(++n<t.length)if(i.call(t,n))return e.value=t[n],e.done=!1,e;return e.value=a,e.done=!0,e};return r.next=r}}return{next:G}}function G(){return{value:a,done:!0}}}(function(){return this||"object"===typeof self&&self}()||Function("return this")())},ba3e:function(t,e,a){"use strict";var n;a.d(e,"b",(function(){return i})),a.d(e,"c",(function(){return r})),a.d(e,"a",(function(){return n}));var i=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("v-uni-view",{staticClass:"container"},[a("nav-bar",[t._v("拼团区")]),a("v-uni-view",{staticClass:"cate-section"},[a("v-uni-view",{staticClass:"cate-item",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.navTo("SpellGroupWin")}}},[a("v-uni-image",{attrs:{src:"/static/temp/c15.png"}}),a("v-uni-text",[t._v("中奖记录")])],1),a("v-uni-view",{staticClass:"cate-item",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.navTo("SpellGroupRecords")}}},[a("v-uni-image",{attrs:{src:"/static/temp/c18.png"}}),a("v-uni-text",[t._v("拼团记录")])],1),a("v-uni-view",{staticClass:"cate-item",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.navTo("SpellGroupConsume")}}},[a("v-uni-image",{attrs:{src:"/static/temp/c14.png"}}),a("v-uni-text",[t._v("消费记录")])],1),a("v-uni-view",{staticClass:"cate-item",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.navTo("SpellGroupClouds")}}},[a("v-uni-image",{attrs:{src:"/static/temp/c17.png"}}),a("v-uni-text",[t._v("团长记录")])],1),a("v-uni-view",{staticClass:"cate-item",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.navTo("SpellGroupCenter")}}},[a("v-uni-image",{attrs:{src:"/static/temp/c16.png"}}),a("v-uni-text",[t._v("团长中心")])],1)],1),a("v-uni-view",[t.noFlag?a("empty"):a("v-uni-view",{staticClass:"goods-list"},t._l(t.list,(function(e,n){return a("v-uni-view",{key:n,staticClass:"list-item"},[a("v-uni-view",{staticClass:"item"},[a("v-uni-view",{staticClass:"img"},[a("v-uni-image",{attrs:{src:e.pic||"/static/errorImage.jpg"}}),a("v-uni-view",{staticClass:"state"})],1),a("v-uni-view",{staticClass:"d"},[a("v-uni-view",{staticClass:"title"},[a("v-uni-view",[t._v(t._s(e.title))])],1),a("v-uni-view",{staticClass:"peple"},[a("v-uni-view",[a("v-uni-text",{staticClass:"iconfont icon-group-cu"}),t._v(t._s(e.good_max)+"人团")],1)],1),a("v-uni-view",{staticClass:"price"},[a("v-uni-view",{staticClass:"price-l"},[a("v-uni-view",{staticClass:"goods_price"},[a("v-uni-text",{staticClass:"price-icon"},[t._v("￥")]),t._v(t._s(e.price))],1)],1),a("v-uni-view",{staticClass:"exchange",on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.toggleSpec(e)}}},[t._v("去拼团"),a("v-uni-text",{staticClass:"yticon icon-you"})],1)],1)],1)],1)],1)})),1)],1),a("v-uni-view",{staticClass:"popup spec",class:t.specClass,on:{touchmove:function(e){e.stopPropagation(),e.preventDefault(),arguments[0]=e=t.$handleEvent(e),t.stopPrevent.apply(void 0,arguments)},click:function(e){arguments[0]=e=t.$handleEvent(e),t.toggleSpec.apply(void 0,arguments)}}},[a("v-uni-view",{staticClass:"mask"}),a("v-uni-view",{staticClass:"layer attr-content",on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.stopPrevent.apply(void 0,arguments)}}},[a("v-uni-view",{staticClass:"a-t"},[a("v-uni-image",{attrs:{src:t.joinData.pic}}),a("v-uni-view",{staticClass:"right"},[a("v-uni-text",{staticClass:"price"},[t._v("¥"+t._s(t.joinData.price))]),a("v-uni-text",{staticClass:"stock"},[t._v("单人购买最大份数："+t._s(t.joinData.price_max))])],1),a("uni-number-box",{staticClass:"step",attrs:{min:1,max:t.joinData.price_max,value:t.number,isMax:t.number>=t.joinData.price_max,isMin:1===t.number,disabled:!0},on:{eventChange:function(e){arguments[0]=e=t.$handleEvent(e),t.numberChange.apply(void 0,arguments)}}})],1),a("v-uni-button",{staticClass:"btn",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.joinGroup(t.joinData.id)}}},[t._v("确定")])],1)],1)],1)},r=[]},ca53:function(t,e,a){"use strict";a.r(e);var n=a("ba3e"),i=a("d6e4");for(var r in i)"default"!==r&&function(t){a.d(e,t,(function(){return i[t]}))}(r);a("08d7");var o,s=a("f0c5"),c=Object(s["a"])(i["default"],n["b"],n["c"],!1,null,"a9faba62",null,!1,n["a"],o);e["default"]=c.exports},d6e4:function(t,e,a){"use strict";a.r(e);var n=a("6fa6"),i=a.n(n);for(var r in n)"default"!==r&&function(t){a.d(e,t,(function(){return n[t]}))}(r);e["default"]=i.a}}]);