var Upload=function(){
    var $element=null;
    var dropzone=null;
    var fileremove=[];
    var options;
    var return_value;
    var temp_file = new Array();
    var domain = $('#base_url').val();
    var method= {
        setup:function(_elem,_return,_folder,_options){
            options= $.extend({},_options);
            fileremove=[];
            $element=$(_elem);
            return_value = _return;
            folder = _folder;

            $element.dropzone(
                {
                    previewTemplate:['<div class="dz-preview dz-file-preview">',
                        '<a class="dz-view dz-remove" href="javascript:undefined;" data-dz-view="" target="_blank"><i class="fa fa-paperclip"></i> ดู</a>',
                        '<a class="dz-remove" href="javascript:undefined;" data-dz-remove=""><i class="fa fa-trash-o"></i> ลบ</a>',

                        '<div class="dz-details2">',
                        '<div class="dz-filename"><span data-dz-name></span>(<span class="dz-size" data-dz-size></span>)</div>',


                        '<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>',
                        '<div class="dz-success-mark"><span>?</span></div>',
                        '<div class="dz-error-mark"><span>?</span></div>',
                        '<div class="dz-error-message"><span data-dz-errormessage></span></div>',
                        '</div>',
                        // '<a class="dz-view" href="javascript:undefined;"><i class="fa fa-eye"></i> ดู</a>',

                        '</div>'].join(''),
                    url: domain+'/services/attachFile/'+folder,
                    maxFilesize: 200, // MB
                    // addRemoveLinks:true,
                    init: function () {
                        var thisDropzone = this;
                        dropzone = this;
                        // this.on("addedfile", function(file) { alert("Added file."); });
                        if(options.images){
                            $.each(options.images,function(i,image){
                                $.ajax({
                                    url: domain+'/services/getFile',
                                    type: 'POST',
                                    dataType:'json',
                                    data: {file:image},
                                    error: function(error) {
                                        console.log(error);
                                    },
                                    success: function(value) {
                                        var mockFile = {name: value.name, size: value.size ,file:value.file,path:value.path};
                                        thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                                        //thisDropzone.options.thumbnail.call(thisDropzone, mockFile, value.path);
                                        thisDropzone.options.complete.call(thisDropzone,mockFile);
                                        if(thisDropzone.options.maxFiles){
                                            var existingFileCount = 1; // The number of files already uploaded
                                            thisDropzone.options.maxFiles = thisDropzone.options.maxFiles - existingFileCount;
                                        }
                                    }
                                });
                            });

                        }
                    },
                    accept: function (file, done) {
                        done();
                    },
                    success:function(file, response){
                        console.log(response);
                        _ref3 = file.previewElement.querySelectorAll("[data-dz-view]");
                       // console.log(file,_ref3);
                        for (_k = 0, _len2 = _ref3.length; _k < _len2; _k++) {
                            removeLink = _ref3[_k];
                            if(response.file){
                                removeLink.href= domain+"/"+response.file;
                            }
                        }
                        var file_name = response.file;

                        temp_file.push(file_name);
                        console.log(temp_file);
                        $(return_value).val(temp_file);
                        console.log($(return_value).val());
                       
                    },
                    removedfile:function(file){
                        if(file.file){
                            fileremove.push(file.file);
                        }
                        img="";
                        var _ref;
                        temp_file.pop(file.file_name);
                        $(return_value).val(temp_file);
                        return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                    }
                }
            );
            return method;
        },
        removeAllFiles:function(){
            dropzone.removeAllFiles();
        },
        getFile:function(){
            var files=[];

            $.each(dropzone.files ,function(i,file){
                if(file.status != 'error'){
                    var obj=JSON.parse(file.xhr.response);
                    if(!obj.error){
                        files.push(obj.values);
                    }
                }

            });
//            console.log(fileremove);
            if(options.images){
                $.each(options.images,function(i,image){
                    if(fileremove.indexOf(image)<0){
                        files.push(image);
                    }
                });
            }
            return files;
        }
    };
    return method;

}();

var Upload2=function(){
    var $element=null;
    var dropzone=null;
    var fileremove=[];
    var options;
    var return_value;
    var temp_file = new Array();
    var domain = $('#base_url').val();
    var method= {
        setup:function(_elem,_return,_folder,_options){
            options= $.extend({},_options);
            fileremove=[];
            $element=$(_elem);
            return_value = _return;
            folder = _folder;

            $element.dropzone(
                {
                    previewTemplate:['<div class="dz-preview dz-file-preview">',
                        '<a class="dz-view dz-remove" href="javascript:undefined;" data-dz-view="" target="_blank"><i class="fa fa-paperclip"></i> ดู</a>',
                        '<a class="dz-remove" href="javascript:undefined;" data-dz-remove=""><i class="fa fa-trash-o"></i> ลบ</a>',

                        '<div class="dz-details2">',
                        '<div class="dz-filename"><span data-dz-name></span>(<span class="dz-size" data-dz-size></span>)</div>',


                        '<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>',
                        '<div class="dz-success-mark"><span>?</span></div>',
                        '<div class="dz-error-mark"><span>?</span></div>',
                        '<div class="dz-error-message"><span data-dz-errormessage></span></div>',
                        '</div>',
                        // '<a class="dz-view" href="javascript:undefined;"><i class="fa fa-eye"></i> ดู</a>',

                        '</div>'].join(''),
                    url: domain+'/services/attachFile/'+folder,
                    maxFilesize: 200, // MB
                    // addRemoveLinks:true,
                    init: function () {
                        var thisDropzone = this;
                        dropzone = this;
                        // this.on("addedfile", function(file) { alert("Added file."); });
                        if(options.images){
                            $.each(options.images,function(i,image){
                                $.ajax({
                                    url: domain+'/services/getFile',
                                    type: 'POST',
                                    dataType:'json',
                                    data: {file:image},
                                    error: function(error) {
                                        console.log(error);
                                    },
                                    success: function(value) {
                                        var mockFile = {name: value.name, size: value.size ,file:value.file,path:value.path};
                                        thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                                        //thisDropzone.options.thumbnail.call(thisDropzone, mockFile, value.path);
                                        thisDropzone.options.complete.call(thisDropzone,mockFile);
                                        if(thisDropzone.options.maxFiles){
                                            var existingFileCount = 1; // The number of files already uploaded
                                            thisDropzone.options.maxFiles = thisDropzone.options.maxFiles - existingFileCount;
                                        }
                                    }
                                });
                            });

                        }
                    },
                    accept: function (file, done) {
                        done();
                    },
                    success:function(file, response){
                        console.log(response);
                        _ref3 = file.previewElement.querySelectorAll("[data-dz-view]");
                       // console.log(file,_ref3);
                        for (_k = 0, _len2 = _ref3.length; _k < _len2; _k++) {
                            removeLink = _ref3[_k];
                            if(response.file){
                                removeLink.href= domain+"/"+response.file;
                            }
                        }
                        var file_name = response.file;

                        temp_file.push(file_name);
                        console.log(temp_file);
                        $(return_value).val(temp_file);
                        console.log($(return_value).val());
                       
                    },
                    removedfile:function(file){
                        if(file.file){
                            fileremove.push(file.file);
                        }
                        img="";
                        var _ref;
                        temp_file.pop(file.file_name);
                        $(return_value).val(temp_file);
                        return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                    }
                }
            );
            return method;
        },
        removeAllFiles:function(){
            dropzone.removeAllFiles();
        },
        getFile:function(){
            var files=[];

            $.each(dropzone.files ,function(i,file){
                if(file.status != 'error'){
                    var obj=JSON.parse(file.xhr.response);
                    if(!obj.error){
                        files.push(obj.values);
                    }
                }

            });
//            console.log(fileremove);
            if(options.images){
                $.each(options.images,function(i,image){
                    if(fileremove.indexOf(image)<0){
                        files.push(image);
                    }
                });
            }
            return files;
        }
    };
    return method;

}();

var Upload_img=function(){
    var $element=null;
    var dropzone=null;
    var fileremove=[];
    var options;
    var return_value;
    var temp_file = new Array();
    var domain = $('#base_url').val();
    var method= {
        setup:function(_elem,_return,_folder,_options){
            options= $.extend({},_options);
            fileremove=[];
            $element=$(_elem);
            return_value = _return;
            folder = _folder;

            $element.dropzone(
                {
                    previewTemplate:['<div class="dz-preview dz-file-preview">',
                        '<a class="dz-view dz-remove" href="javascript:undefined;" data-dz-view="" target="_blank"><i class="fa fa-paperclip"></i> ดู</a>',
                        '<a class="dz-remove" href="javascript:undefined;" data-dz-remove=""><i class="fa fa-trash-o"></i> ลบ</a>',

                        '<div class="dz-details2">',
                        '<div class="dz-filename"><span data-dz-name></span>(<span class="dz-size" data-dz-size></span>)</div>',


                        '<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>',
                        '<div class="dz-success-mark"><span>?</span></div>',
                        '<div class="dz-error-mark"><span>?</span></div>',
                        '<div class="dz-error-message"><span data-dz-errormessage></span></div>',
                        '</div>',
                        // '<a class="dz-view" href="javascript:undefined;"><i class="fa fa-eye"></i> ดู</a>',

                        '</div>'].join(''),
                    url: domain+'/services/attachFile/'+folder,
                    maxFilesize: 200, // MB
                    // addRemoveLinks:true,
                    init: function () {
                        var thisDropzone = this;
                        dropzone = this;
                        // this.on("addedfile", function(file) { alert("Added file."); });
                        if(options.images){
                            $.each(options.images,function(i,image){
                                $.ajax({
                                    url: domain+'/services/getFile',
                                    type: 'POST',
                                    dataType:'json',
                                    data: {file:image},
                                    error: function(error) {
                                        console.log(error);
                                    },
                                    success: function(value) {
                                        var mockFile = {name: value.name, size: value.size ,file:value.file,path:value.path};
                                        thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                                        //thisDropzone.options.thumbnail.call(thisDropzone, mockFile, value.path);
                                        thisDropzone.options.complete.call(thisDropzone,mockFile);
                                        if(thisDropzone.options.maxFiles){
                                            var existingFileCount = 1; // The number of files already uploaded
                                            thisDropzone.options.maxFiles = thisDropzone.options.maxFiles - existingFileCount;
                                        }
                                    }
                                });
                            });

                        }
                    },
                    accept: function (file, done) {
                        console.log(file);
                        if (file.type == "image/jpeg" || file.type == 'image/png') {
                            done();
                        }else{ done('File type not accept.');}
                    },
                    success:function(file, response){
                        console.log(response);
                        _ref3 = file.previewElement.querySelectorAll("[data-dz-view]");
                       // console.log(file,_ref3);
                        for (_k = 0, _len2 = _ref3.length; _k < _len2; _k++) {
                            removeLink = _ref3[_k];
                            if(response.file){
                                removeLink.href= domain+"/"+response.file;
                            }
                        }
                        var file_name = response.file;
                        temp_file.push(file_name);
                        $(return_value).val(temp_file);
                        console.log($(return_value).val());
                    },
                    removedfile:function(file){
                        if(file.file){
                            fileremove.push(file.file);
                        }
                        img="";
                        var _ref;
                        temp_file.pop(file.file_name);
                        $(return_value).val(temp_file);
                        return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                    }
                }
            );
            return method;
        },
        getFile:function(){
            var files=[];

            $.each(dropzone.files ,function(i,file){
                console.log(file);
                if(file.status != 'error'){
                    var obj=JSON.parse(file.xhr.response);
                    if(!obj.error){
                        files.push(obj.values);
                    }
                }

            });
//            console.log(fileremove);
            if(options.images){
                $.each(options.images,function(i,image){
                    if(fileremove.indexOf(image)<0){
                        files.push(image);
                    }
                });
            }
            return files;
        }
    };
    return method;

}();


var Upload_doc=function(){
    var $element=null;
    var dropzone=null;
    var fileremove=[];
    var options;
    var return_value;
    var temp_file = new Array();
    var domain = $('#base_url').val();
    var method= {
        setup:function(_elem,_return,_folder,_options){
            options= $.extend({},_options);
            fileremove=[];
            $element=$(_elem);
            return_value = _return;
            folder = _folder;

            $element.dropzone(
                {
                    previewTemplate:['<div class="dz-preview dz-file-preview">',
                        '<a class="dz-view dz-remove" href="javascript:undefined;" data-dz-view="" target="_blank"><i class="fa fa-paperclip"></i> ดู</a>',
                        '<a class="dz-remove" href="javascript:undefined;" data-dz-remove=""><i class="fa fa-trash-o"></i> ลบ</a>',

                        '<div class="dz-details2">',
                        '<div class="dz-filename"><span data-dz-name></span>(<span class="dz-size" data-dz-size></span>)</div>',


                        '<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>',
                        '<div class="dz-success-mark"><span>?</span></div>',
                        '<div class="dz-error-mark"><span>?</span></div>',
                        '<div class="dz-error-message"><span data-dz-errormessage></span></div>',
                        '</div>',
                        // '<a class="dz-view" href="javascript:undefined;"><i class="fa fa-eye"></i> ดู</a>',

                        '</div>'].join(''),
                    url: domain+'/services/attachFile/'+folder,
                    maxFilesize: 20000, // MB
                    // addRemoveLinks:true,
                    init: function () {
                        var thisDropzone = this;
                        dropzone = this;
                        // this.on("addedfile", function(file) { alert("Added file."); });
                        if(options.images){
                            $.each(options.images,function(i,image){
                                $.ajax({
                                    url: domain+'/services/getFile',
                                    type: 'POST',
                                    dataType:'json',
                                    data: {file:image},
                                    error: function(error) {
                                        console.log(error);
                                    },
                                    success: function(value) {
                                        var mockFile = {name: value.name, size: value.size ,file:value.file,path:value.path};
                                        thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                                        //thisDropzone.options.thumbnail.call(thisDropzone, mockFile, value.path);
                                        thisDropzone.options.complete.call(thisDropzone,mockFile);
                                        if(thisDropzone.options.maxFiles){
                                            var existingFileCount = 1; // The number of files already uploaded
                                            thisDropzone.options.maxFiles = thisDropzone.options.maxFiles - existingFileCount;
                                        }
                                    }
                                });
                            });

                        }
                    },
                    accept: function (file, done) {
                        console.log(file.type);
                        if (file.type == "image/jpeg" || file.type == "image/jpg" || file.type == "application/pdf" || file.type == "image/bmp" ) {
                            done();
                        }else{ done('ประเภทของไฟล์ไม่ถูกต้อง ต้องเป็นไฟล์ .jpg หรือ .pdf เท่านั้น');}
                    },
                    success:function(file, response){
                        console.log(response);
                        _ref3 = file.previewElement.querySelectorAll("[data-dz-view]");
                       // console.log(file,_ref3);
                        for (_k = 0, _len2 = _ref3.length; _k < _len2; _k++) {
                            removeLink = _ref3[_k];
                            if(response.file){
                                removeLink.href= domain+"/"+response.file;
                            }
                        }
                        var file_name = response.file;
                        temp_file.push(file_name);
                        $(return_value).val(temp_file);
                        console.log($(return_value).val());
                    },
                    removedfile:function(file){
                        if(file.file){
                            fileremove.push(file.file);
                        }
                        img="";
                        var _ref;
                        temp_file.pop(file.file_name);
                        $(return_value).val(temp_file);
                        return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                    }
                }
            );
            return method;
        },
        getFile:function(){
            var files=[];

            $.each(dropzone.files ,function(i,file){
                if(file.status != 'error'){
                    var obj=JSON.parse(file.xhr.response);
                    if(!obj.error){
                        files.push(obj.values);
                    }
                }

            });
//            console.log(fileremove);
            if(options.images){
                $.each(options.images,function(i,image){
                    if(fileremove.indexOf(image)<0){
                        files.push(image);
                    }
                });
            }
            return files;
        }
    };
    return method;

}();