(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-spell-spellGroup_records"],{"1da1":function(t,e,n){"use strict";function r(t,e,n,r,i,o,a){try{var s=t[o](a),c=s.value}catch(u){return void n(u)}s.done?e(c):Promise.resolve(c).then(r,i)}function i(t){return function(){var e=this,n=arguments;return new Promise((function(i,o){var a=t.apply(e,n);function s(t){r(a,i,o,s,c,"next",t)}function c(t){r(a,i,o,s,c,"throw",t)}s(void 0)}))}}n("d3b7"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=i},"33b4":function(t,e,n){"use strict";var r=n("4ea4");n("99af"),n("4160"),n("c975"),n("e25e"),n("159b"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var i=r(n("2909"));n("96cf");var o=r(n("1da1")),a=r(n("65ee")),s={data:function(){return{list:[],noFlag:!1,refresh:!1,timer:null,seconds:300,demo:{h:"00",i:"05",s:"00"},scrollTop:0,isMore:!0,page:0}},watch:{refresh:function(t){t&&(this.refresh=!1,this.page=0,this.getLogs())}},onLoad:function(){this.page=0,this.getLogs()},onShow:function(){uni.getStorage({key:"version",success:function(t){document.title="".concat(document.title," - ").concat(JSON.parse(t.data).site.name)}})},onPageScroll:function(t){this.scrollTop=t.scrollTop},onReachBottom:function(){this.isMore&&(this.page+=1,this.getLogs())},onNavigationBarButtonTap:function(t){var e=t.index;0===e&&this.$Router.push({name:"SpellGroupRecords"})},methods:{navTo:function(t){this.$Router.push({name:t})},invite:function(t,e){var n=this,r="".concat(this.$request.baseUrl,"/#/spellGroupShare?id=").concat(t,"&parent_id=").concat(e);(0,a.default)({content:r,success:function(t){n.$api.msg(t)},error:function(t){n.$api.msg(t,"none")}})},getLogs:function(){var t=this;return(0,o.default)(regeneratorRuntime.mark((function e(){var n;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,t.$request.post("/api/plugin.hasog_pintuan-index-index-log",{page:t.page});case 2:if(n=e.sent,-1==n.msg.indexOf("登录")){e.next=6;break}return uni.showModal({title:"温馨提示",content:n.msg,success:function(e){e.confirm?t.$Router.push({name:"Login"}):t.$Router.back(1)}}),e.abrupt("return");case 6:if(1!=n.code){e.next=16;break}if(0!=t.page||0!=n.data.length){e.next=10;break}return t.noFlag=!0,e.abrupt("return");case 10:t.list=[].concat((0,i.default)(t.list),(0,i.default)(n.data)),t.list.forEach((function(e){t.$set(e,"djs",t.demo),e.pintuanlist.endtiem>parseInt((new Date).getTime()/1e3)?t.$set(e,"showCount",!1):t.$set(e,"showCount",!0)})),t.startData(),0==n.data.length&&(t.isMore=!1),e.next=17;break;case 16:t.$api.modal(n.msg);case 17:case"end":return e.stop()}}),e)})))()},timeUp:function(){clearInterval(this.timer)},countDown:function(t,e){var n=e,r=0,i=0,o=0,a=0;n>0?(r=Math.floor(n/86400),i=Math.floor(n/3600)-24*r,o=Math.floor(n/60)-24*r*60-60*i,a=Math.floor(n)-24*r*60*60-60*i*60-60*o):(this.timeUp(),this.$set(this.list[t],"showCount",!0)),r<10&&(r="0"+r),i<10&&(i="0"+i),o<10&&(o="0"+o),a<10&&(a="0"+a);var s={d:r,h:i,i:o,s:a};return s},startData:function(){var t=this,e=function(e){if(t.list[e]){var n=t.list[e].pintuanlist.endtiem;n>parseInt((new Date).getTime()/1e3)&&(n-=parseInt((new Date).getTime()/1e3),t.timer=setInterval((function(){n--,t.list[e].djs=t.countDown(e,n)}),1e3))}};for(var n in this.list)e(n)}}};e.default=s},6140:function(t,e,n){"use strict";n.r(e);var r=n("74fa"),i=n("ef19");for(var o in i)"default"!==o&&function(t){n.d(e,t,(function(){return i[t]}))}(o);n("ef97");var a,s=n("f0c5"),c=Object(s["a"])(i["default"],r["b"],r["c"],!1,null,"2edce847",null,!1,r["a"],a);e["default"]=c.exports},"65ee":function(t,e,n){"use strict";function r(t){var e=t.content,n=t.success,r=t.error;if(!e)return r("复制的内容不能为空 !");e="string"===typeof e?e:e.toString(),document.queryCommandSupported("copy")||r("浏览器不支持");var i=document.createElement("textarea");i.value=e,i.readOnly="readOnly",document.body.appendChild(i),i.select(),i.setSelectionRange(0,e.length);var o=document.execCommand("copy");o?n("复制成功~"):r("复制失败，请检查h5中调用该方法的方式，是不是用户点击的方式调用的，如果不是请改为用户点击的方式触发该方法，因为h5中安全性，不能js直接调用！"),i.remove()}n("d3b7"),n("25f0"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=r},"6bd0":function(t,e,n){var r=n("24fb");e=r(!1),e.push([t.i,'@charset "UTF-8";\n/* 页面左右间距 */\n/* 文字尺寸 */\n/*文字颜色*/\n/* 边框颜色 */\n/* 图片加载中颜色 */\n/* 行为相关颜色 */uni-page-body[data-v-2edce847]{background-color:#fff!important}body.?%PAGE?%[data-v-2edce847]{background-color:#fff!important}',""]),t.exports=e},"74fa":function(t,e,n){"use strict";var r;n.d(e,"b",(function(){return i})),n.d(e,"c",(function(){return o})),n.d(e,"a",(function(){return r}));var i=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("v-uni-view",{staticClass:"container"},[t.noFlag?n("empty"):n("v-uni-view",{staticClass:"goods-list"},t._l(t.list,(function(e,r){return e.pintuanlist?n("v-uni-view",{key:r,staticClass:"list-item"},[n("v-uni-view",{staticClass:"time"},[t._v(t._s(t.$api.tier(e.time)))]),n("v-uni-view",{staticClass:"item"},[n("v-uni-view",{staticClass:"img"},[n("v-uni-image",{attrs:{src:e.pintuanlist.pic||"/static/errorImage.jpg",mode:""}}),n("v-uni-view",{staticClass:"state"})],1),n("v-uni-view",{staticClass:"d"},[n("v-uni-view",{staticClass:"title"},[n("v-uni-view",[t._v(t._s(e.pintuanlist.title))])],1),n("v-uni-view",{staticClass:"peple"},[n("v-uni-view",[n("v-uni-text",{staticClass:"iconfont icon-ziyuan1"}),t._v(t._s(e.pintuanlist.goods_max)+"人团")],1)],1),n("v-uni-view",{staticClass:"price"},[n("v-uni-view",{staticClass:"price-l"},[n("v-uni-view",{staticClass:"goods_price"},[n("v-uni-text",{staticClass:"price-icon"},[t._v("￥")]),t._v(t._s(e.price)),n("v-uni-text",[t._v("共"+t._s(e.total)+"份")])],1),n("v-uni-view",{staticClass:"progress"},[n("v-uni-view",{staticClass:"txt",style:{width:(Math.round(e.pintuanlist.goods_num/e.pintuanlist.goods_max*100*100)/100).toFixed(2)+"%"}})],1),n("v-uni-view",{staticStyle:{color:"#999"}},[t._v("进度 "+t._s((Math.round(e.pintuanlist.goods_num/e.pintuanlist.goods_max*100*100)/100).toFixed(2))+"%")])],1),n("v-uni-view",{staticClass:"exchange",class:Math.round(e.pintuanlist.goods_num/e.pintuanlist.goods_max*100*100)/100!=100&&0==e.state?"":"hide",on:{click:function(n){arguments[0]=n=t.$handleEvent(n),t.invite(e.pintuanlist.id,e.uid)}}},[t._v("去分享"),n("v-uni-text",{staticClass:"yticon icon-you"})],1),1==e.state?n("v-uni-view",{staticClass:"exchange",staticStyle:{"background-color":"#41c5ea"}},[t._v("结算中")]):t._e(),2==e.state?n("v-uni-view",{staticClass:"exchange",staticStyle:{"background-color":"#FF530E",opacity:"0.8"}},[t._v("已完成")]):t._e(),-1==e.state?n("v-uni-view",{staticClass:"exchange",staticStyle:{"background-color":"#c3bbbd"}},[t._v("已结束")]):t._e()],1)],1)],1),n("v-uni-view",{staticClass:"count"},[e.showCount&&1==e.zj?n("v-uni-text",{staticClass:"maxw",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.navTo("SpellGroupWin")}}},[t._v("恭喜您 中奖啦! 点此去兑奖吧"),n("v-uni-text",{staticClass:"yticon icon-you"})],1):t._e(),e.showCount&&-1==e.zj?n("v-uni-text",{staticClass:"maxw"},[t._v("很遗憾您未中奖")]):t._e(),e.pintuanlist.endtiem>parseInt((new Date).getTime()/1e3)?n("v-uni-view",{staticClass:"maxw"},[t._v("已成团!"),n("v-uni-text",{staticClass:"time"},[t._v(t._s(e.djs.i)+":"+t._s(e.djs.s))]),t._v("后系统自动抽奖")],1):t._e()],1)],1):t._e()})),1),t.isMore?t._e():n("v-uni-view",{staticClass:"noMore"},[t._v("没有更多数据了")]),n("back-top",{attrs:{scrollTop:t.scrollTop}})],1)},o=[]},"96cf":function(t,e){!function(e){"use strict";var n,r=Object.prototype,i=r.hasOwnProperty,o="function"===typeof Symbol?Symbol:{},a=o.iterator||"@@iterator",s=o.asyncIterator||"@@asyncIterator",c=o.toStringTag||"@@toStringTag",u="object"===typeof t,l=e.regeneratorRuntime;if(l)u&&(t.exports=l);else{l=e.regeneratorRuntime=u?t.exports:{},l.wrap=_;var f="suspendedStart",h="suspendedYield",v="executing",p="completed",d={},g={};g[a]=function(){return this};var m=Object.getPrototypeOf,y=m&&m(m($([])));y&&y!==r&&i.call(y,a)&&(g=y);var w=L.prototype=b.prototype=Object.create(g);C.prototype=w.constructor=L,L.constructor=C,L[c]=C.displayName="GeneratorFunction",l.isGeneratorFunction=function(t){var e="function"===typeof t&&t.constructor;return!!e&&(e===C||"GeneratorFunction"===(e.displayName||e.name))},l.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,L):(t.__proto__=L,c in t||(t[c]="GeneratorFunction")),t.prototype=Object.create(w),t},l.awrap=function(t){return{__await:t}},E(k.prototype),k.prototype[s]=function(){return this},l.AsyncIterator=k,l.async=function(t,e,n,r){var i=new k(_(t,e,n,r));return l.isGeneratorFunction(e)?i:i.next().then((function(t){return t.done?t.value:i.next()}))},E(w),w[c]="Generator",w[a]=function(){return this},w.toString=function(){return"[object Generator]"},l.keys=function(t){var e=[];for(var n in t)e.push(n);return e.reverse(),function n(){while(e.length){var r=e.pop();if(r in t)return n.value=r,n.done=!1,n}return n.done=!0,n}},l.values=$,T.prototype={constructor:T,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=n,this.done=!1,this.delegate=null,this.method="next",this.arg=n,this.tryEntries.forEach(M),!t)for(var e in this)"t"===e.charAt(0)&&i.call(this,e)&&!isNaN(+e.slice(1))&&(this[e]=n)},stop:function(){this.done=!0;var t=this.tryEntries[0],e=t.completion;if("throw"===e.type)throw e.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var e=this;function r(r,i){return s.type="throw",s.arg=t,e.next=r,i&&(e.method="next",e.arg=n),!!i}for(var o=this.tryEntries.length-1;o>=0;--o){var a=this.tryEntries[o],s=a.completion;if("root"===a.tryLoc)return r("end");if(a.tryLoc<=this.prev){var c=i.call(a,"catchLoc"),u=i.call(a,"finallyLoc");if(c&&u){if(this.prev<a.catchLoc)return r(a.catchLoc,!0);if(this.prev<a.finallyLoc)return r(a.finallyLoc)}else if(c){if(this.prev<a.catchLoc)return r(a.catchLoc,!0)}else{if(!u)throw new Error("try statement without catch or finally");if(this.prev<a.finallyLoc)return r(a.finallyLoc)}}}},abrupt:function(t,e){for(var n=this.tryEntries.length-1;n>=0;--n){var r=this.tryEntries[n];if(r.tryLoc<=this.prev&&i.call(r,"finallyLoc")&&this.prev<r.finallyLoc){var o=r;break}}o&&("break"===t||"continue"===t)&&o.tryLoc<=e&&e<=o.finallyLoc&&(o=null);var a=o?o.completion:{};return a.type=t,a.arg=e,o?(this.method="next",this.next=o.finallyLoc,d):this.complete(a)},complete:function(t,e){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&e&&(this.next=e),d},finish:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var n=this.tryEntries[e];if(n.finallyLoc===t)return this.complete(n.completion,n.afterLoc),M(n),d}},catch:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var n=this.tryEntries[e];if(n.tryLoc===t){var r=n.completion;if("throw"===r.type){var i=r.arg;M(n)}return i}}throw new Error("illegal catch attempt")},delegateYield:function(t,e,r){return this.delegate={iterator:$(t),resultName:e,nextLoc:r},"next"===this.method&&(this.arg=n),d}}}function _(t,e,n,r){var i=e&&e.prototype instanceof b?e:b,o=Object.create(i.prototype),a=new T(r||[]);return o._invoke=j(t,n,a),o}function x(t,e,n){try{return{type:"normal",arg:t.call(e,n)}}catch(r){return{type:"throw",arg:r}}}function b(){}function C(){}function L(){}function E(t){["next","throw","return"].forEach((function(e){t[e]=function(t){return this._invoke(e,t)}}))}function k(t){function e(n,r,o,a){var s=x(t[n],t,r);if("throw"!==s.type){var c=s.arg,u=c.value;return u&&"object"===typeof u&&i.call(u,"__await")?Promise.resolve(u.__await).then((function(t){e("next",t,o,a)}),(function(t){e("throw",t,o,a)})):Promise.resolve(u).then((function(t){c.value=t,o(c)}),(function(t){return e("throw",t,o,a)}))}a(s.arg)}var n;function r(t,r){function i(){return new Promise((function(n,i){e(t,r,n,i)}))}return n=n?n.then(i,i):i()}this._invoke=r}function j(t,e,n){var r=f;return function(i,o){if(r===v)throw new Error("Generator is already running");if(r===p){if("throw"===i)throw o;return F()}n.method=i,n.arg=o;while(1){var a=n.delegate;if(a){var s=S(a,n);if(s){if(s===d)continue;return s}}if("next"===n.method)n.sent=n._sent=n.arg;else if("throw"===n.method){if(r===f)throw r=p,n.arg;n.dispatchException(n.arg)}else"return"===n.method&&n.abrupt("return",n.arg);r=v;var c=x(t,e,n);if("normal"===c.type){if(r=n.done?p:h,c.arg===d)continue;return{value:c.arg,done:n.done}}"throw"===c.type&&(r=p,n.method="throw",n.arg=c.arg)}}}function S(t,e){var r=t.iterator[e.method];if(r===n){if(e.delegate=null,"throw"===e.method){if(t.iterator.return&&(e.method="return",e.arg=n,S(t,e),"throw"===e.method))return d;e.method="throw",e.arg=new TypeError("The iterator does not provide a 'throw' method")}return d}var i=x(r,t.iterator,e.arg);if("throw"===i.type)return e.method="throw",e.arg=i.arg,e.delegate=null,d;var o=i.arg;return o?o.done?(e[t.resultName]=o.value,e.next=t.nextLoc,"return"!==e.method&&(e.method="next",e.arg=n),e.delegate=null,d):o:(e.method="throw",e.arg=new TypeError("iterator result is not an object"),e.delegate=null,d)}function O(t){var e={tryLoc:t[0]};1 in t&&(e.catchLoc=t[1]),2 in t&&(e.finallyLoc=t[2],e.afterLoc=t[3]),this.tryEntries.push(e)}function M(t){var e=t.completion||{};e.type="normal",delete e.arg,t.completion=e}function T(t){this.tryEntries=[{tryLoc:"root"}],t.forEach(O,this),this.reset(!0)}function $(t){if(t){var e=t[a];if(e)return e.call(t);if("function"===typeof t.next)return t;if(!isNaN(t.length)){var r=-1,o=function e(){while(++r<t.length)if(i.call(t,r))return e.value=t[r],e.done=!1,e;return e.value=n,e.done=!0,e};return o.next=o}}return{next:F}}function F(){return{value:n,done:!0}}}(function(){return this||"object"===typeof self&&self}()||Function("return this")())},e16e:function(t,e,n){var r=n("6bd0");"string"===typeof r&&(r=[[t.i,r,""]]),r.locals&&(t.exports=r.locals);var i=n("4f06").default;i("7ad42210",r,!0,{sourceMap:!1,shadowMode:!1})},ef19:function(t,e,n){"use strict";n.r(e);var r=n("33b4"),i=n.n(r);for(var o in r)"default"!==o&&function(t){n.d(e,t,(function(){return r[t]}))}(o);e["default"]=i.a},ef97:function(t,e,n){"use strict";var r=n("e16e"),i=n.n(r);i.a}}]);