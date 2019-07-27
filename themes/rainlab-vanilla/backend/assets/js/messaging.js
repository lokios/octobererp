
//notfications
var Notifications = function () {
    console.log('calling notification...');
    var self = this;
    self.nbox = $('.nbox');
    self.counter = self.nbox.find('.counter');
    self.count_unread = 0;
    self.notify_limit = 5;
    self.itemsContainer = self.nbox.find('.n_items');
    self.dataSource = {};

    self.onData = function (dataSource) {
        if (dataSource.count_unread !== '') {
            self.count_unread = dataSource.count_unread;
        }
        self.counter.text(self.count_unread);
        if (dataSource.count_unread && dataSource.count_unread > 0) {
            self.counter.addClass('active');
            $('.n_counter').addClass('btn-pink');

        }
        //add list into model
        var content = '';
        var notify_count = 0;
        var itemClass = 'read';
        if (dataSource.data) {
            self.itemsContainer.html('');
            $.each(dataSource.data, function (i, o) {
                if (o.s === 'unread') {
                    itemClass = 'unread';
                    //show notify 
                    if (o.n === 1 && notify_count < self.notify_limit) {
                        $.notify({
//                        icon: 'glyphicon glyphicon-warning-sign',
                            title: o.t,
                            message: o.m,
                            url: o.u,
                            target: '_blank',
                            class: 'unread',
                            nid: o.id
                        }); //, { showProgressbar: true }
                        notify_count++;
                    }

                }
                content = '<li class="n_item ' + itemClass + '" data-nid="' + o.id + '" data-url="' + o.u + '"><a href="#"><h4>' + o.t + '<small><i class="fa fa-clock-o"></i> ' + o.at + '</small></h4><p>' + o.m + '</p></a></li>';
//                content = '<li class="n_item ' + itemClass + '" data-nid="' + o.id + '" >' + o.view + '</li>';
                self.itemsContainer.append(content);


            });
        }
    };

    self.onRead = function (data) {
//      console.log('read event');
//      console.log(data);
        var params = {id: data.nid}
        var url = data.url;
        $.request('Notify::onNotificationRead', {
            data: params, success: function (dataSource) {
                self.count_unread = self.count_unread - 1;
                self.counter.text(self.count_unread);
                console.log('updated successfully!');
                console.log('URL : ' + url);
                if (url) {
                    window.location = url;
                    return false;
                }
            }
        });
    };

    self.onReadAll = function () {
        var params = {all: 'all'}
        $.request('Notify::onNotificationRead', {
            data: params, success: function (dataSource) {
                self.count_unread = 0;
                self.counter.text(self.count_unread);
                console.log('updated successfully!');
            }
        });
    };

    self.poll = function () {

        var params = {}

//        $.request('onNotificationsPoll', {
        $.request('Notify::onPoll', {
//        $.request('/backend/olabs/social/notifications/onPoll', {
            data: params, success: function (dataSource) {
                self.dataSource = dataSource;
                self.onData(dataSource)

            }, error: function ($el, context, textStatus, jqXHR) {

                try {
                    var errors = jQuery.parseJSON($el.responseText), validation_errors;
                } catch (e) {

                    $('.error-message').html($el.responseText);
                    $('.layout-header-msg').show();
                    return;
                }

            },
            complete: function () {
                setTimeout(function () {
                    self.poll();
                }, 30000)
            }
        });

    }
//    self.prepareModal();
    self.poll();

    $(document).on('click', '.n_author_photo', function (e) {
        e.preventDefault();
        var that = $(this);
        window.location = $(this).attr('href')
        return false;
    });

    $(document).on('click', '.n_author', function (e) {
        e.preventDefault();
        var that = $(this);
        window.location = $(this).attr('href')
        return false;
    });
    $(document).on('click', '.n_readAll', function (e) {
        e.preventDefault();
        var that = $(this);
        $('ul.n_items').find('li.unread').removeClass('unread').addClass('read');
        self.onReadAll();
        return false;
    });

    $(document).on('click', 'li.unread', function (e) {
        e.preventDefault();
        var that = $(this);
        var data = that.data();
        that.removeClass('unread').addClass('read');
        self.onRead(data);
        return false;
    });

    $(document).on('click', 'div.unread', function (e) {
        e.preventDefault();
        var that = $(this);
        var data = that.data();
        that.removeClass('unread').addClass('read');
        self.onRead(data);
        return false;
    });
    
    $(document).on('click', 'a.unread', function (e) {
        e.preventDefault();
        var that = $(this);
        var data = that.data();
        that.removeClass('unread').addClass('read');
        self.onRead(data);
        window.location = $(this).attr('href')
        return false;
    });

    $(document).on('click', 'li.read', function (e) {
        e.preventDefault();
        return false;
    });

}

var notifications = false;
$(function () {
    $.notifyDefaults({
        type: 'info',
        allow_dismiss: true,
        delay: 5000,
        template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                '<span data-notify="icon"></span> ' +
                '<span data-notify="title"><strong>{1}</strong></span> ' +
                '<span data-notify="message">{2}</span>' +
                '<div class="progress" data-notify="progressbar">' +
                '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                '</div>' +
                '<a href="{3}" target="{4}" class="{5}" data-nid="{6}" data-notify="url"></a>' +
                '</div>'
    });

    new Notifications();

//        $.notify({
//            // options
//            icon: 'glyphicon glyphicon-warning-sign',
//            title: 'Bootstrap notify',
//            message: 'Turning standard Bootstrap alerts into "notify" like notifications',
//            url: 'https://github.com/mouse0270/bootstrap-notify',
//            target: '_blank'
//        }, {
//            // settings
//            element: 'body',
//            position: null,
//            type: "info",
//            allow_dismiss: true,
//            newest_on_top: false,
//            showProgressbar: false,
//            placement: {
//                from: "top",
//                align: "right"
//            },
//            offset: 20,
//            spacing: 10,
//            z_index: 1031,
//            delay: 5000,
//            timer: 1000,
//            url_target: '_blank',
//            mouse_over: null,
//            animate: {
//                enter: 'animated fadeInDown',
//                exit: 'animated fadeOutUp'
//            },
//            onShow: null,
//            onShown: null,
//            onClose: null,
//            onClosed: null,
//            icon_type: 'class',
//            template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
//                    '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
//                    '<span data-notify="icon"></span> ' +
//                    '<span data-notify="title">{1}</span> ' +
//                    '<span data-notify="message">{2}</span>' +
//                    '<div class="progress" data-notify="progressbar">' +
//                    '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
//                    '</div>' +
//                    '<a href="{3}" target="{4}" data-notify="url"></a>' +
//                    '</div>'
//        });
});

