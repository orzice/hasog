(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-spell-spellGroup_center"],{"1da1":function(t,e,i){"use strict";function n(t,e,i,n,r,o,a){try{var s=t[o](a),c=s.value}catch(l){return void i(l)}s.done?e(c):Promise.resolve(c).then(n,r)}function r(t){return function(){var e=this,i=arguments;return new Promise((function(r,o){var a=t.apply(e,i);function s(t){n(a,r,o,s,c,"next",t)}function c(t){n(a,r,o,s,c,"throw",t)}s(void 0)}))}}i("d3b7"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=r},2617:function(t,e,i){"use strict";var n=i("4ea4");i("99af"),i("c975"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var r=n(i("2909"));i("96cf");var o=n(i("1da1")),a=n(i("5530")),s=i("2f62"),c={data:function(){return{list:[],noFlag:!1,refresh:!1,scrollTop:0}},onPageScroll:function(t){this.scrollTop=t.scrollTop},onShow:function(){uni.getStorage({key:"version",success:function(t){document.title="".concat(document.title," - ").concat(JSON.parse(t.data).site.name)}})},computed:(0,a.default)({},(0,s.mapState)(["hasLogin","userInfo"])),watch:{refresh:function(t){t&&(this.refresh=!1,this.getList())}},onLoad:function(){this.getList()},methods:{navTo:function(t){this.$Router.push({name:t})},getList:function(){var t=this;return(0,o.default)(regeneratorRuntime.mark((function e(){var i;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,t.$request.get("/api/plugin.hasog_pintuan-index-index-shoplist");case 2:if(i=e.sent,-1==i.msg.indexOf("登录")){e.next=6;break}return uni.showModal({title:"温馨提示",content:i.msg,success:function(e){e.confirm?t.$Router.push({name:"Login"}):t.$Router.back(1)}}),e.abrupt("return");case 6:1==i.code?t.list=(0,r.default)(i.data):t.$api.modal(i.msg);case 7:case"end":return e.stop()}}),e)})))()},joinGroup:function(t){var e=this;return(0,o.default)(regeneratorRuntime.mark((function i(){var n;return regeneratorRuntime.wrap((function(i){while(1)switch(i.prev=i.next){case 0:return i.next=2,e.$request.post("/api/plugin.hasog_pintuan-index-index-tzpin",{id:t});case 2:if(n=i.sent,!n.url||-1==n.url.indexOf("login")){i.next=6;break}return uni.showModal({title:"温馨提示",content:n.msg,success:function(t){t.confirm&&e.$Router.push({name:"Login"})}}),i.abrupt("return");case 6:1==n.code?e.$api.msg(n.msg):e.$api.modal(n.msg);case 7:case"end":return i.stop()}}),i)})))()}}};e.default=c},5224:function(t,e,i){var n=i("24fb");e=n(!1),e.push([t.i,'@charset "UTF-8";\n/* 页面左右间距 */\n/* 文字尺寸 */\n/*文字颜色*/\n/* 边框颜色 */\n/* 图片加载中颜色 */\n/* 行为相关颜色 */uni-page-body[data-v-24027fb0]{background-color:#fff!important}.tj-sction .tj-item[data-v-24027fb0]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.tj-sction[data-v-24027fb0]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-justify-content:space-around;justify-content:space-around;-webkit-align-content:center;align-content:center;background:#fff;border-radius:%?10?%}.tj-sction.info[data-v-24027fb0]{border-top:%?1?% dashed #f5f5f5}.tj-sction .tj-item[data-v-24027fb0]{-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;width:50%;height:%?140?%;font-size:%?24?%;color:#75787d}.tj-sction .num[data-v-24027fb0]{font-size:%?32?%;margin-bottom:%?8?%;color:#fa436a}.goods-list .list-item[data-v-24027fb0]{min-height:%?160?%;padding:0 %?20?%;padding-bottom:%?20?%;box-sizing:border-box;background-color:#fff;overflow:hidden}.goods-list .list-item .item[data-v-24027fb0]{display:-webkit-box;display:-webkit-flex;display:flex;padding:%?16?%}.goods-list .list-item .item .img[data-v-24027fb0]{position:relative;width:%?200?%;height:%?200?%;margin-right:%?16?%}.goods-list .list-item .item .img uni-image[data-v-24027fb0]{width:100%;height:100%;object-fit:cover;border-radius:10px}.goods-list .list-item .item .d[data-v-24027fb0]{-webkit-box-flex:1;-webkit-flex:1;flex:1;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-flow:column;flex-flow:column;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between}.goods-list .list-item .item .d .title[data-v-24027fb0]{height:auto;font-size:%?28?%;text-align:left;line-height:%?40?%;color:#333;overflow:hidden}.goods-list .list-item .item .d .title uni-view[data-v-24027fb0]{height:%?80?%;text-align:left;overflow:hidden;text-overflow:ellipsis;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;color:#333}.goods-list .list-item .item .d .price[data-v-24027fb0]{font-size:%?24?%;overflow:hidden;position:relative;text-align:left;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between}.goods-list .list-item .item .d .price .price-l[data-v-24027fb0]{-webkit-box-flex:1;-webkit-flex:1;flex:1}.goods-list .list-item .item .d .price .price-l .goods_price[data-v-24027fb0]{color:#fa436a;font-size:%?32?%;font-weight:700}.goods-list .list-item .item .d .price .exchange[data-v-24027fb0]{color:#fff;height:%?56?%;line-height:%?56?%;padding:0 %?14?%;border-radius:5px;box-sizing:border-box;background-color:#fa436a}.goods-list .list-item .item .d .price .exchange .yticon[data-v-24027fb0]{font-size:%?28?%}\n/* 规格选择弹窗 */.attr-content[data-v-24027fb0]{padding:%?10?% %?30?%;min-height:20vh!important}.attr-content .a-t[data-v-24027fb0]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:end;-webkit-align-items:flex-end;align-items:flex-end}.attr-content .a-t uni-image[data-v-24027fb0]{width:%?170?%;height:%?170?%;-webkit-flex-shrink:0;flex-shrink:0;margin-top:%?-40?%;border-radius:%?8?%}.attr-content .a-t .right[data-v-24027fb0]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;padding-left:%?24?%;margin-right:%?8?%;font-size:%?26?%;color:#606266;line-height:%?42?%}.attr-content .a-t .right .price[data-v-24027fb0]{font-size:%?32?%;color:#fa436a;margin-bottom:%?10?%}.attr-content .a-t .uni-numbox[data-v-24027fb0]{position:static;left:unset;right:0}\n/*  弹出层 */.popup[data-v-24027fb0]{position:fixed;left:0;top:0;right:0;bottom:0;z-index:99}.popup.show[data-v-24027fb0]{display:block}.popup.show .mask[data-v-24027fb0]{-webkit-animation:showPopup-data-v-24027fb0 .2s linear both;animation:showPopup-data-v-24027fb0 .2s linear both}.popup.show .layer[data-v-24027fb0]{-webkit-animation:showLayer-data-v-24027fb0 .2s linear both;animation:showLayer-data-v-24027fb0 .2s linear both}.popup.hide .mask[data-v-24027fb0]{-webkit-animation:hidePopup-data-v-24027fb0 .2s linear both;animation:hidePopup-data-v-24027fb0 .2s linear both}.popup.hide .layer[data-v-24027fb0]{-webkit-animation:hideLayer-data-v-24027fb0 .2s linear both;animation:hideLayer-data-v-24027fb0 .2s linear both}.popup.none[data-v-24027fb0]{display:none}.popup .mask[data-v-24027fb0]{position:fixed;top:0;width:100%;height:100%;z-index:1;background-color:rgba(0,0,0,.4)}.popup .layer[data-v-24027fb0]{position:fixed;z-index:99;bottom:0;width:100%;min-height:40vh;border-radius:%?10?% %?10?% 0 0;background-color:#fff}.popup .layer .btn[data-v-24027fb0]{height:%?66?%;line-height:%?66?%;border-radius:%?100?%;background:#fa436a;font-size:%?30?%;color:#fff;margin:%?30?% auto %?20?%}@-webkit-keyframes showPopup-data-v-24027fb0{0%{opacity:0}100%{opacity:1}}@keyframes showPopup-data-v-24027fb0{0%{opacity:0}100%{opacity:1}}@-webkit-keyframes hidePopup-data-v-24027fb0{0%{opacity:1}100%{opacity:0}}@keyframes hidePopup-data-v-24027fb0{0%{opacity:1}100%{opacity:0}}@-webkit-keyframes showLayer-data-v-24027fb0{0%{-webkit-transform:translateY(120%);transform:translateY(120%)}100%{-webkit-transform:translateY(0);transform:translateY(0)}}@keyframes showLayer-data-v-24027fb0{0%{-webkit-transform:translateY(120%);transform:translateY(120%)}100%{-webkit-transform:translateY(0);transform:translateY(0)}}@-webkit-keyframes hideLayer-data-v-24027fb0{0%{-webkit-transform:translateY(0);transform:translateY(0)}100%{-webkit-transform:translateY(120%);transform:translateY(120%)}}@keyframes hideLayer-data-v-24027fb0{0%{-webkit-transform:translateY(0);transform:translateY(0)}100%{-webkit-transform:translateY(120%);transform:translateY(120%)}}body.?%PAGE?%[data-v-24027fb0]{background-color:#fff!important}',""]),t.exports=e},"5d8a":function(t,e,i){var n=i("5224");"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var r=i("4f06").default;r("9de7b4a6",n,!0,{sourceMap:!1,shadowMode:!1})},"7aea":function(t,e,i){"use strict";i.r(e);var n=i("8e1a"),r=i("a419");for(var o in r)"default"!==o&&function(t){i.d(e,t,(function(){return r[t]}))}(o);i("fdd6");var a,s=i("f0c5"),c=Object(s["a"])(r["default"],n["b"],n["c"],!1,null,"24027fb0",null,!1,n["a"],a);e["default"]=c.exports},"8e1a":function(t,e,i){"use strict";var n;i.d(e,"b",(function(){return r})),i.d(e,"c",(function(){return o})),i.d(e,"a",(function(){return n}));var r=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",{staticClass:"container"},[t.userInfo.user_info?i("v-uni-view",{staticClass:"tj-sction info"},[i("v-uni-view",{staticClass:"tj-item"},[i("v-uni-text",{staticClass:"num"},[i("small",[t._v("￥")]),t._v(t._s(t.userInfo.user_info.credit5||0))]),i("v-uni-text",[t._v("拼团券")])],1)],1):t._e(),i("v-uni-view",[t.noFlag?i("empty"):i("v-uni-view",{staticClass:"goods-list"},t._l(t.list,(function(e,n){return i("v-uni-view",{key:n,staticClass:"list-item"},[i("v-uni-view",{staticClass:"item"},[i("v-uni-view",{staticClass:"img"},[i("v-uni-image",{attrs:{src:e.pic||"/static/errorImage.jpg"}}),i("v-uni-view",{staticClass:"state"})],1),i("v-uni-view",{staticClass:"d"},[i("v-uni-view",{staticClass:"title"},[i("v-uni-view",[t._v(t._s(e.title))])],1),i("v-uni-view",{staticClass:"peple"},[i("v-uni-view",[i("v-uni-text",{staticClass:"iconfont icon-ziyuan1"}),t._v(t._s(e.good_max)+"人团")],1)],1),i("v-uni-view",{staticClass:"price"},[i("v-uni-view",{staticClass:"price-l"},[i("v-uni-view",{staticClass:"goods_price"},[i("small",[t._v("￥")]),t._v(t._s(e.price))])],1),i("v-uni-view",{staticClass:"exchange",on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.joinGroup(e.id)}}},[t._v("去开团"),i("v-uni-text",{staticClass:"yticon icon-you"})],1)],1)],1)],1)],1)})),1)],1),i("back-top",{attrs:{scrollTop:t.scrollTop}})],1)},o=[]},"96cf":function(t,e){!function(e){"use strict";var i,n=Object.prototype,r=n.hasOwnProperty,o="function"===typeof Symbol?Symbol:{},a=o.iterator||"@@iterator",s=o.asyncIterator||"@@asyncIterator",c=o.toStringTag||"@@toStringTag",l="object"===typeof t,f=e.regeneratorRuntime;if(f)l&&(t.exports=f);else{f=e.regeneratorRuntime=l?t.exports:{},f.wrap=y;var u="suspendedStart",d="suspendedYield",p="executing",h="completed",b={},v={};v[a]=function(){return this};var m=Object.getPrototypeOf,g=m&&m(m(G([])));g&&g!==n&&r.call(g,a)&&(v=g);var w=_.prototype=k.prototype=Object.create(v);L.prototype=w.constructor=_,_.constructor=L,_[c]=L.displayName="GeneratorFunction",f.isGeneratorFunction=function(t){var e="function"===typeof t&&t.constructor;return!!e&&(e===L||"GeneratorFunction"===(e.displayName||e.name))},f.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,_):(t.__proto__=_,c in t||(t[c]="GeneratorFunction")),t.prototype=Object.create(w),t},f.awrap=function(t){return{__await:t}},j(E.prototype),E.prototype[s]=function(){return this},f.AsyncIterator=E,f.async=function(t,e,i,n){var r=new E(y(t,e,i,n));return f.isGeneratorFunction(e)?r:r.next().then((function(t){return t.done?t.value:r.next()}))},j(w),w[c]="Generator",w[a]=function(){return this},w.toString=function(){return"[object Generator]"},f.keys=function(t){var e=[];for(var i in t)e.push(i);return e.reverse(),function i(){while(e.length){var n=e.pop();if(n in t)return i.value=n,i.done=!1,i}return i.done=!0,i}},f.values=G,z.prototype={constructor:z,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=i,this.done=!1,this.delegate=null,this.method="next",this.arg=i,this.tryEntries.forEach(O),!t)for(var e in this)"t"===e.charAt(0)&&r.call(this,e)&&!isNaN(+e.slice(1))&&(this[e]=i)},stop:function(){this.done=!0;var t=this.tryEntries[0],e=t.completion;if("throw"===e.type)throw e.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var e=this;function n(n,r){return s.type="throw",s.arg=t,e.next=n,r&&(e.method="next",e.arg=i),!!r}for(var o=this.tryEntries.length-1;o>=0;--o){var a=this.tryEntries[o],s=a.completion;if("root"===a.tryLoc)return n("end");if(a.tryLoc<=this.prev){var c=r.call(a,"catchLoc"),l=r.call(a,"finallyLoc");if(c&&l){if(this.prev<a.catchLoc)return n(a.catchLoc,!0);if(this.prev<a.finallyLoc)return n(a.finallyLoc)}else if(c){if(this.prev<a.catchLoc)return n(a.catchLoc,!0)}else{if(!l)throw new Error("try statement without catch or finally");if(this.prev<a.finallyLoc)return n(a.finallyLoc)}}}},abrupt:function(t,e){for(var i=this.tryEntries.length-1;i>=0;--i){var n=this.tryEntries[i];if(n.tryLoc<=this.prev&&r.call(n,"finallyLoc")&&this.prev<n.finallyLoc){var o=n;break}}o&&("break"===t||"continue"===t)&&o.tryLoc<=e&&e<=o.finallyLoc&&(o=null);var a=o?o.completion:{};return a.type=t,a.arg=e,o?(this.method="next",this.next=o.finallyLoc,b):this.complete(a)},complete:function(t,e){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&e&&(this.next=e),b},finish:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var i=this.tryEntries[e];if(i.finallyLoc===t)return this.complete(i.completion,i.afterLoc),O(i),b}},catch:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var i=this.tryEntries[e];if(i.tryLoc===t){var n=i.completion;if("throw"===n.type){var r=n.arg;O(i)}return r}}throw new Error("illegal catch attempt")},delegateYield:function(t,e,n){return this.delegate={iterator:G(t),resultName:e,nextLoc:n},"next"===this.method&&(this.arg=i),b}}}function y(t,e,i,n){var r=e&&e.prototype instanceof k?e:k,o=Object.create(r.prototype),a=new z(n||[]);return o._invoke=P(t,i,a),o}function x(t,e,i){try{return{type:"normal",arg:t.call(e,i)}}catch(n){return{type:"throw",arg:n}}}function k(){}function L(){}function _(){}function j(t){["next","throw","return"].forEach((function(e){t[e]=function(t){return this._invoke(e,t)}}))}function E(t){function e(i,n,o,a){var s=x(t[i],t,n);if("throw"!==s.type){var c=s.arg,l=c.value;return l&&"object"===typeof l&&r.call(l,"__await")?Promise.resolve(l.__await).then((function(t){e("next",t,o,a)}),(function(t){e("throw",t,o,a)})):Promise.resolve(l).then((function(t){c.value=t,o(c)}),(function(t){return e("throw",t,o,a)}))}a(s.arg)}var i;function n(t,n){function r(){return new Promise((function(i,r){e(t,n,i,r)}))}return i=i?i.then(r,r):r()}this._invoke=n}function P(t,e,i){var n=u;return function(r,o){if(n===p)throw new Error("Generator is already running");if(n===h){if("throw"===r)throw o;return T()}i.method=r,i.arg=o;while(1){var a=i.delegate;if(a){var s=C(a,i);if(s){if(s===b)continue;return s}}if("next"===i.method)i.sent=i._sent=i.arg;else if("throw"===i.method){if(n===u)throw n=h,i.arg;i.dispatchException(i.arg)}else"return"===i.method&&i.abrupt("return",i.arg);n=p;var c=x(t,e,i);if("normal"===c.type){if(n=i.done?h:d,c.arg===b)continue;return{value:c.arg,done:i.done}}"throw"===c.type&&(n=h,i.method="throw",i.arg=c.arg)}}}function C(t,e){var n=t.iterator[e.method];if(n===i){if(e.delegate=null,"throw"===e.method){if(t.iterator.return&&(e.method="return",e.arg=i,C(t,e),"throw"===e.method))return b;e.method="throw",e.arg=new TypeError("The iterator does not provide a 'throw' method")}return b}var r=x(n,t.iterator,e.arg);if("throw"===r.type)return e.method="throw",e.arg=r.arg,e.delegate=null,b;var o=r.arg;return o?o.done?(e[t.resultName]=o.value,e.next=t.nextLoc,"return"!==e.method&&(e.method="next",e.arg=i),e.delegate=null,b):o:(e.method="throw",e.arg=new TypeError("iterator result is not an object"),e.delegate=null,b)}function Y(t){var e={tryLoc:t[0]};1 in t&&(e.catchLoc=t[1]),2 in t&&(e.finallyLoc=t[2],e.afterLoc=t[3]),this.tryEntries.push(e)}function O(t){var e=t.completion||{};e.type="normal",delete e.arg,t.completion=e}function z(t){this.tryEntries=[{tryLoc:"root"}],t.forEach(Y,this),this.reset(!0)}function G(t){if(t){var e=t[a];if(e)return e.call(t);if("function"===typeof t.next)return t;if(!isNaN(t.length)){var n=-1,o=function e(){while(++n<t.length)if(r.call(t,n))return e.value=t[n],e.done=!1,e;return e.value=i,e.done=!0,e};return o.next=o}}return{next:T}}function T(){return{value:i,done:!0}}}(function(){return this||"object"===typeof self&&self}()||Function("return this")())},a419:function(t,e,i){"use strict";i.r(e);var n=i("2617"),r=i.n(n);for(var o in n)"default"!==o&&function(t){i.d(e,t,(function(){return n[t]}))}(o);e["default"]=r.a},fdd6:function(t,e,i){"use strict";var n=i("5d8a"),r=i.n(n);r.a}}]);