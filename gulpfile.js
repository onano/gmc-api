const gulp = require("gulp");
const zip = require("gulp-zip");

gulp.task('zipit', function() {
    return gulp.src('./public/**/**/*.*')
        .pipe(zip('output.zip'))
        .pipe(gulp.dest('./'))
}); 