var meta = require('./package.json');
var gulp = require('gulp');
var del  = require('del');

gulp.task('default', ['help']);

// Copy dependencies in place
gulp.task('make', ['clean'], function() {
  gulp.src([
      './vendor/simplepie/simplepie/autoloader.php',
      './vendor/simplepie/simplepie/library/**/*'
    ])
    .pipe(gulp.dest('./inc/'));

  gulp.src([
      './node_modules/apache-server-configs/dist/.htaccess'
    ])
    .pipe(gulp.dest('./'));
});


// Clean up includes folder
gulp.task('clean', function () {
  del([
    'inc/'
  ])
});


gulp.task('help', function() {

  console.log('\n' + meta.name + ' v' + meta.version)
  var underline = meta.name.lenght
  console.log('================\n')
  console.log('Available tasks:')
  console.log('         help - this dialog')
  console.log('        clean - delete inc-folder')
  console.log('         make - copy dependencies in place')

} )