// +----------------------------------------------------------------------
// | AcShop (Acgice商城)
// +----------------------------------------------------------------------
// | 团队官网: https://oauth.acgice.com
// +----------------------------------------------------------------------
// | 联系我们: https://oauth.acgice.com/sdk/contact.html
// +----------------------------------------------------------------------
// | gitee开源项目：https://gitee.com/orzice/acshop
// +----------------------------------------------------------------------
// | Author：Orzice(小涛)  https://gitee.com/orzice
// +----------------------------------------------------------------------
// | DateTime：2020-10-18 17:52:56
// +----------------------------------------------------------------------

var BASE_URL = document.scripts[document.scripts.length - 1].src.substring(0, document.scripts[document.scripts.length - 1].src.lastIndexOf("/") + 1);
window.BASE_URL = BASE_URL;
require.config({
    urlArgs: "v=" + CONFIG.VERSION,
    baseUrl: BASE_URL,
    paths: {
        "jquery": ["jquery-3.4.1/jquery-3.4.1.min"],
        "jquery-particleground": ["jq-module/jquery.particleground.min"],
        "echarts": ["echarts/echarts.min"],
        "echarts-theme": ["echarts/echarts-theme"],
        "easy-admin": ["easy-admin/easy-admin"],
        "easy-admin2": ["easy-admin/easy-admin2"],
        "layuiall": ["layui-v2.5.6/layui.all"],
        "layui": ["layui-v2.5.5/layui"],
        "miniAdmin": ["lay-module/layuimini/miniAdmin"],
        "miniMenu": ["lay-module/layuimini/miniMenu"],
        "miniTab": ["lay-module/layuimini/miniTab"],
        "miniTheme": ["lay-module/layuimini/miniTheme"],
        "miniTongji": ["lay-module/layuimini/miniTongji"],
        "treetable": ["lay-module/treetable-lay/treetable"],
        "tableSelect": ["lay-module/tableSelect/tableSelect"],
        "iconPickerFa": ["lay-module/iconPicker/iconPickerFa"],
        "autocomplete": ["lay-module/autocomplete/autocomplete"],
        "vue": ["vue-2.6.10/vue.min"],
        "ckeditor": ["ckeditor4/ckeditor"],
        "layer": ["layer-mobile-2.0/layer"],
    }
});

// 路径配置信息
var PATH_CONFIG = {
    iconLess: BASE_URL + "font-awesome-4.7.0/less/variables.less",
};
window.PATH_CONFIG = PATH_CONFIG;
