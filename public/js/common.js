/**
 * Created by sanitkeawtawan on 10/6/2015 AD.
 */

/**
 * jQuery serializeObject
 * @copyright 2014, macek <paulmacek@gmail.com>
 * @link https://github.com/macek/jquery-serialize-object
 * @license BSD
 * @version 2.4.5
 */
(function(root, factory) {

    // AMD
    if (typeof define === "function" && define.amd) {
        define(["exports", "jquery"], function(exports, $) {
            return factory(exports, $);
        });
    }

    // CommonJS
    else if (typeof exports !== "undefined") {
        var $ = require("jquery");
        factory(exports, $);
    }

    // Browser
    else {
        factory(root, (root.jQuery || root.Zepto || root.ender || root.$));
    }

}(this, function(exports, $) {

    var patterns = {
        validate: /^[a-z_][a-z0-9_]*(?:\[(?:\d*|[a-z0-9_]+)\])*$/i,
        key:      /[a-z0-9_]+|(?=\[\])/gi,
        push:     /^$/,
        fixed:    /^\d+$/,
        named:    /^[a-z0-9_]+$/i
    };

    function FormSerializer(helper, $form) {

        // private variables
        var data     = {},
            pushes   = {};

        // private API
        function build(base, key, value) {
            base[key] = value;
            return base;
        }

        function makeObject(root, value) {

            var keys = root.match(patterns.key), k;

            // nest, nest, ..., nest
            while ((k = keys.pop()) !== undefined) {
                // foo[]
                if (patterns.push.test(k)) {
                    var idx = incrementPush(root.replace(/\[\]$/, ''));
                    value = build([], idx, value);
                }

                // foo[n]
                else if (patterns.fixed.test(k)) {
                    value = build([], k, value);
                }

                // foo; foo[bar]
                else if (patterns.named.test(k)) {
                    value = build({}, k, value);
                }
            }

            return value;
        }

        function incrementPush(key) {
            if (pushes[key] === undefined) {
                pushes[key] = 0;
            }
            return pushes[key]++;
        }

        function encode(pair) {
            switch ($('[name="' + pair.name + '"]', $form).attr("type")) {
                case "checkbox":
                    return pair.value === "on" ? true : pair.value;
                default:
                    return pair.value;
            }
        }

        function addPair(pair) {
            if (!patterns.validate.test(pair.name)) return this;
            var obj = makeObject(pair.name, encode(pair));
            data = helper.extend(true, data, obj);
            return this;
        }

        function addPairs(pairs) {
            if (!helper.isArray(pairs)) {
                throw new Error("formSerializer.addPairs expects an Array");
            }
            for (var i=0, len=pairs.length; i<len; i++) {
                this.addPair(pairs[i]);
            }
            return this;
        }

        function serialize() {
            return data;
        }

        function serializeJSON() {
            return JSON.stringify(serialize());
        }

        // public API
        this.addPair = addPair;
        this.addPairs = addPairs;
        this.serialize = serialize;
        this.serializeJSON = serializeJSON;
    }

    FormSerializer.patterns = patterns;

    FormSerializer.serializeObject = function serializeObject() {
        if (this.length > 1) {
            return new Error("jquery-serialize-object can only serialize one form at a time");
        }
        return new FormSerializer($, this).
            addPairs(this.serializeArray()).
            serialize();
    };

    FormSerializer.serializeJSON = function serializeJSON() {
        if (this.length > 1) {
            return new Error("jquery-serialize-object can only serialize one form at a time");
        }
        return new FormSerializer($, this).
            addPairs(this.serializeArray()).
            serializeJSON();
    };

    if (typeof $.fn !== "undefined") {
        $.fn.serializeObject = FormSerializer.serializeObject;
        $.fn.serializeJSON   = FormSerializer.serializeJSON;
    }

    exports.FormSerializer = FormSerializer;

    return FormSerializer;
}));

var waitingDialog = waitingDialog || (function ($) {
        'use strict';

        // Creating modal dialog's DOM
        var $dialog = $(
            '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%;margin-top: 100px;z-index: 100000; overflow-y:visible;">' +
            '<div class="modal-dialog  modal-md">' +
            '<div class="modal-content" style="width: 350px;">' +
            '<div class="modal-header"><h3 style="margin:0;"></h3></div>' +
            '<div class="modal-body"><div class="body-content"></div>' +
            '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
            '</div>' +
            '</div></div></div>');

        return {
            /**
             * Opens our dialog
             * @param message Custom message
             * @param options Custom options:
             * 				  options.dialogSize - bootstrap postfix for dialog size, e.g. "sm", "m";
             * 				  options.progressType - bootstrap postfix for progress bar type, e.g. "success", "warning".
             */
            show: function (message, options) {
                // Assigning defaults
                if (typeof options === 'undefined') {
                    options = {};
                }
                if (typeof message === 'undefined') {
                    message = 'Loading';
                }
                var settings = $.extend({
                    dialogSize: 'm',
                    progressType: '',
                    onHide: null // This callback runs after the dialog was hidden
                }, options);

                // Configuring dialog
                $dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);
                $dialog.find('.progress-bar').attr('class', 'progress-bar');
                if (settings.progressType) {
                    $dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType);
                }
                $dialog.find('h3').text(message);
                if(typeof options.content !="undefined"){
                    $dialog.find('.body-content').html(options.content);
                }

                // Adding callbacks
                if (typeof settings.onHide === 'function') {
                    $dialog.off('hidden.bs.modal').on('hidden.bs.modal', function (e) {
                        settings.onHide.call($dialog);
                    });
                }
                // Opening dialog
                $dialog.modal();
            },
            /**
             * Closes dialog
             */
            hide: function () {
                $dialog.modal('hide');
            }
        };

    })(jQuery);




var Common = function () {
    return {
        init: function () {
        },
        waitingDialog: {
            show: function (message, option) {
                option = $.extend({
                    dialogSize: 'sm', progressType: 'warning'
                }, option);
                waitingDialog.show(message, option);
            },
            hide: function () {
                waitingDialog.hide();
            }
        },
        isEqualArray:function(args){

            var equal = args.join(',').replace(new RegExp(args[0], "ig"), '').replace(/,/g, "");
            return equal.length == 0;

        },
        isEqual:function(){
                var args = Array.prototype.slice.call(arguments, 0);
                var equal = args.join(',').replace(new RegExp(args[0], "ig"), '').replace(/,/g, "");
                return equal.length == 0;

        },
        moneyFormat:function(value,dec){
            if( typeof  dec==="undefined"){dec=0;}
            if(typeof value!='undefined'){
                if(dec>0){
                    return parseFloat(value).toFixed(dec).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                }else{
                    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            }


        },
        base_url: function (path) {
            //Common.base_url('')
            if(typeof path==="undefined"){path="";}
            var url = location.href;  // entire url including querystring - also: window.location.href;
            var host=location.origin;
            var baseURL = host;

            if (baseURL.indexOf('http://localhost') != -1) {
                // Base Url for localhost
                url = location.href;  // window.location.href;
                var pathname = location.pathname;  // window.location.pathname;
                var index1 = url.indexOf(pathname);
                var index2 = url.indexOf("/", index1 + 1);
                var baseLocalUrl = url.substr(0, index2);
                return baseLocalUrl + "/" + path;
            }
            else {
                // Root Url for domain name
              // return baseURL + "/project/hrdi/" + path;
                return baseURL + "/" + path;
            }
        },

        isEmail: function (email) {
            var REGEX_EMAIL = '([a-z0-9!#$%&\'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+/=?^_`{|}~-]+)*@' +
                '(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?)';
            return ((new RegExp('^' + REGEX_EMAIL + '$', 'i')).test(email));
        },
        genid: function (prefix) {
            var result = 'xxxxxxxx-xxxx'.replace(/[xy]/g, function (c) {
                var r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
            return [prefix, result].join('-');
        },
        permission:{
            alert:function(){ alertify.alert("ขออภัยคุณไม่สามารถเข้าใช้งานได้ กรุณาติดต่อผู้ดูแลระบบ", function(){ }); return false},
            is_manage:function(appName,action,owners){
                var allow=false;
               // console.log(appName,action,owners);
                if(Common.permission.check(appName,action)){
                            //id
//                    console.log(action,'ok');
                    if(Common.permission.check(appName,'viewall')){
                        //console.log('viewall','ok');
                        allow=true;
                        return true;
                    }else{

                        if(typeof owners =='undefined'){
                            //console.log('owners','undefined');
                            return false;
                        }
                        if(typeof userId =='undefined'){
                            //console.log('userId','undefined');
                            return false;
                        }
                        //console.log('check',owners);
                        $.each(owners,function(i,v){
                            //console.log(v.id,userId);
                            if(v.id==userId){
//                                console.log('checkOwner','ok');
                                allow=true;
                                return true;
                            }
                        });

                    }

                }
                //console.log('===check===',allow);
                return allow;
            },
            is_Access:function(appName){ return Common.permission.check(appName,'access');},
            is_Add:function(appName){ return Common.permission.check(appName,'add');},
            is_Edit:function(appName){ return Common.permission.check(appName,'edit');},
            is_View:function(appName){ return Common.permission.check(appName,'view');},
            is_ViewAll:function(appName){ return Common.permission.check(appName,'viewall');},
            is_Del:function(appName){return Common.permission.check(appName,'del'); },
            check:function(appName,action){
                try{
                    if(Permisstion[appName]){
                        var act=Permisstion[appName];
                        return (act.indexOf(action)>-1);
                    }else{
                        return false;
                    }
                }catch(exception){
                    return false;
                }
            }
        }
    }
}();
$(document).ready(function () {
    Common.init();
});