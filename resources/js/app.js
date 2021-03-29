/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('datatables.net-bs4/css/dataTables.bootstrap4.min.css');
require('datatables.net-bs4/js/dataTables.bootstrap4.min.js');

window.Vue = require('vue');
import router from './routers'
import {
    HasError,
    AlertError
} from 'vform';
import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';
import swal from 'sweetalert2';
import moment from 'moment';
import gate from './gate';
// import { format } from 'numeral';
import Form from "vform";
import excel from 'vue-excel-export'

Vue.use(excel)

// Vue.use(DataTable);

window.swal = swal
const toast = swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3000
});

window.toast = toast
window.Fire = new Vue()

window.moment = require('moment')

Vue.use(ViewUI);
Vue.component('pagination', require('laravel-vue-pagination'))
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.prototype.$gate = new gate(window.user);

//filters
Vue.filter('textformat', function (data) {
    return data.charAt(0).toUpperCase() + data.slice(1)
});

Vue.filter('dateformat', function (created) {
    return moment(created).startOf().fromNow();
});

Vue.filter('formatDate', date => moment(date).format('MMMM Do YYYY, h:mm:ss a'))
Vue.filter('formatDateNoTime', date => moment(date).format('MMM DD, YYYY'))
Vue.filter('formatDateMonthOnly', date => moment(date).format('MMMM'))
Vue.filter('formatTime', date => moment(date).format('h:mm A'))

Vue.filter('toCurrency', function (value) {
    if (typeof value !== 'number') {
        return value
    }
    var formatter = new Intl.NumberFormat('en-PH', {
        style: 'currency',
        currency: 'PHP',
        minimumFractionDigits: 2
    })
    return formatter.format(value)
})

let serverDateTime = document.head.querySelector('meta[name="server-datetime"]').content
let userType = document.head.querySelector('meta[name="user-type"]').content


window.serverDateTime = serverDateTime
window.userType = userType



// if (process.env.APP_ENV === 'local' ) {
//     
//     Vue.config.devtools = false;
//     Vue.config.debug = false;
//     Vue.config.silent = true;
// }


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('page404', require('./components/admin/pages/404_page.vue').default);
Vue.component('Top', require('./components/admin/pages/Top.vue').default);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
*/


const app = new Vue({
    el: '#app',
    router,
    data() {
        return {

            // url: "https://admins.alturush.com/ITEM-IMAGES/",
            // path: "https://admins.alturush.com/img/",
            url: "/ITEM-IMAGES/",
            path: "/img/",
            serverDateTime,
            userType,
            logo_path: 'https://apanel.alturush.com/',
            form: new Form({
                username: '',
                password: ''
            })

        }
    },
    methods: {
        updateProfile() {
            this.form.post('api/updateprofile/')
                .then(() => {
                    this.form.clear();
                    this.form.reset();
                    $("#useraccount").modal("hide");
                    swal.fire("Your profile successfully", "Updated", "success");
                    window.location.reload()
                })
                .catch(() => {

                })
        },

    },

});
