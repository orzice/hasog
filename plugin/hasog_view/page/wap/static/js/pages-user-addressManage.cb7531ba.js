(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-user-addressManage"],{"1da1":function(t,e,r){"use strict";function n(t,e,r,n,a,i,o){try{var s=t[i](o),c=s.value}catch(u){return void r(u)}s.done?e(c):Promise.resolve(c).then(n,a)}function a(t){return function(){var e=this,r=arguments;return new Promise((function(a,i){var o=t.apply(e,r);function s(t){n(o,a,i,s,c,"next",t)}function c(t){n(o,a,i,s,c,"throw",t)}s(void 0)}))}}r("d3b7"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=a},"691a":function(t,e,r){"use strict";r.r(e);var n=r("bd2c"),a=r("f921");for(var i in a)"default"!==i&&function(t){r.d(e,t,(function(){return a[t]}))}(i);r("7745");var o,s=r("f0c5"),c=Object(s["a"])(a["default"],n["b"],n["c"],!1,null,"5d966502",null,!1,n["a"],o);e["default"]=c.exports},"6a79":function(t,e,r){var n=r("24fb");e=n(!1),e.push([t.i,'@charset "UTF-8";\n/* 页面左右间距 */\n/* 文字尺寸 */\n/*文字颜色*/\n/* 边框颜色 */\n/* 图片加载中颜色 */\n/* 行为相关颜色 */.content[data-v-5d966502]{padding-top:%?16?%}.row[data-v-5d966502]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;position:relative;padding:0 %?30?%;height:%?110?%;background:#fff}.row .tit[data-v-5d966502]{-webkit-flex-shrink:0;flex-shrink:0;width:%?120?%;font-size:%?30?%;color:#303133}.row .input[data-v-5d966502]{-webkit-box-flex:1;-webkit-flex:1;flex:1;font-size:%?30?%;color:#303133}.row .icon-shouhuodizhi[data-v-5d966502]{font-size:%?36?%;color:#909399}.area[data-v-5d966502]{height:auto}.area .area-select[data-v-5d966502]{line-height:%?80?%}.area .area-select .grey[data-v-5d966502]{color:#909399}.default-row[data-v-5d966502]{margin-top:%?16?%}.default-row .tit[data-v-5d966502]{-webkit-box-flex:1;-webkit-flex:1;flex:1}.default-row uni-switch[data-v-5d966502]{-webkit-transform:translateX(%?16?%) scale(.9);transform:translateX(%?16?%) scale(.9)}.add-btn[data-v-5d966502]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;width:%?690?%;height:%?80?%;margin:%?-40?% auto;font-size:%?32?%;color:#fff;background-color:#fa436a;-webkit-border-radius:%?10?%;border-radius:%?10?%;-webkit-box-shadow:1px 2px 5px rgba(219,63,96,.4);box-shadow:1px 2px 5px rgba(219,63,96,.4)}.del-btn[data-v-5d966502]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;width:%?690?%;height:%?80?%;margin:%?60?% auto;font-size:%?32?%;color:#000;background-color:#fff;-webkit-border-radius:%?10?%;border-radius:%?10?%;-webkit-box-shadow:1px 2px 5px rgba(0,0,0,.1);box-shadow:1px 2px 5px rgba(0,0,0,.1)}.fix-end[data-v-5d966502]{width:100%;position:fixed;bottom:%?56?%;left:0}',""]),t.exports=e},7745:function(t,e,r){"use strict";var n=r("b2f8"),a=r.n(n);a.a},"8ab4":function(t,e,r){"use strict";var n=r("4ea4");r("99af"),r("c975"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var a=n(r("2909"));r("96cf");var i=n(r("1da1")),o={data:function(){return{title:"新增收货地址",addressData:{name:"",connect_mobile:"",addressName:"在地图选择",address:"",area:"",is_default:!1},isFirst:!0,pIndex:-1,provinces:[],pArr:null,province_id:0,cIndex:-1,citys:[],cArr:null,city_id:0,aIndex:-1,areas:[],aArr:null,area_id:0,isedit:!1}},onLoad:function(t){var e=this.$Route.query;if("edit"===e.type){this.addressData={},this.title="修改收货地址",this.isedit=!0;var r=JSON.parse(e.data);this.addressData=r,this.province_id=r.province_id,this.city_id=r.city_id,this.area_id=r.district_id}this.manageType=e.type,uni.setNavigationBarTitle({title:this.title}),this.getProvince()},onShow:function(){setTimeout((function(){uni.getStorage({key:"version",success:function(t){document.title="".concat(document.title," - ").concat(JSON.parse(t.data).site.name)}})}),100)},methods:{switchChange:function(t){this.addressData.is_default=t.detail.value},getProvince:function(){var t=this;return(0,i.default)(regeneratorRuntime.mark((function e(){var r,n;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,t.$request.get("/api/area",{pid:0,deep:0});case 2:for(r=e.sent,t.getCity(t.province_id),t.pArr=(0,a.default)(r.data),n=0;n<t.pArr.length;n++)t.pArr[n].ext_name&&t.provinces.push(t.pArr[n].ext_name),t.pArr[n].id==t.province_id&&(t.pIndex=n);case 6:case"end":return e.stop()}}),e)})))()},getCity:function(t){var e=this;return(0,i.default)(regeneratorRuntime.mark((function r(){var n,i,o,s;return regeneratorRuntime.wrap((function(r){while(1)switch(r.prev=r.next){case 0:return n=[],r.next=3,e.$request.get("/api/area",{pid:t,deep:1});case 3:if(i=r.sent,e.cArr=(0,a.default)(i.data),e.isFirst)for(e.getArea(e.city_id),o=0;o<e.cArr.length;o++)n.push(e.cArr[o].ext_name),e.cArr[o].id==e.city_id&&(e.cIndex=o);else for(e.cIndex=-1,e.aIndex=-1,e.getArea(t),s=0;s<e.cArr.length;s++)n.push(e.cArr[s].ext_name),e.cArr[s].id==t&&(e.cIndex=s),e.cIndex=-1;e.citys=[].concat(n);case 7:case"end":return r.stop()}}),r)})))()},getArea:function(t){var e=this;return(0,i.default)(regeneratorRuntime.mark((function r(){var n,i,o,s;return regeneratorRuntime.wrap((function(r){while(1)switch(r.prev=r.next){case 0:return n=[],r.next=3,e.$request.get("/api/area",{pid:t,deep:2});case 3:if(i=r.sent,e.aArr=(0,a.default)(i.data),e.isFirst)for(o=0;o<e.aArr.length;o++)n.push(e.aArr[o].ext_name),e.aArr[o].id==e.area_id&&(e.aIndex=o);else for(e.aIndex=-1,s=0;s<e.aArr.length;s++)n.push(e.aArr[s].ext_name);e.areas=[].concat(n);case 7:case"end":return r.stop()}}),r)})))()},provinceChange:function(t){this.isFirst=!1,this.pIndex=t.detail.value;var e=this.pArr[this.pIndex].id;this.getCity(e)},cityChange:function(t){this.isFirst=!1,this.cIndex=t.detail.value;var e=this.cArr[this.cIndex].id;this.getArea(e)},areaChange:function(t){this.aIndex=t.detail.value},chooseLocation:function(){var t=this;uni.chooseLocation({success:function(e){t.addressData.addressName=e.name,t.addressData.address=e.name}})},confirm:function(t){var e=this;return(0,i.default)(regeneratorRuntime.mark((function r(){var n,a,i,o;return regeneratorRuntime.wrap((function(r){while(1)switch(r.prev=r.next){case 0:if(n=t.detail.value,n.name){r.next=4;break}return e.$api.msg("请填写收货人姓名","loading",1500),r.abrupt("return");case 4:if(/(^1[3|4|5|7|8][0-9]{9}$)/.test(n.mobile)){r.next=7;break}return e.$api.msg("请输入正确的手机号码","loading",1500),r.abrupt("return");case 7:if(e.cArr){r.next=10;break}return e.$api.msg("请选择省","loading",1500),r.abrupt("return");case 10:if(e.aArr){r.next=13;break}return e.$api.msg("请选择市","loading",1500),r.abrupt("return");case 13:if(-1!=e.aIndex){r.next=16;break}return e.$api.msg("请选择县/区","loading",1500),r.abrupt("return");case 16:if(n.address){r.next=19;break}return e.$api.msg("请填写详细地址","loading",1500),r.abrupt("return");case 19:if(a={name:n.name,connect_mobile:n.mobile,province_id:e.pArr[n.province_id].id,city_id:e.cArr[n.city_id]?e.cArr[n.city_id].id:0,district_id:e.aArr[n.district_id]?e.aArr[n.district_id].id:0,area:n.address,is_default:e.addressData.is_default?1:0},i={name:n.name,connect_mobile:n.mobile,province_id:e.pArr[n.province_id].id,city_id:e.cArr[n.city_id]?e.cArr[n.city_id].id:0,district_id:e.aArr[n.district_id]?e.aArr[n.district_id].id:0,area:n.address,is_default:e.addressData.is_default?1:0,id:e.addressData.id},!e.isedit){r.next=27;break}return r.next=24,e.$request.post("/api/member/edit",i);case 24:o=r.sent,r.next=30;break;case 27:return r.next=29,e.$request.post("/api/member/add",a);case 29:o=r.sent;case 30:if(!o.url||-1==o.url.indexOf("login")){r.next=33;break}return uni.showModal({title:"温馨提示",content:o.msg,success:function(t){t.confirm&&e.$Router.push({name:"Login"})}}),r.abrupt("return");case 33:1==o.code?(e.$api.msg(o.msg),e.$api.prePage().refresh=!0,setTimeout((function(){e.$Router.back(1)}),1e3)):e.$api.modal(o.msg);case 34:case"end":return r.stop()}}),r)})))()},del:function(){var t=this;return(0,i.default)(regeneratorRuntime.mark((function e(){var r;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,t.$request.post("/api/member/del",{id:t.addressData.id});case 2:if(r=e.sent,!r.url||-1==r.url.indexOf("login")){e.next=6;break}return uni.showModal({title:"温馨提示",content:r.msg,success:function(e){e.confirm&&t.$Router.push({name:"Login"})}}),e.abrupt("return");case 6:1==r.code?(t.$api.msg(r.msg),t.$api.prePage().refresh=!0,setTimeout((function(){t.$Router.back(1)}),1500)):t.$api.modal(r.msg);case 7:case"end":return e.stop()}}),e)})))()}}};e.default=o},"96cf":function(t,e){!function(e){"use strict";var r,n=Object.prototype,a=n.hasOwnProperty,i="function"===typeof Symbol?Symbol:{},o=i.iterator||"@@iterator",s=i.asyncIterator||"@@asyncIterator",c=i.toStringTag||"@@toStringTag",u="object"===typeof t,d=e.regeneratorRuntime;if(d)u&&(t.exports=d);else{d=e.regeneratorRuntime=u?t.exports:{},d.wrap=b;var l="suspendedStart",f="suspendedYield",p="executing",h="completed",v={},g={};g[o]=function(){return this};var m=Object.getPrototypeOf,x=m&&m(m(O([])));x&&x!==n&&a.call(x,o)&&(g=x);var y=A.prototype=_.prototype=Object.create(g);k.prototype=y.constructor=A,A.constructor=k,A[c]=k.displayName="GeneratorFunction",d.isGeneratorFunction=function(t){var e="function"===typeof t&&t.constructor;return!!e&&(e===k||"GeneratorFunction"===(e.displayName||e.name))},d.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,A):(t.__proto__=A,c in t||(t[c]="GeneratorFunction")),t.prototype=Object.create(y),t},d.awrap=function(t){return{__await:t}},L($.prototype),$.prototype[s]=function(){return this},d.AsyncIterator=$,d.async=function(t,e,r,n){var a=new $(b(t,e,r,n));return d.isGeneratorFunction(e)?a:a.next().then((function(t){return t.done?t.value:a.next()}))},L(y),y[c]="Generator",y[o]=function(){return this},y.toString=function(){return"[object Generator]"},d.keys=function(t){var e=[];for(var r in t)e.push(r);return e.reverse(),function r(){while(e.length){var n=e.pop();if(n in t)return r.value=n,r.done=!1,r}return r.done=!0,r}},d.values=O,D.prototype={constructor:D,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=r,this.done=!1,this.delegate=null,this.method="next",this.arg=r,this.tryEntries.forEach(j),!t)for(var e in this)"t"===e.charAt(0)&&a.call(this,e)&&!isNaN(+e.slice(1))&&(this[e]=r)},stop:function(){this.done=!0;var t=this.tryEntries[0],e=t.completion;if("throw"===e.type)throw e.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var e=this;function n(n,a){return s.type="throw",s.arg=t,e.next=n,a&&(e.method="next",e.arg=r),!!a}for(var i=this.tryEntries.length-1;i>=0;--i){var o=this.tryEntries[i],s=o.completion;if("root"===o.tryLoc)return n("end");if(o.tryLoc<=this.prev){var c=a.call(o,"catchLoc"),u=a.call(o,"finallyLoc");if(c&&u){if(this.prev<o.catchLoc)return n(o.catchLoc,!0);if(this.prev<o.finallyLoc)return n(o.finallyLoc)}else if(c){if(this.prev<o.catchLoc)return n(o.catchLoc,!0)}else{if(!u)throw new Error("try statement without catch or finally");if(this.prev<o.finallyLoc)return n(o.finallyLoc)}}}},abrupt:function(t,e){for(var r=this.tryEntries.length-1;r>=0;--r){var n=this.tryEntries[r];if(n.tryLoc<=this.prev&&a.call(n,"finallyLoc")&&this.prev<n.finallyLoc){var i=n;break}}i&&("break"===t||"continue"===t)&&i.tryLoc<=e&&e<=i.finallyLoc&&(i=null);var o=i?i.completion:{};return o.type=t,o.arg=e,i?(this.method="next",this.next=i.finallyLoc,v):this.complete(o)},complete:function(t,e){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&e&&(this.next=e),v},finish:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var r=this.tryEntries[e];if(r.finallyLoc===t)return this.complete(r.completion,r.afterLoc),j(r),v}},catch:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var r=this.tryEntries[e];if(r.tryLoc===t){var n=r.completion;if("throw"===n.type){var a=n.arg;j(r)}return a}}throw new Error("illegal catch attempt")},delegateYield:function(t,e,n){return this.delegate={iterator:O(t),resultName:e,nextLoc:n},"next"===this.method&&(this.arg=r),v}}}function b(t,e,r,n){var a=e&&e.prototype instanceof _?e:_,i=Object.create(a.prototype),o=new D(n||[]);return i._invoke=C(t,r,o),i}function w(t,e,r){try{return{type:"normal",arg:t.call(e,r)}}catch(n){return{type:"throw",arg:n}}}function _(){}function k(){}function A(){}function L(t){["next","throw","return"].forEach((function(e){t[e]=function(t){return this._invoke(e,t)}}))}function $(t){function e(r,n,i,o){var s=w(t[r],t,n);if("throw"!==s.type){var c=s.arg,u=c.value;return u&&"object"===typeof u&&a.call(u,"__await")?Promise.resolve(u.__await).then((function(t){e("next",t,i,o)}),(function(t){e("throw",t,i,o)})):Promise.resolve(u).then((function(t){c.value=t,i(c)}),(function(t){return e("throw",t,i,o)}))}o(s.arg)}var r;function n(t,n){function a(){return new Promise((function(r,a){e(t,n,r,a)}))}return r=r?r.then(a,a):a()}this._invoke=n}function C(t,e,r){var n=l;return function(a,i){if(n===p)throw new Error("Generator is already running");if(n===h){if("throw"===a)throw i;return R()}r.method=a,r.arg=i;while(1){var o=r.delegate;if(o){var s=I(o,r);if(s){if(s===v)continue;return s}}if("next"===r.method)r.sent=r._sent=r.arg;else if("throw"===r.method){if(n===l)throw n=h,r.arg;r.dispatchException(r.arg)}else"return"===r.method&&r.abrupt("return",r.arg);n=p;var c=w(t,e,r);if("normal"===c.type){if(n=r.done?h:f,c.arg===v)continue;return{value:c.arg,done:r.done}}"throw"===c.type&&(n=h,r.method="throw",r.arg=c.arg)}}}function I(t,e){var n=t.iterator[e.method];if(n===r){if(e.delegate=null,"throw"===e.method){if(t.iterator.return&&(e.method="return",e.arg=r,I(t,e),"throw"===e.method))return v;e.method="throw",e.arg=new TypeError("The iterator does not provide a 'throw' method")}return v}var a=w(n,t.iterator,e.arg);if("throw"===a.type)return e.method="throw",e.arg=a.arg,e.delegate=null,v;var i=a.arg;return i?i.done?(e[t.resultName]=i.value,e.next=t.nextLoc,"return"!==e.method&&(e.method="next",e.arg=r),e.delegate=null,v):i:(e.method="throw",e.arg=new TypeError("iterator result is not an object"),e.delegate=null,v)}function E(t){var e={tryLoc:t[0]};1 in t&&(e.catchLoc=t[1]),2 in t&&(e.finallyLoc=t[2],e.afterLoc=t[3]),this.tryEntries.push(e)}function j(t){var e=t.completion||{};e.type="normal",delete e.arg,t.completion=e}function D(t){this.tryEntries=[{tryLoc:"root"}],t.forEach(E,this),this.reset(!0)}function O(t){if(t){var e=t[o];if(e)return e.call(t);if("function"===typeof t.next)return t;if(!isNaN(t.length)){var n=-1,i=function e(){while(++n<t.length)if(a.call(t,n))return e.value=t[n],e.done=!1,e;return e.value=r,e.done=!0,e};return i.next=i}}return{next:R}}function R(){return{value:r,done:!0}}}(function(){return this||"object"===typeof self&&self}()||Function("return this")())},b2f8:function(t,e,r){var n=r("6a79");"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var a=r("4f06").default;a("2add5704",n,!0,{sourceMap:!1,shadowMode:!1})},bd2c:function(t,e,r){"use strict";var n;r.d(e,"b",(function(){return a})),r.d(e,"c",(function(){return i})),r.d(e,"a",(function(){return n}));var a=function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("v-uni-view",{staticClass:"content"},[r("nav-bar",[t._v(t._s(t.title))]),r("v-uni-form",{on:{submit:function(e){arguments[0]=e=t.$handleEvent(e),t.confirm.apply(void 0,arguments)}}},[r("v-uni-view",{staticClass:"row b-b"},[r("v-uni-text",{staticClass:"tit"},[t._v("联系人")]),r("v-uni-input",{staticClass:"input",attrs:{type:"text",placeholder:"收货人姓名","placeholder-class":"placeholder",name:"name"},model:{value:t.addressData.name,callback:function(e){t.$set(t.addressData,"name",e)},expression:"addressData.name"}})],1),r("v-uni-view",{staticClass:"row b-b"},[r("v-uni-text",{staticClass:"tit"},[t._v("手机号")]),r("v-uni-input",{staticClass:"input",attrs:{type:"number",placeholder:"收货人手机号码","placeholder-class":"placeholder",name:"mobile"},model:{value:t.addressData.connect_mobile,callback:function(e){t.$set(t.addressData,"connect_mobile",e)},expression:"addressData.connect_mobile"}})],1),r("v-uni-view",{staticClass:"row b-b area"},[r("v-uni-text",{staticClass:"tit"},[t._v("地址")]),r("v-uni-view",{staticClass:"input area-select"},[r("v-uni-picker",{attrs:{name:"province_id",value:t.pIndex,range:t.provinces},on:{change:function(e){arguments[0]=e=t.$handleEvent(e),t.provinceChange.apply(void 0,arguments)}}},[r("v-uni-view",{staticClass:"picker",class:[-1==t.pIndex?"grey":""]},[t._v(t._s(t.pIndex>-1?t.provinces[t.pIndex]:"请选择省"))])],1),r("v-uni-picker",{attrs:{name:"city_id",value:t.cIndex,range:t.citys},on:{change:function(e){arguments[0]=e=t.$handleEvent(e),t.cityChange.apply(void 0,arguments)}}},[r("v-uni-view",{staticClass:"picker",class:[-1==t.cIndex?"grey":""]},[t._v(t._s(t.cIndex>-1?t.citys[t.cIndex]:"请选择市"))])],1),r("v-uni-picker",{attrs:{name:"district_id",value:t.aIndex,range:t.areas},on:{change:function(e){arguments[0]=e=t.$handleEvent(e),t.areaChange.apply(void 0,arguments)}}},[r("v-uni-view",{staticClass:"picker",class:[-1==t.aIndex?"grey":""]},[t._v(t._s(t.aIndex>-1?t.areas[t.aIndex]:"请选择县/区"))])],1)],1)],1),r("v-uni-view",{staticClass:"row b-b",staticStyle:{height:"auto",padding:"10upx 30upx","align-items":"flex-start"}},[r("v-uni-text",{staticClass:"tit",staticStyle:{"margin-right":"10upx"}},[t._v("详细地址")]),r("v-uni-textarea",{staticClass:"input",attrs:{value:t.addressData.area,placeholder:"详细地址","placeholder-class":"placeholder",name:"address"}})],1),r("v-uni-view",{staticClass:"row default-row"},[r("v-uni-text",{staticClass:"tit"},[t._v("设为默认")]),r("v-uni-switch",{attrs:{checked:!!t.addressData.is_default,color:"#fa436a",name:"is_default"},on:{change:function(e){arguments[0]=e=t.$handleEvent(e),t.switchChange.apply(void 0,arguments)}}})],1),r("v-uni-view",{staticClass:"fix-end"},[t.isedit?r("v-uni-button",{staticClass:"del-btn",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.del.apply(void 0,arguments)}}},[t._v("删除地址")]):t._e(),r("v-uni-button",{staticClass:"add-btn",attrs:{"form-type":"submit"}},[t._v(t._s(t.isedit?"保存修改":"保存地址"))])],1)],1)],1)},i=[]},f921:function(t,e,r){"use strict";r.r(e);var n=r("8ab4"),a=r.n(n);for(var i in n)"default"!==i&&function(t){r.d(e,t,(function(){return n[t]}))}(i);e["default"]=a.a}}]);