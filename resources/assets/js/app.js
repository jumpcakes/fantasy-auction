
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
var moment = require('moment');
import VueEvents from 'vue-events'
Vue.use(VueEvents);

window.Event = new Vue();

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 Vue.use(require('vue-pusher'), {
    api_key: '13d6291867576b0aa8ac',
    options: {
        cluster: 'us2',
        encrypted: true,
    }
});

Vue.component('draft', require('./components/Draft.vue'));

const app = new Vue({
    el: '#app',
    data: {
    	interval: null,
		now: new Date(),
		dates: _.times(1, () => moment().add(60, 'seconds').toDate()).sort(),
		choosePlayer: false,
    },

    methods: {
    	startDraft() {
    		axios.post('/set_pick_order', {
                    message: 'asdf',
                  })
                  .then(function (response) {
                    console.log(response);
                  })
                  .catch(function (error) {
                    console.log(error);
                  });
    	},
    },
});


