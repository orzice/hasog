(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-index-cart"],{"1db9":function(t,i,e){"use strict";e.r(i);var a=e("8901"),n=e.n(a);for(var o in a)"default"!==o&&function(t){e.d(i,t,(function(){return a[t]}))}(o);i["default"]=n.a},"46c4":function(t,i,e){var a=e("ec44");"string"===typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);var n=e("4f06").default;n("2e6f17a1",a,!0,{sourceMap:!1,shadowMode:!1})},8901:function(t,i,e){"use strict";var a=e("4ea4");e("99af"),e("4160"),e("c975"),e("d81d"),e("a9e3"),e("b680"),e("159b"),Object.defineProperty(i,"__esModule",{value:!0}),i.default=void 0;var n=a(e("2909"));e("96cf");var o=a(e("1da1")),c=a(e("e3bb")),s={components:{uniNumberBox:c.default},data:function(){return{total:0,allChecked:!1,empty:!1,cartList:[],hasLogin:!1,page:0,refresh:!1,isMore:!0,isGet:!0}},onLoad:function(){this.loadData()},onShow:function(){var t=this;uni.$once("addC",(function(i){1==i.msg&&t.isGet&&(t.isGet=!1,t.page=0,t.isMore=!0,t.cartList=[],t.loadData())})),uni.getStorage({key:"version",success:function(t){document.title="".concat(document.title," - ").concat(JSON.parse(t.data).site.name)}})},onPullDownRefresh:function(){this.page=0,this.isMore=!0,this.cartList=[],this.loadData(),setTimeout((function(){uni.stopPullDownRefresh()}),1e3)},onReachBottom:function(){this.isMore&&this.loadData()},watch:{cartList:function(t){var i=0===t.length;this.empty!==i&&(this.empty=i)},refresh:function(t){t&&(this.empty=!1,this.page=0,this.cartList=[],this.loadData())}},methods:{loadData:function(){var t=this;return(0,o.default)(regeneratorRuntime.mark((function i(){var e,a,o;return regeneratorRuntime.wrap((function(i){while(1)switch(i.prev=i.next){case 0:return i.next=2,t.$request.get("/api/cart/cart_list",{page:t.page,limit:16});case 2:if(e=i.sent,!e.url||-1==e.url.indexOf("login")){i.next=7;break}return t.hasLogin=!1,uni.showModal({title:"温馨提示",content:e.msg,success:function(i){i.confirm&&t.$Router.push({name:"Login"})}}),i.abrupt("return");case 7:1==e.code?(t.hasLogin=!0,t.isGet=!0,a=e.data.carts,o=a.map((function(t){return t.checked=t.is_valid,t})),0!=e.data.list_count?(t.page++,t.cartList=[].concat((0,n.default)(t.cartList),(0,n.default)(o))):t.isMore=!1,t.calcTotal()):(t.hasLogin=!1,t.$api.modal(e.msg));case 8:case"end":return i.stop()}}),i)})))()},onImageLoad:function(t,i){this.$set(this[t][i],"loaded","loaded")},onImageError:function(t,i){this[t][i].image="/static/errorImage.jpg"},toIndex:function(){this.$Router.pushTab({name:"Home"})},navToLogin:function(){this.$Router.push({name:"Login"})},check:function(t,i){if("item"===t)this.cartList[i].checked=!this.cartList[i].checked;else{var e=!this.allChecked,a=this.cartList;a.forEach((function(t){t.is_valid&&(t.checked=e)})),this.allChecked=e}this.calcTotal(t)},numberChange:function(t){this.cartList[t.index].stock=t.number,this.calcTotal()},deleteCartItem:function(t){var i=this;return(0,o.default)(regeneratorRuntime.mark((function e(){var a,n;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return a=-1!=toString.call(t).indexOf("Arr")?t:[t],e.next=3,i.$request.post("/api/cart/delete_cart",{cart_goods_ids:a});case 3:n=e.sent,1==n.code?(i.$api.msg(n.msg),i.page=0,i.isMore=!0,i.cartList=[],i.loadData()):i.$api.modal(n.msg),i.calcTotal();case 6:case"end":return e.stop()}}),e)})))()},clearCart:function(){var t=this;uni.showModal({content:"确定要清空购物车吗？",success:function(i){if(i.confirm){var e=[];t.cartList.forEach((function(t){e.push(t.id)})),t.deleteCartItem(e)}}})},calcTotal:function(){var t=this.cartList;if(0!==t.length){var i=0,e=!0;t.forEach((function(t){!0===t.checked?i+=t.goods.price*t.stock:!0===e&&(e=!1)})),this.allChecked=e,this.total=Number(i.toFixed(2))}else this.empty=!0},createOrder:function(){var t=this.cartList,i=[];t.forEach((function(t){t.checked&&i.push({goods_id:t.goods_id,goods_num:t.stock,description:JSON.parse(t.goods_options)})})),this.$Router.push({name:"ConfirmOrder",params:{goodsData:i}}),this.$api.msg("跳转下一页 sendData")}}};i.default=s},"970b":function(t,i,e){"use strict";var a=e("46c4"),n=e.n(a);n.a},ec44:function(t,i,e){var a=e("24fb");i=a(!1),i.push([t.i,'@charset "UTF-8";\n/* 页面左右间距 */\n/* 文字尺寸 */\n/*文字颜色*/\n/* 边框颜色 */\n/* 图片加载中颜色 */\n/* 行为相关颜色 */uni-page-body[data-v-5d7adc36]{background-color:#fff!important}.container[data-v-5d7adc36]{padding-bottom:%?134?%\n  /* 空白页 */}.container .empty[data-v-5d7adc36]{position:fixed;left:0;top:0;width:100%;height:100vh;padding-bottom:%?100?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;-webkit-box-align:center;-webkit-align-items:center;align-items:center;background:#fff}.container .empty uni-image[data-v-5d7adc36]{width:%?240?%;height:%?160?%;margin-bottom:%?30?%}.container .empty .empty-tips[data-v-5d7adc36]{display:-webkit-box;display:-webkit-flex;display:flex;font-size:%?26?%;color:#c0c4cc}.container .empty .empty-tips .navigator[data-v-5d7adc36]{color:#fa436a;margin-left:%?16?%}\n/* 购物车列表项 */.cart-item[data-v-5d7adc36]{display:-webkit-box;display:-webkit-flex;display:flex;position:relative;padding:%?30?% %?40?%}.cart-item .image-wrapper[data-v-5d7adc36]{width:%?230?%;height:%?230?%;-webkit-flex-shrink:0;flex-shrink:0;position:relative}.cart-item .image-wrapper uni-image[data-v-5d7adc36]{border-radius:%?8?%}.cart-item .checkbox[data-v-5d7adc36]{position:absolute;left:%?-16?%;top:%?-16?%;z-index:8;font-size:%?44?%;line-height:1;padding:%?4?%;color:#c0c4cc;background:#fff;border-radius:50px}.cart-item .item-right[data-v-5d7adc36]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;-webkit-box-flex:1;-webkit-flex:1;flex:1;overflow:hidden;position:relative;padding-left:%?30?%}.cart-item .item-right .title[data-v-5d7adc36], .cart-item .item-right .price[data-v-5d7adc36]{font-size:%?30?%;color:#303133;height:%?40?%;line-height:%?40?%}.cart-item .item-right .disabled[data-v-5d7adc36]{color:#c0c4cc}.cart-item .item-right .attr[data-v-5d7adc36]{font-size:%?26?%;color:#909399;height:%?50?%;line-height:%?50?%;margin-right:%?10?%}.cart-item .item-right .price[data-v-5d7adc36]{height:%?50?%;line-height:%?50?%}.cart-item .item-right .failure[data-v-5d7adc36]{padding:%?10?%;font-size:%?24?%;color:#fff;position:absolute;left:15px;bottom:0;border-radius:%?20?%;background:#909399}.cart-item .del-btn[data-v-5d7adc36]{padding:%?4?% %?10?%;font-size:%?34?%;height:%?50?%;color:#909399}\n/* 底部栏 */.action-section[data-v-5d7adc36]{margin-bottom:%?100?%;position:fixed;left:%?30?%;bottom:%?30?%;z-index:95;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;width:%?690?%;height:%?100?%;padding:0 %?30?%;background:hsla(0,0%,100%,.9);box-shadow:0 0 %?20?% 0 rgba(0,0,0,.5);border-radius:%?16?%}.action-section .checkbox[data-v-5d7adc36]{height:%?52?%;position:relative}.action-section .checkbox uni-image[data-v-5d7adc36]{width:%?52?%;height:100%;position:relative;z-index:5}.action-section .clear-btn[data-v-5d7adc36]{position:absolute;left:%?26?%;top:0;z-index:4;width:0;height:%?52?%;line-height:%?52?%;padding-left:%?38?%;font-size:%?28?%;color:#fff;background:#c0c4cc;border-radius:0 50px 50px 0;opacity:0;-webkit-transition:.2s;transition:.2s}.action-section .clear-btn.show[data-v-5d7adc36]{opacity:1;width:%?120?%}.action-section .total-box[data-v-5d7adc36]{-webkit-box-flex:1;-webkit-flex:1;flex:1;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;text-align:right;padding-right:%?40?%}.action-section .total-box .price[data-v-5d7adc36]{font-size:%?32?%;color:#dd524d}.action-section .total-box .coupon[data-v-5d7adc36]{font-size:%?24?%;color:#909399;margin-right:%?-10?%}.action-section .confirm-btn[data-v-5d7adc36]{padding:0 %?38?%;margin:0;border-radius:100px;height:%?76?%;line-height:%?76?%;font-size:%?30?%;background:#fa436a;box-shadow:1px 2px 5px rgba(217,60,93,.72)}\n/* 复选框选中状态 */.action-section .checkbox.checked[data-v-5d7adc36],\n.cart-item .checkbox.checked[data-v-5d7adc36]{color:#fa436a}body.?%PAGE?%[data-v-5d7adc36]{background-color:#fff!important}',""]),t.exports=i},f1e1:function(t,i,e){"use strict";e.r(i);var a=e("f78a"),n=e("1db9");for(var o in n)"default"!==o&&function(t){e.d(i,t,(function(){return n[t]}))}(o);e("970b");var c,s=e("f0c5"),r=Object(s["a"])(n["default"],a["b"],a["c"],!1,null,"5d7adc36",null,!1,a["a"],c);i["default"]=r.exports},f78a:function(t,i,e){"use strict";var a;e.d(i,"b",(function(){return n})),e.d(i,"c",(function(){return o})),e.d(i,"a",(function(){return a}));var n=function(){var t=this,i=t.$createElement,e=t._self._c||i;return e("v-uni-view",{staticClass:"container"},[t.hasLogin&&!0!==t.empty?e("v-uni-view",[t.cartList?e("v-uni-view",{staticClass:"cart-list"},[t._l(t.cartList,(function(i,a){return[e("v-uni-view",{key:i.id+"_0",staticClass:"cart-item",class:{"b-b":a!==t.cartList.length-1}},[e("v-uni-view",{staticClass:"image-wrapper"},[e("v-uni-image",{class:[i.loaded],attrs:{src:i.goods.thumb,mode:"aspectFill","lazy-load":!0},on:{load:function(i){arguments[0]=i=t.$handleEvent(i),t.onImageLoad("cartList",a)},error:function(i){arguments[0]=i=t.$handleEvent(i),t.onImageError("cartList",a)}}}),e("v-uni-view",{directives:[{name:"show",rawName:"v-show",value:i.is_valid,expression:"item.is_valid"}],staticClass:"yticon icon-xuanzhong2 checkbox",class:{checked:i.checked},on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.check("item",a)}}})],1),e("v-uni-view",{staticClass:"item-right"},[e("v-uni-text",{staticClass:"clamp title",class:[i.is_valid?"":"disabled"]},[t._v(t._s(i.goods.title))]),e("v-uni-view",{directives:[{name:"show",rawName:"v-show",value:i.goods_options,expression:"item.goods_options"}]},t._l(JSON.parse(i.goods_options),(function(i,a){return e("v-uni-text",{staticClass:"attr"},[t._v(t._s(i.value))])})),1),i.is_valid?e("v-uni-text",{staticClass:"price"},[t._v("¥"+t._s(i.goods.price))]):t._e(),i.is_valid?e("uni-number-box",{staticClass:"step",attrs:{min:1,max:i.goods.stock>200?200:i.goods.stock,value:i.stock>i.goods.stock?i.goods.stock:i.stock,isMax:i.stock>=i.goods.stock,isMin:1===i.stock,index:a},on:{eventChange:function(i){arguments[0]=i=t.$handleEvent(i),t.numberChange.apply(void 0,arguments)}}}):e("v-uni-view",{staticClass:"failure"},[t._v("失效商品")])],1),e("v-uni-text",{staticClass:"del-btn yticon icon-fork",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.deleteCartItem(i.id)}}})],1)]}))],2):t._e(),e("v-uni-view",{staticClass:"action-section"},[e("v-uni-view",{staticClass:"checkbox"},[e("v-uni-image",{attrs:{src:t.allChecked?"/static/selected.png":"/static/select.png",mode:"aspectFit"},on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.check("all")}}}),e("v-uni-view",{staticClass:"clear-btn",class:{show:t.allChecked},on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.clearCart.apply(void 0,arguments)}}},[t._v("清空")])],1),e("v-uni-view",{staticClass:"total-box"},[e("v-uni-text",{staticClass:"price"},[t._v("¥"+t._s(t.total))]),e("v-uni-text",{staticClass:"coupon"},[t._v("（不含运费）")])],1),e("v-uni-button",{staticClass:"no-border confirm-btn",attrs:{type:"primary"},on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.createOrder.apply(void 0,arguments)}}},[t._v("去结算")])],1)],1):e("v-uni-view",{staticClass:"empty"},[e("v-uni-image",{attrs:{src:"/static/emptyCart.jpg",mode:"aspectFit"}}),t.hasLogin?e("v-uni-view",{staticClass:"empty-tips"},[t._v("空空如也"),t.hasLogin?e("v-uni-view",{staticClass:"navigator",on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.toIndex.apply(void 0,arguments)}}},[t._v("随便逛逛>")]):t._e()],1):e("v-uni-view",{staticClass:"empty-tips"},[t._v("空空如也"),e("v-uni-view",{staticClass:"navigator",on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.navToLogin.apply(void 0,arguments)}}},[t._v("去登录>")])],1)],1)],1)},o=[]}}]);