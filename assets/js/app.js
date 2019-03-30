
const $ = require('jquery');
global.$ = global.jQuery = $;
require('materialize-css/dist/js/materialize')


$(document).ready(function () {

   $('select').formSelect();
});