(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-user-address"],{"1da1":function(t,e,r){"use strict";function n(t,e,r,n,i,o,a){try{var s=t[o](a),c=s.value}catch(u){return void r(u)}s.done?e(c):Promise.resolve(c).then(n,i)}function i(t){return function(){var e=this,r=arguments;return new Promise((function(i,o){var a=t.apply(e,r);function s(t){n(a,i,o,s,c,"next",t)}function c(t){n(a,i,o,s,c,"throw",t)}s(void 0)}))}}r("d3b7"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=i},"30bb":function(t,e,r){"use strict";var n;r.d(e,"b",(function(){return i})),r.d(e,"c",(function(){return o})),r.d(e,"a",(function(){return n}));var i=function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("v-uni-view",{staticClass:"content b-t"},[r("nav-bar",[t._v(t._s(t.title))]),t._l(t.addressList,(function(e,n){return r("v-uni-view",{key:n,staticClass:"list b-b",on:{click:function(r){arguments[0]=r=t.$handleEvent(r),t.checkAddress(e)}}},[r("v-uni-view",{staticClass:"wrapper"},[r("v-uni-view",{staticClass:"address-box"},[e.is_default?r("v-uni-text",{staticClass:"tag"},[t._v("默认")]):t._e(),r("v-uni-text",{staticClass:"address"},[t._v(t._s(e.province)+" "+t._s(e.city)+" "+t._s(e.district)+" "+t._s(e.area))])],1),r("v-uni-view",{staticClass:"u-box"},[r("v-uni-text",{staticClass:"name"},[t._v(t._s(e.name))]),r("v-uni-text",{staticClass:"mobile"},[t._v(t._s(e.connect_mobile))])],1)],1),r("v-uni-text",{staticClass:"yticon icon-bianji",on:{click:function(r){r.stopPropagation(),arguments[0]=r=t.$handleEvent(r),t.addAddress("edit",e)}}})],1)})),r("v-uni-button",{staticClass:"add-btn",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.addAddress("add")}}},[t._v("新增地址")])],2)},o=[]},"3ea4":function(t,e,r){"use strict";r.r(e);var n=r("30bb"),i=r("7d4d");for(var o in i)"default"!==o&&function(t){r.d(e,t,(function(){return i[t]}))}(o);r("b365");var a,s=r("f0c5"),c=Object(s["a"])(i["default"],n["b"],n["c"],!1,null,"d86981ce",null,!1,n["a"],a);e["default"]=c.exports},4728:function(t,e,r){var n=r("8da7");"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var i=r("4f06").default;i("08835be3",n,!0,{sourceMap:!1,shadowMode:!1})},"6b0a":function(t,e,r){"use strict";var n=r("4ea4");r("99af"),r("c975"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var i=n(r("2909"));r("96cf");var o=n(r("1da1")),a={data:function(){return{title:"收货地址",source:0,addressList:[],refresh:!1}},onLoad:function(t){this.source=this.$Route.query.source,1==this.source&&(this.title="选择收货地址"),this.source&&1!=this.source&&(this.title="选择地址"),uni.setNavigationBarTitle({title:this.title}),this.getAddress()},onShow:function(){setTimeout((function(){uni.getStorage({key:"version",success:function(t){document.title="".concat(document.title," - ").concat(JSON.parse(t.data).site.name)}})}),100)},watch:{refresh:function(t){t&&(this.refresh=!1,this.getAddress())}},methods:{getAddress:function(){var t=this;return(0,o.default)(regeneratorRuntime.mark((function e(){var r;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,t.$request.post("/api/member");case 2:if(r=e.sent,!r.url||-1==r.url.indexOf("login")){e.next=6;break}return uni.showModal({title:"温馨提示",content:r.msg,success:function(e){e.confirm?t.$Router.push({name:"Login"}):t.$Router.back(1)}}),e.abrupt("return");case 6:1==r.code?t.addressList=(0,i.default)(r.data):t.$api.modal(r.msg);case 7:case"end":return e.stop()}}),e)})))()},checkAddress:function(t){return 1==this.source?(this.$api.prePage().addressData=t,void this.$Router.back(1)):"a_site"==this.source?(this.$api.prePage().a_area=t,void this.$Router.back(1)):void("b_site"==this.source&&(this.$api.prePage().b_area=t,this.$Router.back(1)))},addAddress:function(t,e){this.$Router.push({name:"AddressManage",params:{type:t,data:JSON.stringify(e)}})},refreshList:function(t,e){this.addressList.unshift(t)}}};e.default=a},"7d4d":function(t,e,r){"use strict";r.r(e);var n=r("6b0a"),i=r.n(n);for(var o in n)"default"!==o&&function(t){r.d(e,t,(function(){return n[t]}))}(o);e["default"]=i.a},"8da7":function(t,e,r){var n=r("24fb");e=n(!1),e.push([t.i,'@charset "UTF-8";\n/* 页面左右间距 */\n/* 文字尺寸 */\n/*文字颜色*/\n/* 边框颜色 */\n/* 图片加载中颜色 */\n/* 行为相关颜色 */uni-page-body[data-v-d86981ce]{background-color:#fff!important}.content[data-v-d86981ce]{position:relative;padding-bottom:%?120?%}.list[data-v-d86981ce]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;padding:%?20?% %?30?%;background:#fff;position:relative}.wrapper[data-v-d86981ce]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;-webkit-box-flex:1;-webkit-flex:1;flex:1}.address-box[data-v-d86981ce]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.address-box .tag[data-v-d86981ce]{font-size:%?24?%;color:#fa436a;margin-right:%?10?%;background:#fffafb;border:1px solid #ffb4c7;-webkit-border-radius:%?4?%;border-radius:%?4?%;padding:%?4?% %?10?%;line-height:1}.address-box .address[data-v-d86981ce]{font-size:%?30?%;color:#303133}.u-box[data-v-d86981ce]{font-size:%?28?%;color:#909399;margin-top:%?16?%}.u-box .name[data-v-d86981ce]{margin-right:%?30?%}.icon-bianji[data-v-d86981ce]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;height:%?80?%;font-size:%?40?%;color:#909399;padding-left:%?30?%}.add-btn[data-v-d86981ce]{position:fixed;left:%?30?%;right:%?30?%;bottom:%?16?%;z-index:95;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;width:%?690?%;height:%?80?%;font-size:%?32?%;color:#fff;background-color:#fa436a;-webkit-border-radius:%?10?%;border-radius:%?10?%;-webkit-box-shadow:1px 2px 5px rgba(219,63,96,.4);box-shadow:1px 2px 5px rgba(219,63,96,.4)}body.?%PAGE?%[data-v-d86981ce]{background-color:#fff!important}',""]),t.exports=e},"96cf":function(t,e){!function(e){"use strict";var r,n=Object.prototype,i=n.hasOwnProperty,o="function"===typeof Symbol?Symbol:{},a=o.iterator||"@@iterator",s=o.asyncIterator||"@@asyncIterator",c=o.toStringTag||"@@toStringTag",u="object"===typeof t,l=e.regeneratorRuntime;if(l)u&&(t.exports=l);else{l=e.regeneratorRuntime=u?t.exports:{},l.wrap=m;var f="suspendedStart",d="suspendedYield",h="executing",p="completed",v={},b={};b[a]=function(){return this};var g=Object.getPrototypeOf,y=g&&g(g(N([])));y&&y!==n&&i.call(y,a)&&(b=y);var w=L.prototype=k.prototype=Object.create(b);_.prototype=w.constructor=L,L.constructor=_,L[c]=_.displayName="GeneratorFunction",l.isGeneratorFunction=function(t){var e="function"===typeof t&&t.constructor;return!!e&&(e===_||"GeneratorFunction"===(e.displayName||e.name))},l.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,L):(t.__proto__=L,c in t||(t[c]="GeneratorFunction")),t.prototype=Object.create(w),t},l.awrap=function(t){return{__await:t}},E(j.prototype),j.prototype[s]=function(){return this},l.AsyncIterator=j,l.async=function(t,e,r,n){var i=new j(m(t,e,r,n));return l.isGeneratorFunction(e)?i:i.next().then((function(t){return t.done?t.value:i.next()}))},E(w),w[c]="Generator",w[a]=function(){return this},w.toString=function(){return"[object Generator]"},l.keys=function(t){var e=[];for(var r in t)e.push(r);return e.reverse(),function r(){while(e.length){var n=e.pop();if(n in t)return r.value=n,r.done=!1,r}return r.done=!0,r}},l.values=N,C.prototype={constructor:C,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=r,this.done=!1,this.delegate=null,this.method="next",this.arg=r,this.tryEntries.forEach(A),!t)for(var e in this)"t"===e.charAt(0)&&i.call(this,e)&&!isNaN(+e.slice(1))&&(this[e]=r)},stop:function(){this.done=!0;var t=this.tryEntries[0],e=t.completion;if("throw"===e.type)throw e.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var e=this;function n(n,i){return s.type="throw",s.arg=t,e.next=n,i&&(e.method="next",e.arg=r),!!i}for(var o=this.tryEntries.length-1;o>=0;--o){var a=this.tryEntries[o],s=a.completion;if("root"===a.tryLoc)return n("end");if(a.tryLoc<=this.prev){var c=i.call(a,"catchLoc"),u=i.call(a,"finallyLoc");if(c&&u){if(this.prev<a.catchLoc)return n(a.catchLoc,!0);if(this.prev<a.finallyLoc)return n(a.finallyLoc)}else if(c){if(this.prev<a.catchLoc)return n(a.catchLoc,!0)}else{if(!u)throw new Error("try statement without catch or finally");if(this.prev<a.finallyLoc)return n(a.finallyLoc)}}}},abrupt:function(t,e){for(var r=this.tryEntries.length-1;r>=0;--r){var n=this.tryEntries[r];if(n.tryLoc<=this.prev&&i.call(n,"finallyLoc")&&this.prev<n.finallyLoc){var o=n;break}}o&&("break"===t||"continue"===t)&&o.tryLoc<=e&&e<=o.finallyLoc&&(o=null);var a=o?o.completion:{};return a.type=t,a.arg=e,o?(this.method="next",this.next=o.finallyLoc,v):this.complete(a)},complete:function(t,e){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&e&&(this.next=e),v},finish:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var r=this.tryEntries[e];if(r.finallyLoc===t)return this.complete(r.completion,r.afterLoc),A(r),v}},catch:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var r=this.tryEntries[e];if(r.tryLoc===t){var n=r.completion;if("throw"===n.type){var i=n.arg;A(r)}return i}}throw new Error("illegal catch attempt")},delegateYield:function(t,e,n){return this.delegate={iterator:N(t),resultName:e,nextLoc:n},"next"===this.method&&(this.arg=r),v}}}function m(t,e,r,n){var i=e&&e.prototype instanceof k?e:k,o=Object.create(i.prototype),a=new C(n||[]);return o._invoke=O(t,r,a),o}function x(t,e,r){try{return{type:"normal",arg:t.call(e,r)}}catch(n){return{type:"throw",arg:n}}}function k(){}function _(){}function L(){}function E(t){["next","throw","return"].forEach((function(e){t[e]=function(t){return this._invoke(e,t)}}))}function j(t){function e(r,n,o,a){var s=x(t[r],t,n);if("throw"!==s.type){var c=s.arg,u=c.value;return u&&"object"===typeof u&&i.call(u,"__await")?Promise.resolve(u.__await).then((function(t){e("next",t,o,a)}),(function(t){e("throw",t,o,a)})):Promise.resolve(u).then((function(t){c.value=t,o(c)}),(function(t){return e("throw",t,o,a)}))}a(s.arg)}var r;function n(t,n){function i(){return new Promise((function(r,i){e(t,n,r,i)}))}return r=r?r.then(i,i):i()}this._invoke=n}function O(t,e,r){var n=f;return function(i,o){if(n===h)throw new Error("Generator is already running");if(n===p){if("throw"===i)throw o;return R()}r.method=i,r.arg=o;while(1){var a=r.delegate;if(a){var s=P(a,r);if(s){if(s===v)continue;return s}}if("next"===r.method)r.sent=r._sent=r.arg;else if("throw"===r.method){if(n===f)throw n=p,r.arg;r.dispatchException(r.arg)}else"return"===r.method&&r.abrupt("return",r.arg);n=h;var c=x(t,e,r);if("normal"===c.type){if(n=r.done?p:d,c.arg===v)continue;return{value:c.arg,done:r.done}}"throw"===c.type&&(n=p,r.method="throw",r.arg=c.arg)}}}function P(t,e){var n=t.iterator[e.method];if(n===r){if(e.delegate=null,"throw"===e.method){if(t.iterator.return&&(e.method="return",e.arg=r,P(t,e),"throw"===e.method))return v;e.method="throw",e.arg=new TypeError("The iterator does not provide a 'throw' method")}return v}var i=x(n,t.iterator,e.arg);if("throw"===i.type)return e.method="throw",e.arg=i.arg,e.delegate=null,v;var o=i.arg;return o?o.done?(e[t.resultName]=o.value,e.next=t.nextLoc,"return"!==e.method&&(e.method="next",e.arg=r),e.delegate=null,v):o:(e.method="throw",e.arg=new TypeError("iterator result is not an object"),e.delegate=null,v)}function $(t){var e={tryLoc:t[0]};1 in t&&(e.catchLoc=t[1]),2 in t&&(e.finallyLoc=t[2],e.afterLoc=t[3]),this.tryEntries.push(e)}function A(t){var e=t.completion||{};e.type="normal",delete e.arg,t.completion=e}function C(t){this.tryEntries=[{tryLoc:"root"}],t.forEach($,this),this.reset(!0)}function N(t){if(t){var e=t[a];if(e)return e.call(t);if("function"===typeof t.next)return t;if(!isNaN(t.length)){var n=-1,o=function e(){while(++n<t.length)if(i.call(t,n))return e.value=t[n],e.done=!1,e;return e.value=r,e.done=!0,e};return o.next=o}}return{next:R}}function R(){return{value:r,done:!0}}}(function(){return this||"object"===typeof self&&self}()||Function("return this")())},b365:function(t,e,r){"use strict";var n=r("4728"),i=r.n(n);i.a}}]);