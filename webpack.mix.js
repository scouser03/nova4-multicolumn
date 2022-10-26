let mix = require("laravel-mix");

require("./nova.mix");

mix.setPublicPath("dist")
    .js("resources/js/field.js", "js")
    .vue({ version: 3 })
    .sass("resources/sass/field.scss", "css")
    .nova("scouser03/nova4-multicolumn");
