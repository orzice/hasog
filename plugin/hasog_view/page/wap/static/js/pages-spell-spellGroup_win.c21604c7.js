(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-spell-spellGroup_win"],{"1da1":function(t,e,n){"use strict";function r(t,e,n,r,i,o,a){try{var s=t[o](a),c=s.value}catch(u){return void n(u)}s.done?e(c):Promise.resolve(c).then(r,i)}function i(t){return function(){var e=this,n=arguments;return new Promise((function(i,o){var a=t.apply(e,n);function s(t){r(a,i,o,s,c,"next",t)}function c(t){r(a,i,o,s,c,"throw",t)}s(void 0)}))}}n("d3b7"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=i},"3f31":function(t,e,n){"use strict";n.r(e);var r=n("e9ae"),i=n.n(r);for(var o in r)"default"!==o&&function(t){n.d(e,t,(function(){return r[t]}))}(o);e["default"]=i.a},"4d38":function(t,e,n){"use strict";var r=n("6b41"),i=n.n(r);i.a},"66ad":function(t,e,n){"use strict";var r;n.d(e,"b",(function(){return i})),n.d(e,"c",(function(){return o})),n.d(e,"a",(function(){return r}));var i=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("v-uni-view",[t.noFlag?n("empty"):n("v-uni-view",{staticClass:"goods-list"},t._l(t.list,(function(e,r){return e.pintuanlist?n("v-uni-view",{key:r,staticClass:"list-item"},[n("v-uni-view",{staticClass:"time"},[t._v(t._s(t.$api.tier(e.pintuanlist.time)))]),n("v-uni-view",{staticClass:"item"},[n("v-uni-view",{staticClass:"img"},[n("v-uni-image",{attrs:{src:e.pintuanlist.pic||"/static/errorImage.jpg",mode:""}}),n("v-uni-view",{staticClass:"state"})],1),n("v-uni-view",{staticClass:"d"},[n("v-uni-view",{staticClass:"title"},[n("v-uni-view",[t._v(t._s(e.pintuanlist.title))])],1),n("v-uni-view",{staticClass:"peple"},[n("v-uni-view",[n("v-uni-text",{staticClass:"iconfont icon-ziyuan1"}),t._v(t._s(e.pintuanlist.goods_max)+"人团")],1)],1),n("v-uni-view",{staticClass:"price"},[n("v-uni-view",{staticClass:"price-l"},[n("v-uni-view",{staticClass:"goods_price"},[n("v-uni-text",{staticClass:"price-icon"},[t._v("￥")]),t._v(t._s(e.price)),n("v-uni-text",[t._v("共"+t._s(e.total)+"份")])],1)],1),0==e.zjs?n("v-uni-view",{staticClass:"exchange",on:{click:function(n){arguments[0]=n=t.$handleEvent(n),t.cAddress(e.id)}}},[t._v("去兑奖"),n("v-uni-text",{staticClass:"yticon icon-you"})],1):t._e(),1==e.zjs?n("v-uni-view",{staticClass:"exchange bg-gray"},[t._v("已兑奖")]):t._e()],1)],1)],1)],1):t._e()})),1),t.isMore?t._e():n("v-uni-view",{staticClass:"noMore"},[t._v("没有更多数据了")]),n("back-top",{attrs:{scrollTop:t.scrollTop}})],1)},o=[]},"6b41":function(t,e,n){var r=n("f0e4");"string"===typeof r&&(r=[[t.i,r,""]]),r.locals&&(t.exports=r.locals);var i=n("4f06").default;i("e2b685ea",r,!0,{sourceMap:!1,shadowMode:!1})},"81c3":function(t,e,n){"use strict";n.r(e);var r=n("66ad"),i=n("3f31");for(var o in i)"default"!==o&&function(t){n.d(e,t,(function(){return i[t]}))}(o);n("4d38");var a,s=n("f0c5"),c=Object(s["a"])(i["default"],r["b"],r["c"],!1,null,"4fe141ee",null,!1,r["a"],a);e["default"]=c.exports},"96cf":function(t,e){!function(e){"use strict";var n,r=Object.prototype,i=r.hasOwnProperty,o="function"===typeof Symbol?Symbol:{},a=o.iterator||"@@iterator",s=o.asyncIterator||"@@asyncIterator",c=o.toStringTag||"@@toStringTag",u="object"===typeof t,l=e.regeneratorRuntime;if(l)u&&(t.exports=l);else{l=e.regeneratorRuntime=u?t.exports:{},l.wrap=x;var f="suspendedStart",h="suspendedYield",p="executing",v="completed",d={},g={};g[a]=function(){return this};var y=Object.getPrototypeOf,m=y&&y(y(F([])));m&&m!==r&&i.call(m,a)&&(g=m);var w=k.prototype=b.prototype=Object.create(g);L.prototype=w.constructor=k,k.constructor=L,k[c]=L.displayName="GeneratorFunction",l.isGeneratorFunction=function(t){var e="function"===typeof t&&t.constructor;return!!e&&(e===L||"GeneratorFunction"===(e.displayName||e.name))},l.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,k):(t.__proto__=k,c in t||(t[c]="GeneratorFunction")),t.prototype=Object.create(w),t},l.awrap=function(t){return{__await:t}},E(j.prototype),j.prototype[s]=function(){return this},l.AsyncIterator=j,l.async=function(t,e,n,r){var i=new j(x(t,e,n,r));return l.isGeneratorFunction(e)?i:i.next().then((function(t){return t.done?t.value:i.next()}))},E(w),w[c]="Generator",w[a]=function(){return this},w.toString=function(){return"[object Generator]"},l.keys=function(t){var e=[];for(var n in t)e.push(n);return e.reverse(),function n(){while(e.length){var r=e.pop();if(r in t)return n.value=r,n.done=!1,n}return n.done=!0,n}},l.values=F,$.prototype={constructor:$,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=n,this.done=!1,this.delegate=null,this.method="next",this.arg=n,this.tryEntries.forEach(T),!t)for(var e in this)"t"===e.charAt(0)&&i.call(this,e)&&!isNaN(+e.slice(1))&&(this[e]=n)},stop:function(){this.done=!0;var t=this.tryEntries[0],e=t.completion;if("throw"===e.type)throw e.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var e=this;function r(r,i){return s.type="throw",s.arg=t,e.next=r,i&&(e.method="next",e.arg=n),!!i}for(var o=this.tryEntries.length-1;o>=0;--o){var a=this.tryEntries[o],s=a.completion;if("root"===a.tryLoc)return r("end");if(a.tryLoc<=this.prev){var c=i.call(a,"catchLoc"),u=i.call(a,"finallyLoc");if(c&&u){if(this.prev<a.catchLoc)return r(a.catchLoc,!0);if(this.prev<a.finallyLoc)return r(a.finallyLoc)}else if(c){if(this.prev<a.catchLoc)return r(a.catchLoc,!0)}else{if(!u)throw new Error("try statement without catch or finally");if(this.prev<a.finallyLoc)return r(a.finallyLoc)}}}},abrupt:function(t,e){for(var n=this.tryEntries.length-1;n>=0;--n){var r=this.tryEntries[n];if(r.tryLoc<=this.prev&&i.call(r,"finallyLoc")&&this.prev<r.finallyLoc){var o=r;break}}o&&("break"===t||"continue"===t)&&o.tryLoc<=e&&e<=o.finallyLoc&&(o=null);var a=o?o.completion:{};return a.type=t,a.arg=e,o?(this.method="next",this.next=o.finallyLoc,d):this.complete(a)},complete:function(t,e){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&e&&(this.next=e),d},finish:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var n=this.tryEntries[e];if(n.finallyLoc===t)return this.complete(n.completion,n.afterLoc),T(n),d}},catch:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var n=this.tryEntries[e];if(n.tryLoc===t){var r=n.completion;if("throw"===r.type){var i=r.arg;T(n)}return i}}throw new Error("illegal catch attempt")},delegateYield:function(t,e,r){return this.delegate={iterator:F(t),resultName:e,nextLoc:r},"next"===this.method&&(this.arg=n),d}}}function x(t,e,n,r){var i=e&&e.prototype instanceof b?e:b,o=Object.create(i.prototype),a=new $(r||[]);return o._invoke=C(t,n,a),o}function _(t,e,n){try{return{type:"normal",arg:t.call(e,n)}}catch(r){return{type:"throw",arg:r}}}function b(){}function L(){}function k(){}function E(t){["next","throw","return"].forEach((function(e){t[e]=function(t){return this._invoke(e,t)}}))}function j(t){function e(n,r,o,a){var s=_(t[n],t,r);if("throw"!==s.type){var c=s.arg,u=c.value;return u&&"object"===typeof u&&i.call(u,"__await")?Promise.resolve(u.__await).then((function(t){e("next",t,o,a)}),(function(t){e("throw",t,o,a)})):Promise.resolve(u).then((function(t){c.value=t,o(c)}),(function(t){return e("throw",t,o,a)}))}a(s.arg)}var n;function r(t,r){function i(){return new Promise((function(n,i){e(t,r,n,i)}))}return n=n?n.then(i,i):i()}this._invoke=r}function C(t,e,n){var r=f;return function(i,o){if(r===p)throw new Error("Generator is already running");if(r===v){if("throw"===i)throw o;return G()}n.method=i,n.arg=o;while(1){var a=n.delegate;if(a){var s=O(a,n);if(s){if(s===d)continue;return s}}if("next"===n.method)n.sent=n._sent=n.arg;else if("throw"===n.method){if(r===f)throw r=v,n.arg;n.dispatchException(n.arg)}else"return"===n.method&&n.abrupt("return",n.arg);r=p;var c=_(t,e,n);if("normal"===c.type){if(r=n.done?v:h,c.arg===d)continue;return{value:c.arg,done:n.done}}"throw"===c.type&&(r=v,n.method="throw",n.arg=c.arg)}}}function O(t,e){var r=t.iterator[e.method];if(r===n){if(e.delegate=null,"throw"===e.method){if(t.iterator.return&&(e.method="return",e.arg=n,O(t,e),"throw"===e.method))return d;e.method="throw",e.arg=new TypeError("The iterator does not provide a 'throw' method")}return d}var i=_(r,t.iterator,e.arg);if("throw"===i.type)return e.method="throw",e.arg=i.arg,e.delegate=null,d;var o=i.arg;return o?o.done?(e[t.resultName]=o.value,e.next=t.nextLoc,"return"!==e.method&&(e.method="next",e.arg=n),e.delegate=null,d):o:(e.method="throw",e.arg=new TypeError("iterator result is not an object"),e.delegate=null,d)}function P(t){var e={tryLoc:t[0]};1 in t&&(e.catchLoc=t[1]),2 in t&&(e.finallyLoc=t[2],e.afterLoc=t[3]),this.tryEntries.push(e)}function T(t){var e=t.completion||{};e.type="normal",delete e.arg,t.completion=e}function $(t){this.tryEntries=[{tryLoc:"root"}],t.forEach(P,this),this.reset(!0)}function F(t){if(t){var e=t[a];if(e)return e.call(t);if("function"===typeof t.next)return t;if(!isNaN(t.length)){var r=-1,o=function e(){while(++r<t.length)if(i.call(t,r))return e.value=t[r],e.done=!1,e;return e.value=n,e.done=!0,e};return o.next=o}}return{next:G}}function G(){return{value:n,done:!0}}}(function(){return this||"object"===typeof self&&self}()||Function("return this")())},e9ae:function(t,e,n){"use strict";var r=n("4ea4");n("99af"),n("c975"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var i=r(n("2909"));n("96cf");var o=r(n("1da1")),a={data:function(){return{list:[],noFlag:!1,refresh:!1,gotId:null,addressData:{},scrollTop:0,isMore:!0,page:0}},watch:{refresh:function(t){t&&(this.refresh=!1,this.page=0,this.getWin())},addressData:function(t){this.ticket(t.id)}},onShow:function(){uni.getStorage({key:"version",success:function(t){document.title="".concat(document.title," - ").concat(JSON.parse(t.data).site.name)}})},onLoad:function(){this.page=0,this.getWin()},onPageScroll:function(t){this.scrollTop=t.scrollTop},onReachBottom:function(){this.isMore&&(this.page+=1,this.getWin())},methods:{getWin:function(){var t=this;return(0,o.default)(regeneratorRuntime.mark((function e(){var n;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,t.$request.post("/api/plugin.hasog_pintuan-index-index-jiang",{page:t.page});case 2:if(n=e.sent,-1==n.msg.indexOf("登录")){e.next=6;break}return uni.showModal({title:"温馨提示",content:n.msg,success:function(e){e.confirm?t.$Router.push({name:"Login"}):t.$Router.back(1)}}),e.abrupt("return");case 6:if(1!=n.code){e.next=14;break}if(0!=t.page||0!=n.data.length){e.next=10;break}return t.noFlag=!0,e.abrupt("return");case 10:t.list=[].concat((0,i.default)(t.list),(0,i.default)(n.data)),0==n.data.length&&(t.isMore=!1),e.next=15;break;case 14:t.$api.modal(n.msg);case 15:case"end":return e.stop()}}),e)})))()},cAddress:function(t){this.gotId=t,this.$Router.push({name:"Address",params:{source:1}})},ticket:function(t){var e=this;return(0,o.default)(regeneratorRuntime.mark((function n(){var r;return regeneratorRuntime.wrap((function(n){while(1)switch(n.prev=n.next){case 0:return n.next=2,e.$request.post("/api/plugin.hasog_pintuan-index-index-jiangdui",{id:e.gotId,areaId:t});case 2:r=n.sent,1==r.code?(e.$api.msg(r.msg),e.page=0,e.list=[],e.getWin()):e.$api.modal(r.msg);case 4:case"end":return n.stop()}}),n)})))()}}};e.default=a},f0e4:function(t,e,n){var r=n("24fb");e=r(!1),e.push([t.i,'@charset "UTF-8";\n/* 页面左右间距 */\n/* 文字尺寸 */\n/*文字颜色*/\n/* 边框颜色 */\n/* 图片加载中颜色 */\n/* 行为相关颜色 */uni-page-body[data-v-4fe141ee]{background-color:#fff!important}body.?%PAGE?%[data-v-4fe141ee]{background-color:#fff!important}',""]),t.exports=e}}]);