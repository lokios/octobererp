+function ($) {
  'use strict';

  // ENTER CLASS DEFINITION
  // ======================

  var dataApi = '[data-transition="entrance"]'
  var Enter = function (element, options) {
    if (!$.support.transition) return

    this.element = element
    this.options = options
    this.handler = null

    this.addEventListeners()
  }

  Enter.VERSION = '3.3.5'

  Enter.DEFAULTS = {
    easing: 'cubic-bezier(.2,.7,.5,1)',
    duration: 1200,
    delay: 0
  }

  Enter.prototype.addEventListeners = function () {
    var boundScrollHandler = $.proxy(this.checkForEnter, this)

    this.listener = $(window).on('scroll.enter', (this.handler = function () {
      window.requestAnimationFrame(boundScrollHandler)
    }))

    this.checkForEnter()
  }

  Enter.prototype.removeEventListeners = function () {
    $(window).off('scroll.enter', this.handler)
  }

  Enter.prototype.checkForEnter = function () {
    var windowHeight  = window.innerHeight
    var rect          = this.element.getBoundingClientRect()

    if ((windowHeight - rect.top) >= 0) {
      setTimeout($.proxy(this.triggerEntrance, this), this.options.delay)
    }
  }

  Enter.prototype.triggerEntrance = function () {
    this.removeEventListeners()

    $(this.element)
      .css({'-webkit-transition': '-webkit-transform ' + this.options.duration + 'ms ' + this.options.easing,
                '-ms-transition': '-ms-transform ' + this.options.duration + 'ms ' + this.options.easing,
                    'transition': 'transform ' + this.options.duration + 'ms ' + this.options.easing
      })
      .css({'-webkit-transform': 'none',
                '-ms-transform': 'none',
                    'transform': 'none'
       })
      .trigger('enter.bs.enter')
  }



  // ENTER PLUGIN DEFINITION
  // =======================

  function Plugin(option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.enter')
      var options = $.extend(
        {},
        Enter.DEFAULTS,
        $this.data(),
        typeof option == 'object' && option
      )

      if (!data) $this.data('bs.enter', (data = new Enter(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  var old = $.fn.enter

  $.fn.enter             = Plugin
  $.fn.enter.Constructor = Enter


  // ENTER NO CONFLICT
  // =================

  $.fn.enter.noConflict = function () {
    $.fn.enter = old
    return this
  }


  // ENTER DATA-API
  // ==============

  $(function () {
    $(dataApi).enter()
  })

}(jQuery);
