(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-index-list"],{"0a0e":function(t,e,a){"use strict";a.r(e);var i=a("9a7d"),n=a.n(i);for(var o in i)"default"!==o&&function(t){a.d(e,t,(function(){return i[t]}))}(o);e["default"]=n.a},"2f90":function(t,e,a){var i=a("dada");"string"===typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);var n=a("4f06").default;n("11c96e19",i,!0,{sourceMap:!1,shadowMode:!1})},"38d8":function(t,e,a){"use strict";a.r(e);var i=a("c8dd"),n=a("0a0e");for(var o in n)"default"!==o&&function(t){a.d(e,t,(function(){return n[t]}))}(o);a("4c9b");var s,r=a("f0c5"),c=Object(r["a"])(n["default"],i["b"],i["c"],!1,null,"7f250397",null,!1,i["a"],s);e["default"]=c.exports},"4c9b":function(t,e,a){"use strict";var i=a("2f90"),n=a.n(i);n.a},"9a7d":function(t,e,a){"use strict";var i=a("4ea4");a("99af"),a("4e82"),a("4d63"),a("ac1f"),a("25f0"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0,a("96cf");var n=i(a("1da1")),o=i(a("2e09")),s={components:{uniLoadMore:o.default},data:function(){return{scrollTop:0,cateMaskState:0,headerPosition:"fixed",headerTop:"0px",loadingType:"more",filterIndex:0,cateId:null,priceOrder:0,cateList:[],goodsList:[],page:0,searchTxt:""}},onShow:function(){uni.getStorage({key:"version",success:function(t){document.title="".concat(document.title," - ").concat(JSON.parse(t.data).site.name)}})},onLoad:function(t){var e=this;setTimeout((function(){e.headerTop=document.getElementsByTagName("uni-page-head")[0].offsetHeight+"px"}),600);var a=this.$Route.query.categoryid,i=/^[0-9]+$/,n=new RegExp(i);n.test(a)?this.cateId=a:this.searchTxt=a,this.loadCateList(),this.loadData()},onPageScroll:function(t){this.scrollTop=t.scrollTop,t.scrollTop>=0?this.headerPosition="fixed":this.headerPosition="absolute"},onPullDownRefresh:function(){this.loadData("refresh")},onReachBottom:function(){this.loadData()},methods:{loadCateList:function(){var t=this;uni.getStorage({key:"cate",success:function(e){t.cateList=e.data}})},loadData:function(){var t=arguments,e=this;return(0,n.default)(regeneratorRuntime.mark((function a(){var i,n,o;return regeneratorRuntime.wrap((function(a){while(1)switch(a.prev=a.next){case 0:if(i=t.length>0&&void 0!==t[0]?t[0]:"add",n=t.length>1?t[1]:void 0,"add"!==i){a.next=8;break}if("nomore"!==e.loadingType){a.next=5;break}return a.abrupt("return");case 5:e.loadingType="loading",a.next=9;break;case 8:e.loadingType="more";case 9:if(!e.cateId&&0!=e.cateId){a.next=15;break}return a.next=12,e.$request.get("/api/goods/goods_list",{category_id:e.cateId,page:e.page,limit:16});case 12:o=a.sent,a.next=18;break;case 15:return a.next=17,e.$request.get("/api/goods/goods_search",{goods_title:e.searchTxt,page:e.page,limit:16});case 17:o=a.sent;case 18:1==o.code?(o.data.goods_count-o.data.list_count>0&&(e.page+=1),o=o.data.goods_list):e.$api.modal(o.msg),"refresh"===i&&(e.goodsList=[]),1===e.filterIndex&&o.sort((function(t,e){return e.show_sales-t.show_sales})),2===e.filterIndex&&o.sort((function(t,a){return 1==e.priceOrder?t.price-a.price:a.price-t.price})),e.goodsList=e.goodsList.concat(o),e.loadingType=e.goodsList.length<16?"nomore":"more","refresh"===i&&(1==n?uni.hideLoading():uni.stopPullDownRefresh());case 25:case"end":return a.stop()}}),a)})))()},tabClick:function(t){this.filterIndex===t&&2!==t||(this.filterIndex=t,this.priceOrder=2===t?1===this.priceOrder?2:1:0,uni.pageScrollTo({duration:300,scrollTop:0}),this.loadData("refresh",1),uni.showLoading({title:"正在加载"}))},toggleCateMask:function(t){var e=this,a="show"===t?10:300,i="show"===t?1:0;this.cateMaskState=2,setTimeout((function(){e.cateMaskState=i}),a)},changeCate:function(t){this.cateId=t.id,this.toggleCateMask(),uni.pageScrollTo({duration:300,scrollTop:0}),this.page=0,this.loadData("refresh",1),uni.showLoading({title:"正在加载"})},navToDetailPage:function(t){var e=t.id;this.$Router.push({name:"Details",params:{goodsid:e}})},stopPrevent:function(){}}};e.default=s},c8dd:function(t,e,a){"use strict";a.d(e,"b",(function(){return n})),a.d(e,"c",(function(){return o})),a.d(e,"a",(function(){return i}));var i={uniLoadMore:a("2e09").default},n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("v-uni-view",{staticClass:"content"},[a("v-uni-view",{staticClass:"navbar",style:{position:t.headerPosition,top:t.headerTop}},[a("v-uni-view",{staticClass:"nav-item",class:{current:0===t.filterIndex},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.tabClick(0)}}},[t._v("综合排序")]),a("v-uni-view",{staticClass:"nav-item",class:{current:1===t.filterIndex},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.tabClick(1)}}},[t._v("销量优先")]),a("v-uni-view",{staticClass:"nav-item",class:{current:2===t.filterIndex},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.tabClick(2)}}},[a("v-uni-text",[t._v("价格")]),a("v-uni-view",{staticClass:"p-box"},[a("v-uni-text",{staticClass:"yticon icon-shang",class:{active:1===t.priceOrder&&2===t.filterIndex}}),a("v-uni-text",{staticClass:"yticon icon-shang xia",class:{active:2===t.priceOrder&&2===t.filterIndex}})],1)],1),a("v-uni-text",{staticClass:"cate-item yticon icon-fenlei1",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.toggleCateMask("show")}}})],1),a("v-uni-view",{staticClass:"goods-list"},t._l(t.goodsList,(function(e,i){return a("v-uni-view",{key:i,staticClass:"goods-item",on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.navToDetailPage(e)}}},[a("v-uni-view",{staticClass:"image-wrapper"},[a("v-uni-image",{attrs:{src:e.thumb,mode:"aspectFill"}})],1),e.title.length>=22?a("v-uni-view",{staticClass:"title clamp"},[t._v(t._s(e.title.slice(0,22))+"...")]):a("v-uni-view",{staticClass:"title clamp"},[t._v(t._s(e.title))]),a("v-uni-view",{staticClass:"price-box"},[a("v-uni-text",{staticClass:"price"},[t._v(t._s(e.price))]),a("v-uni-text",[t._v("已售 "+t._s(e.show_sales))])],1)],1)})),1),a("uni-load-more",{attrs:{status:t.loadingType}}),a("v-uni-view",{staticClass:"cate-mask",class:0===t.cateMaskState?"none":1===t.cateMaskState?"show":"",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.toggleCateMask.apply(void 0,arguments)}}},[a("v-uni-view",{staticClass:"cate-content",on:{click:function(e){e.stopPropagation(),e.preventDefault(),arguments[0]=e=t.$handleEvent(e),t.stopPrevent.apply(void 0,arguments)},touchmove:function(e){e.stopPropagation(),e.preventDefault(),arguments[0]=e=t.$handleEvent(e),t.stopPrevent.apply(void 0,arguments)}}},[a("v-uni-scroll-view",{staticClass:"cate-list",attrs:{"scroll-y":!0}},t._l(t.cateList,(function(e){return a("v-uni-view",{key:e.id},[a("v-uni-view",{staticClass:"cate-item b-b two"},[t._v(t._s(e.name))]),t._l(e.child_category,(function(e){return a("v-uni-view",{key:e.id,staticClass:"cate-item b-b",class:{active:e.id==t.cateId},on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.changeCate(e)}}},[t._v(t._s(e.name))])}))],2)})),1)],1)],1),a("back-top",{attrs:{scrollTop:t.scrollTop}})],1)},o=[]},dada:function(t,e,a){var i=a("24fb");e=i(!1),e.push([t.i,'@charset "UTF-8";\n/* 页面左右间距 */\n/* 文字尺寸 */\n/*文字颜色*/\n/* 边框颜色 */\n/* 图片加载中颜色 */\n/* 行为相关颜色 */uni-page-body[data-v-7f250397], .content[data-v-7f250397]{background:#f8f8f8}.content[data-v-7f250397]{padding-top:%?96?%}.navbar[data-v-7f250397]{position:fixed;left:0;top:var(--window-top);display:-webkit-box;display:-webkit-flex;display:flex;width:100%;height:%?80?%;background:#fff;box-shadow:0 %?2?% %?10?% rgba(0,0,0,.06);z-index:10}.navbar .nav-item[data-v-7f250397]{-webkit-box-flex:1;-webkit-flex:1;flex:1;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;align-items:center;height:100%;font-size:%?30?%;color:#303133;position:relative}.navbar .nav-item.current[data-v-7f250397]{color:#fa436a}.navbar .nav-item.current[data-v-7f250397]:after{content:"";position:absolute;left:50%;bottom:0;-webkit-transform:translateX(-50%);transform:translateX(-50%);width:%?120?%;height:0;border-bottom:%?4?% solid #fa436a}.navbar .p-box[data-v-7f250397]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column}.navbar .p-box .yticon[data-v-7f250397]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;width:%?30?%;height:%?14?%;line-height:1;margin-left:%?4?%;font-size:%?26?%;color:#888}.navbar .p-box .yticon.active[data-v-7f250397]{color:#fa436a}.navbar .p-box .xia[data-v-7f250397]{-webkit-transform:scaleY(-1);transform:scaleY(-1)}.navbar .cate-item[data-v-7f250397]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;align-items:center;height:100%;width:%?80?%;position:relative;font-size:%?44?%}.navbar .cate-item[data-v-7f250397]:after{content:"";position:absolute;left:0;top:50%;-webkit-transform:translateY(-50%);transform:translateY(-50%);border-left:1px solid #ddd;width:0;height:%?36?%}\n/* 分类 */.cate-mask[data-v-7f250397]{position:fixed;left:0;top:var(--window-top);bottom:0;width:100%;background:transparent;z-index:95;-webkit-transition:.3s;transition:.3s}.cate-mask .cate-content[data-v-7f250397]{width:%?630?%;height:100%;background:#fff;float:right;-webkit-transform:translateX(100%);transform:translateX(100%);-webkit-transition:.3s;transition:.3s}.cate-mask.none[data-v-7f250397]{display:none}.cate-mask.show[data-v-7f250397]{background:rgba(0,0,0,.4)}.cate-mask.show .cate-content[data-v-7f250397]{-webkit-transform:translateX(0);transform:translateX(0)}.cate-list[data-v-7f250397]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;height:100%}.cate-list .cate-item[data-v-7f250397]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;height:%?90?%;padding-left:%?30?%;font-size:%?28?%;color:#555;position:relative}.cate-list .two[data-v-7f250397]{height:%?64?%;color:#303133;font-size:%?30?%;background:#f8f8f8}.cate-list .active[data-v-7f250397]{color:#fa436a}\n/* 商品列表 */.goods-list[data-v-7f250397]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-flex-wrap:wrap;flex-wrap:wrap;padding:0 %?30?%;background:#fff}.goods-list .goods-item[data-v-7f250397]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;width:48%;padding-bottom:%?40?%}.goods-list .goods-item[data-v-7f250397]:nth-child(2n+1){margin-right:4%}.goods-list .image-wrapper[data-v-7f250397]{width:100%;height:%?330?%;border-radius:3px;overflow:hidden}.goods-list .image-wrapper uni-image[data-v-7f250397]{width:100%;height:100%;opacity:1}.goods-list .title[data-v-7f250397]{font-size:%?26?%;color:#303133;height:%?80?%}.goods-list .price-box[data-v-7f250397]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between;padding-right:%?10?%;font-size:%?24?%;color:#909399}.goods-list .price[data-v-7f250397]{font-size:%?32?%;color:#fa436a;line-height:1}.goods-list .price[data-v-7f250397]:before{content:"￥";font-size:%?26?%}.clamp[data-v-7f250397]{white-space:pre-wrap}body.?%PAGE?%[data-v-7f250397]{background:#f8f8f8}',""]),t.exports=e}}]);