var editor_config = {
    path_absolute: APP_URL + '/',
    selector: ".tiny-editor",
    font_formats: 'Roboto,sans-serif;',
    branding: false,
    plugins: [
        "advlist autolink lists link  charmap print preview hr anchor pagebreak variables",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime  nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern image  "
    ],
    toolbar: "insert | insertfile  undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | fontsizeselect | forecolor backcolor | image | code",
    fontsize_formats: "8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 20pt 22pt 24pt 26pt 28pt 36pt 48pt 72pt",
    menubar: "tools",
    valid_elements: "*[*]",
    valid_children: "+body[a],+a[div|h1|h2|h3|h4|h5|h6|p|#text]",
    forced_root_block: false,
    relative_urls: false,
    table_default_attributes: {
        border: '1'
    },
    table_responsive_width: true,
    content_css: [
        '/css/variable.css',
        '/css/font-awesome.css',
        '/css/slick.css',
        '/css/bootstrap-select.min.css',
        '/css/style.css',
        '/css/responsive.css',
        '/css/bootstrap-datetimepicker.css'
    ],
    variable_mapper: {
        course_cart_count: 'Course Cart Count',
        miscellaneous_fees_cart_count: 'Miscellaneous Fees Cart Count',
        event_cart_count: 'Event Cart Count',
        msg_content: 'Thank You Message',

    }
    // variable_prefix: '{{',
    // variable_suffix: '}}'
    // variable_class: 'bbbx-my-variable',
    , variable_valid: ['msg_content','course_cart_count', 'miscellaneous_fees_cart_count', 'event_cart_count'],
    file_browser_callback: function (field_name, url, type, win) {
        var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
        var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;
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


tinymce.init({

    // basic tinyMCE stuff
    path_absolute: APP_URL + '/',
    selector: ".email-editor",
    content_css: [
        '/css/variable.css',
        '/css/font-awesome.css',
        '/css/slick.css',
        '/css/bootstrap-select.min.css',
        '/css/style.css',
        '/css/responsive.css',
        '/css/bootstrap-datetimepicker.css'
    ],
    branding: false,
    plugins: [
        "variables,advlist autolink lists link  charmap print preview hr anchor pagebreak variables",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime  nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern image  "
    ],
    toolbar: "insert | insertfile  undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | fontsizeselect | forecolor backcolor | image | code",
    fontsize_formats: "8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 20pt 22pt 24pt 26pt 28pt 36pt 48pt 72pt",
    menubar: "tools",
    valid_elements: "*[*]",
    valid_children: "+body[a],+a[div|h1|h2|h3|h4|h5|h6|p|#text]",
    forced_root_block: false,
    relative_urls: false,
    table_default_attributes: {
        border: '1'
    },
    table_responsive_width: true,

    /* setup : function(ed) {
     window.tester = ed;
     ed.addButton('mybutton', {
     title : 'My button',
     text : 'Username',
     onclick : function() {
     ed.plugins.variables.addVariable('username');
     }
     });

     ed.on('variableClick', function(e) {
     console.log('click', e);
     });
     },*/

    // variable plugin related
    variable_mapper: {
        name: 'Name',
        phone: 'Phone',
        email: 'Email address',
        student_name: 'Name',
        student_id: 'Student Id',
        password: 'Password',
        amount: 'Amount',
        course_names: 'Courses',
        programme_name : 'programme',
        certificate_name: 'certificate',
        first_name: 'First Name',
        button_url: 'Button URL',
        url: 'url',
        payment_date: 'Payment Date',
        fee_amount: 'Fee Amount',
        organization_name: 'Organization Name',
        donation_date: 'Donation Date',
        donation_amount: 'Donation Amount',
        payment_mode: 'Payment Mode',
        payment_confirm: 'Payment Confirmation',
        church_name: 'Church Name',
        attendee_list: 'Attendee List',
        event_name: 'Name of Event',
        inquiry_type: 'Inquiry Type',
        message: 'Message',
        fee_type: 'Fee Type',
        attachment: 'Attachment',
        date: 'Date',
        discount: 'Discount',
        discount_code: 'Discount Code',
        order_id: 'Order ID',
        content: 'Content',
	logo:'logo',

    }
    , variable_valid: ['logo','name', 'phone', 'email', 'student_name', 'student_id', 'password', 'amount', 'course_names', 'programme_name', 'certificate_name', 'first_name', 'button_url', 'url', 'payment_date', 'fee_amount', 'organization_name', 'donation_date', 'donation_amount', 'payment_mode', 'payment_confirm', 'church_name', 'attendee_list', 'event_name', 'inquiry_type', 'message', 'fee_type', 'attachment', 'date', 'discount', 'order_id', 'content', 'discount_code'],
    file_browser_callback: function (field_name, url, type, win) {
        var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
        var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;
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
});
// Load multiple scripts
var scriptLoader = new tinymce.dom.ScriptLoader();

scriptLoader.add('/js/moment-with-locales.js');
scriptLoader.add('/js/bootstrap-datetimepicker.js');
scriptLoader.add('/js/animation.js');
scriptLoader.add('/js/bootstrap-select.min.js');
scriptLoader.add('/js/slick.js');
scriptLoader.add('/js/file-upload.js');
scriptLoader.add('/js/plugins.js');
scriptLoader.add('/js/megamenu.js');
scriptLoader.add('/js/bootstrap-datetimepicker.min.js');


tinymce.init({
    selector: "textarea.text-color-base ",  // change this value according to your HTML
    plugins: "textcolor colorpicker ",
    toolbar: "forecolor backcolor | bold italic | alignleft aligncenter alignright alignjustify| fontsizeselect",
    fontsize_formats: "8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 20pt 22pt 24pt 26pt 28pt 36pt 48pt 72pt",
    height: "100"
});

tinymce.init({
    selector: "textarea.simple-text-editor ",  // change this value according to your HTML
    plugins: "lists link code",
    toolbar: "forecolor backcolor | bold italic | alignleft aligncenter alignright alignjustify| fontsizeselect | code",
    fontsize_formats: "8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 20pt 22pt 24pt 26pt 28pt 36pt 48pt 72pt",
    height: "100"
});
