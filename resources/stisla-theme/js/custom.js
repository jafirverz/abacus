/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

require('./page/components-table');

require('./scripts');

require('./helper');

require('gasparesganga-jquery-loading-overlay/dist/loadingoverlay');

"use strict";

$(function() {
    if ($(".multi-select").length > 0) {
          $(".multi-select").each(function() {
              var a = $(this).find("select").attr("id");
              var n = "#" + a;
              console.log(n);
              document.multiselect(n);
          })
      }
  });

// CREATE SLUG
function slugify(text)
{
return text.toString().toLowerCase()
    .replace(/\s+/g, '-')           // Replace spaces with -
    .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
    .replace(/\-\-+/g, '-')         // Replace multiple - with single -
    .replace(/^-+/, '')             // Trim - from start of text
    .replace(/-+$/, '');            // Trim - from end of text
}

// TINYMCE EDITOR
var editor_config = {
    path_absolute: "/",
    selector: "textarea.my-editor",
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern",
        "autolink autoresize autosave"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | restoredraft | forecolor backcolor",
    valid_elements: "*[*]",
    valid_children: "+body[a],+a[div|h1|h2|h3|h4|h5|h6|p|#text]",
    forced_root_block: false,
    relative_urls: false,
    file_browser_callback: function (field_name, url, type, win) {
        var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName(
            'body')[0].clientWidth;
        var y = window.innerHeight || document.documentElement.clientHeight || document
            .getElementsByTagName('body')[0].clientHeight;

        var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
        if (type == 'image') {
            cmsURL = cmsURL + "&type=Images";
        } else {
            cmsURL = cmsURL + "&type=Files";
        }

        tinyMCE.activeEditor.windowManager.open({
            file: cmsURL,
            title: 'Filemanager',
            width: x * 0.8,
            height: y * 0.8,
            resizable: "yes",
            close_previous: "no"
        });
    }
};

tinymce.init(editor_config);

// TINYMCE EDITOR
$("span.max_length").text(0);
var max_words = 0;
var wordcount = 0;
var editor_config_ads = {
    selector: "textarea.my-ads-editor",
    plugins: 'wordcount link lists',
    toolbar: "undo redo | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link | numlist bullist",
    fontsize_formats: '8pt 10pt 11pt 12pt 14pt 18pt 24pt 36pt',
    menubar: false,
    init_instance_callback: function (editor_config_ads) {
        editor_config_ads.on('keyup', function (e) {
            $("input[name='post_type']").trigger("change");
        });
    },
    setup: function(editor_config_ads) {
        editor_config_ads.on( 'keydown', function( e ) {
            var post_type = $("input[name='post_type']:checked").val();
            if(post_type==2)
            {
                max_words = 1000;
            }
            else if(post_type==1)
            {
                max_words = 500;
            }
            $("input[name='post_type']").trigger("change");
            wordcount = tinymce.activeEditor.plugins.wordcount.getCount();
            if(wordcount>=max_words)
            {
                if(e.keyCode == 32)
                {
                    e.preventDefault();
                    return false;
                }
            }
        });
        editor_config_ads.on('Change redo undo', function (e) {
            var post_type = $("input[name='post_type']:checked").val();
            if(post_type==2)
            {
                max_words = 1000;
            }
            else if(post_type==1)
            {
                max_words = 500;
            }
            $("input[name='post_type']").trigger("change");
            wordcount = tinymce.activeEditor.plugins.wordcount.getCount();
            if(wordcount>max_words)
            {
                tinymce.activeEditor.undoManager.undo();
                e.preventDefault();
                return false;
            }
        });
    }
};

tinymce.init(editor_config_ads);

var editor_config1 = {
    selector: "textarea.my-editor1",
    plugins: 'wordcount link lists',
    toolbar: "undo redo | fontsizeselect bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link | numlist bullist",
    fontsize_formats: '8pt 10pt 11pt 12pt 14pt 18pt 24pt 36pt',
    menubar: false,
};

tinymce.init(editor_config1);


// MULTIPLE DELETE/ARCHIVE
$("body").on("change", "input[data-checkboxes='mygroup']", function() {
    var array_list = [];
    $.each($("input[data-checkboxes='mygroup']:checked"), function() {
        array_list.push($(this).val());
    });
    var index = array_list.indexOf('on');
    if(index > -1)
    {
        array_list.splice(index, 1);
    }
    $("a.destroy, a.archive, a.excel").removeClass("d-none");
    if(array_list.length<1)
    {
        $("a.destroy, a.archive, a.excel").addClass("d-none");
    }
    $("span.badge-transparent").text(array_list.length);
    $("input[name='multiple_delete'], input[name='multiple_archive'], input[name='excel_id']").val(array_list);
});
