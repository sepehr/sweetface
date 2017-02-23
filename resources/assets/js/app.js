// Bootstrap Vue
require('./bootstrap');

Vue.component('sweetface', require('./components/SweetFace.vue'));

const app = new Vue({
    el: '#app'
});
