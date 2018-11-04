
/*
 |--------------------------------------------------------------------------
 | Laravel Spark Bootstrap
 |--------------------------------------------------------------------------
 |
 | First, we will load all of the "core" dependencies for Spark which are
 | libraries such as Vue and jQuery. This also loads the Spark helpers
 | for things such as HTTP calls, forms, and form validation errors.
 |
 | Next, we'll create the root Vue application for Spark. This will start
 | the entire application and attach it to the DOM. Of course, you may
 | customize this script as you desire and load your own components.
 |
 */

require('spark-bootstrap');
require('./components/bootstrap');



// import { DatePicker, TimeSelect, Select, Collapse, CollapseItem, Option } from 'element-ui'
// import lang from 'element-ui/lib/locale/lang/en'
// import locale from 'element-ui/lib/locale'


// configure language
// locale.use(lang)
// import components
// Vue.component(DatePicker.name, DatePicker)
// Vue.component(TimeSelect.name, TimeSelect)
// Vue.component(Select.name, Select)
// Vue.component(Collapse.name, Collapse)
// Vue.component(CollapseItem.name, CollapseItem)
// Vue.component(Option.name, Option)

Vue.use(require('./components/vue-full-calendar'))


Spark.forms.register = {
   
};

var app = new Vue({
    mixins: [require('spark')]
});
