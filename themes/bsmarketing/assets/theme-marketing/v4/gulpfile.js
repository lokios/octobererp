var fs           = require('fs')
var gulp         = require('gulp')
var path         = require('path')
var sass         = require('gulp-sass')
var autoprefixer = require('gulp-autoprefixer')
var sourcemaps   = require('gulp-sourcemaps')
var cleanCSS     = require('gulp-clean-css')
var rename       = require('gulp-rename')
var concat       = require('gulp-concat')
var uglify       = require('gulp-uglify')
var connect      = require('gulp-connect')
var open         = require('gulp-open')
var babel        = require('gulp-babel')
var replace      = require('gulp-replace')
var wrapper      = require('gulp-wrapper')

var Paths = {
  HERE                 : './',
  DIST                 : 'dist',
  DIST_TOOLKIT_JS      : 'dist/toolkit.js',
  SCSS_TOOLKIT_SOURCES : './scss/toolkit*',
  SCSS                 : './scss/**/**',
  JS                   : [
      "./js/bootstrap/util.js",
      "./js/bootstrap/alert.js",
      "./js/bootstrap/button.js",
      "./js/bootstrap/carousel.js",
      "./js/bootstrap/collapse.js",
      "./js/bootstrap/dropdown.js",
      "./js/bootstrap/modal.js",
      "./js/bootstrap/tooltip.js",
      "./js/bootstrap/popover.js",
      "./js/bootstrap/scrollspy.js",
      "./js/bootstrap/tab.js",
      './js/custom/*'
    ]
}

var banner  = '/*!\n' +
  ' * Bootstrap\n' +
  ' * Copyright 2011-2016\n' +
  ' * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)\n' +
  ' */\n'
var jqueryCheck = 'if (typeof jQuery === \'undefined\') {\n' +
   '  throw new Error(\'Bootstrap\\\'s JavaScript requires jQuery. jQuery must be included before Bootstrap\\\'s JavaScript.\')\n' +
   '}\n'
var jqueryVersionCheck = '+function ($) {\n' +
  '  var version = $.fn.jquery.split(\' \')[0].split(\'.\')\n' +
  '  if ((version[0] < 2 && version[1] < 9) || (version[0] == 1 && version[1] == 9 && version[2] < 1) || (version[0] >= 4)) {\n' +
  '    throw new Error(\'Bootstrap\\\'s JavaScript requires at least jQuery v1.9.1 but less than v4.0.0\')\n' +
  '  }\n' +
  '}(jQuery);\n\n'

gulp.task('default', ['scss-min', 'js-min'])

gulp.task('watch', function () {
  gulp.watch(Paths.SCSS, ['scss-min']);
  gulp.watch(Paths.JS,   ['js-min']);
})

gulp.task('docs', ['server'], function () {
  gulp.src(__filename)
    .pipe(open({uri: 'http://localhost:9001/docs/'}))
})

gulp.task('server', function () {
  connect.server({
    root: 'docs',
    port: 9001,
    livereload: true
  })
})

gulp.task('scss', function () {
  return gulp.src(Paths.SCSS_TOOLKIT_SOURCES)
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer())
    .pipe(sourcemaps.write(Paths.HERE))
    .pipe(gulp.dest(Paths.DIST))
})

gulp.task('scss-min', ['scss'], function () {
  return gulp.src(Paths.SCSS_TOOLKIT_SOURCES)
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(cleanCSS({compatibility: 'ie9'}))
    .pipe(autoprefixer())
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(sourcemaps.write(Paths.HERE))
    .pipe(gulp.dest(Paths.DIST))
})

gulp.task('js', function () {
  return gulp.src(Paths.JS)
    .pipe(concat('toolkit.js'))
    .pipe(replace(/^(export|import).*/gm, ''))
    .pipe(babel({
        "compact" : false,
        "presets": [
          [
            "es2015",
            {
              "modules": false,
              "loose": true
            }
          ]
        ],
        "plugins": [
          "transform-es2015-modules-strip",
          "transform-object-rest-spread"
        ]
      }
    ))
    .pipe(wrapper({
       header: banner +
               "\n" +
               jqueryCheck +
               "\n" +
               jqueryVersionCheck +
               "\n+function () {\n",
       footer: '\n}();\n'
    }))
    .pipe(gulp.dest(Paths.DIST))
})

gulp.task('js-min', ['js'], function () {
  return gulp.src(Paths.DIST_TOOLKIT_JS)
    .pipe(uglify())
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(gulp.dest(Paths.DIST))
})
