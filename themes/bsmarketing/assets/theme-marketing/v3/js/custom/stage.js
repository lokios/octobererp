+function ($) {
  'use strict';


  // STAGE CLASS DEFINITION
  // ======================

  var dataApi = '[data-toggle="stage"]'
  var Stage = function (element, options) {
    this.element = element
    this.options = options
  }

  Stage.VERSION = '3.3.5'

  Stage.TRANSITION_DURATION = 150

  Stage.DEFAULTS = {
    easing         : 'cubic-bezier(.2,.7,.5,1)',
    duration       : 300,
    delay          : 0,
    distance       : 250,
    hiddenElements : '#sidebar'
  }

  Stage.prototype.isOpen = function () {
    return $(this.element).hasClass('stage-open')
  }

  Stage.prototype.toggle = function () {
    if (this.isOpen()) {
      this.close()
    } else {
      this.open()
    }
  }

  Stage.prototype.open = function () {
    var that = this

    $(document.body).css('overflow', 'hidden')

    if ('ontouchstart' in document.documentElement) {
      $(document).on('touchmove.bs.stage', function (e) {
        e.preventDefault()
      })
    }

    $(this.options.hiddenElements).removeClass('hidden')

    $(window).one('keydown.bs.stage', $.proxy(function (e) {
      e.which == 27 && this.close()
    }, this))

    $(this.element)
      .on('click.bs.stage', $.proxy(this.close, this))
      .trigger('open.bs.stage')
      .addClass('stage-open')

    if (!$.support.transition) {
      $(that.element)
        .css({
          'left': this.options.distance + 'px',
          'position': 'relative'
        })
        .trigger('opened.bs.stage')
      return
    }

    $(this.element)
      .css({
        '-webkit-transition': '-webkit-transform ' + this.options.duration + 'ms ' + this.options.easing,
            '-ms-transition': '-ms-transform ' + this.options.duration + 'ms ' + this.options.easing,
                'transition': 'transform ' + this.options.duration + 'ms ' + this.options.easing
      })

    this.element.offsetWidth // force reflow

    $(this.element)
      .css({
        '-webkit-transform': 'translateX(' + this.options.distance + 'px)',
            '-ms-transform': 'translateX(' + this.options.distance + 'px)',
                'transform': 'translateX(' + this.options.distance + 'px)'
      })
      .one('bsTransitionEnd', function () {
        $(that.element).trigger('opened.bs.stage')
      })
      .emulateTransitionEnd(this.options.duration)
  }

  Stage.prototype.close = function () {
    $(window).off('keydown.bs.stage')

    var that = this

    function complete () {
      $(document.body).css('overflow', 'auto')

      if ('ontouchstart' in document.documentElement) {
        $(document).off('touchmove.bs.stage')
      }

      $(that.options.hiddenElements).addClass('hidden')

      $(that.element)
        .removeClass('stage-open')
        .css({
          '-webkit-transition': '',
              '-ms-transition': '',
                  'transition': ''
        })
        .css({
          '-webkit-transform': '',
              '-ms-transform': '',
                  'transform': ''
        })
        .trigger('closed.bs.stage')
    }

    if (!$.support.transition) {

      $(this.element)
        .trigger('close.bs.stage')
        .css({
          'left': '',
          'position': ''
        })
        .off('click.bs.stage')

      return complete()
    }

    $(this.element)
      .trigger('close.bs.stage')
      .off('click.bs.stage')
      .css({
        '-webkit-transform': 'none',
            '-ms-transform': 'none',
                'transform': 'none'
      })
      .one('bsTransitionEnd', complete)
      .emulateTransitionEnd(this.options.duration)
  }


  // STAGE PLUGIN DEFINITION
  // =======================

  function Plugin(option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.stage')
      var options = $.extend(
        {},
        Stage.DEFAULTS,
        $this.data(),
        typeof option == 'object' && option
      )

      if (!data) $this.data('bs.stage', (data = new Stage(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  var old = $.fn.stage

  $.fn.stage             = Plugin
  $.fn.stage.Constructor = Stage


  // STAGE NO CONFLICT
  // =================

  $.fn.stage.noConflict = function () {
    $.fn.stage = old
    return this
  }


  // STAGE DATA-API
  // ==============

  $(document).on('click', dataApi, function () {
    var options = $(this).data()
    var $target = $(this.getAttribute('data-target'))

    if (!$target.data('bs.stage')) {
      $target.stage(options)
    }

    $target.stage('toggle')
  })

}(jQuery);
