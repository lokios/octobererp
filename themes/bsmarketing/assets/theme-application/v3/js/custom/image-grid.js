+function ($) {
  'use strict';

  // ENTER CLASS DEFINITION
  // ======================

  var dataApi = '[data-grid="images"]'

  var ImageGrid = function (element, options) {
    this.cleanWhitespace(element)

    this.row        = 0
    this.rownum     = 1
    this.elements   = []
    this.element    = element
    this.albumWidth = $(element).width()
    this.images     = $(element).children()
    this.options    = $.extend({}, ImageGrid.DEFAULTS, options)

    $(window).on('resize', $.proxy(this.handleResize, this))

    this.processImages()
  }

  ImageGrid.VERSION  = '3.3.1'

  ImageGrid.TRANSITION_DURATION = 350

  ImageGrid.DEFAULTS = {
    padding      : 10,
    targetHeight : 300,
    display      : 'inline-block'
  }

  ImageGrid.prototype.handleResize = function () {
    this.row = 0
    this.rownum     = 1
    this.elements   = []
    this.albumWidth = $(this.element).width()
    this.images     = $(this.element).children()
    this.processImages()
  }

  ImageGrid.prototype.processImages = function () {
    var that = this
    this.images.each(function (index) {
      var $this = $(this)
      var $img  = $this.is('img') ? $this : $this.find('img')

      var w = typeof $img.data('width') != 'undefined' ?
        $img.data('width') : $img.width()

      var h = typeof $img.data('height') != 'undefined' ?
        $img.data('height') : $img.height()

      $img.data('width',  w)
      $img.data('height', h)

      var idealW = Math.ceil(w / h * that.options.targetHeight)
      var idealH = Math.ceil(that.options.targetHeight)

      that.elements.push([this, idealW, idealH])

      that.row += idealW + that.options.padding

      if (that.row > that.albumWidth && that.elements.length) {
        that.resizeRow(that.row - that.options.padding)

        that.row      = 0
        that.elements = []
        that.rownum  += 1
      }

      if (that.images.length - 1 == index && that.elements.length) {
        that.resizeRow(that.row)

        that.row      = 0
        that.elements = []
        that.rownum  += 1
      }
    })
  }

  ImageGrid.prototype.resizeRow = function (row) {
    var that               = this
    var imageExtras        = (this.options.padding * (this.elements.length - 1))
    var albumWidthAdjusted = this.albumWidth - imageExtras
    var overPercent        = albumWidthAdjusted / (row - imageExtras)
    var trackWidth         = imageExtras
    var lastRow            = row < this.albumWidth

    for (var i = 0; i < this.elements.length; i++) {
      var $obj      = $(this.elements[i][0])
      var fw        = Math.floor(this.elements[i][1] * overPercent)
      var fh        = Math.floor(this.elements[i][2] * overPercent)
      var isNotLast = i < (this.elements.length - 1)

      trackWidth += fw

      if (!isNotLast && trackWidth < this.albumWidth) {
        fw += (this.albumWidth - trackWidth)
      }

      fw--

      var $img = $obj.is('img') ? $obj : $obj.find('img')

      $img.width(fw)
      $img.height(fh)

      this.applyModifications($obj, isNotLast)
    }
  }

  ImageGrid.prototype.applyModifications = function ($obj, isNotLast) {
    var css = {
      'margin-bottom'  : this.options.padding + 'px',
      'margin-right'   : (isNotLast) ? this.options.padding + 'px' : 0,
      'display'        : this.options.display,
      'vertical-align' : 'bottom'
      // 'overflow'       : 'hidden'
    }
    $obj.css(css)
  }

  ImageGrid.prototype.cleanWhitespace = function (element) {
    var textNodes = $(element)
      .contents()
      .filter(function() {
        return (this.nodeType == 3 && !/\S/.test(this.nodeValue))
      })
      .remove()
  }

  // IMAGE GRID PLUGIN DEFINITION
  // ============================

  function Plugin(option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.image-grid')
      var options = $.extend({}, ImageGrid.DEFAULTS, $this.data(), typeof option == 'object' && option)

      if (!data) $this.data('bs.image-grid', (data = new ImageGrid(this, options)))
      if (typeof option == 'string') data[option].call($this)
    })
  }

  var old = $.fn.imageGrid

  $.fn.imageGrid             = Plugin
  $.fn.imageGrid.Constructor = ImageGrid


  // IMAGE GRID NO CONFLICT
  // ======================

  $.fn.imageGrid.noConflict = function () {
    $.fn.imageGrid = old
    return this
  }


  // IMAGE GRID DATA-API
  // ===================

  $(function () {
    $('[data-grid="images"]').imageGrid()
  })


}(jQuery);
