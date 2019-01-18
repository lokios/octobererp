
//notfications
var Notifications = function() {
    console.log('calling notification...');
    var self = this;
    self.nbox = $('.nbox');
    self.counter = self.nbox.find('.counter');
    self.count_unread = 0;
    self.itemsContainer = self.nbox.find('.n_items');
    self.dataSource = {};

    self.onData = function(dataSource) {
        if (dataSource.count_unread !== '') {
            self.count_unread = dataSource.count_unread;
        }
        self.counter.text(self.count_unread);
        if (dataSource.count_unread && dataSource.count_unread > 0) {
            self.counter.addClass('active');
            $('.n_counter').addClass('btn-pink')
        }
        //add list into model
        var content = '';
        var itemClass = 'read';
        if (dataSource.data) {
            self.itemsContainer.html('');
            $.each(dataSource.data, function(i, o) {
                if (o.s === 'unread') {
                    itemClass = 'unread';
                }
                content = '<li class="n_item ' + itemClass + '" data-nid="' + o.id + '"><a href="#"><h4>' + o.t + '<small><i class="fa fa-clock-o"></i> ' + o.at + '</small></h4><p>' + o.m + '</p></a></li>';
//                content = '<li class="n_item ' + itemClass + '" data-nid="' + o.id + '" >' + o.view + '</li>';
                self.itemsContainer.append(content);
            });
        }
    };

    self.onRead = function(data) {
//      console.log('read event');
//      console.log(data);
        var params = {id: data.nid}
        $.request('Notify::onNotificationRead', {
            data: params, success: function(dataSource) {
                self.count_unread = self.count_unread - 1;
                self.counter.text(self.count_unread);
                console.log('updated successfully!');
            }
        });
    };

    self.onReadAll = function() {
        var params = {all: 'all'}
        $.request('Notify::onNotificationRead', {
            data: params, success: function(dataSource) {
                self.count_unread = 0;
                self.counter.text(self.count_unread);
                console.log('updated successfully!');
            }
        });
    };

    self.poll = function() {

        var params = {}

//        $.request('onNotificationsPoll', {
        $.request('Notify::onPoll', {
//        $.request('/backend/olabs/social/notifications/onPoll', {
            data: params, success: function(dataSource) {
                self.dataSource = dataSource;
                self.onData(dataSource)

            }, error: function($el, context, textStatus, jqXHR) {

                try {
                    var errors = jQuery.parseJSON($el.responseText), validation_errors;
                } catch (e) {

                    $('.error-message').html($el.responseText);
                    $('.layout-header-msg').show();
                    return;
                }

            },
            complete: function() {
                setTimeout(function() {
                    self.poll();
                }, 30000)
            }
        });

    }
//    self.prepareModal();
    self.poll();

     $(document).on('click', '.n_author_photo', function(e) {
        e.preventDefault();
        var that = $(this);
        window.location = $(this).attr('href')
        return false;
    });

    $(document).on('click', '.n_author', function(e) {
        e.preventDefault();
        var that = $(this);
        window.location = $(this).attr('href')
        return false;
    });
    $(document).on('click', '.n_readAll', function(e) {
        e.preventDefault();
        var that = $(this);
        $('ul.n_items').find('li.unread').removeClass('unread').addClass('read');
        self.onReadAll();
        return false;
    });

    $(document).on('click', 'li.unread', function(e) {
         e.preventDefault();
        var that = $(this);
        var data = that.data();
        that.removeClass('unread').addClass('read');
        self.onRead(data);
        return false;
    });

    $(document).on('click', 'li.read', function(e) {
         e.preventDefault();
         return false;
    });

}

var notifications = false;
$(function() {
    new Notifications();
})

