import Vue from 'vue'
import VueResource from 'vue-resource';
import BootstrapVue from 'bootstrap-vue';

import App from './App.vue'

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

Vue.use( BootstrapVue );
Vue.use(VueResource);

// router setup
import router from './router';
import store from './store';

Vue.prototype.$userEmail = document.querySelector("meta[name='user-email']").getAttribute('content');
Vue.http.options.root = "/api/backend/";

fetch("/api/backend/login", {  
  method: 'post',  
  headers: {
    "ccept": "application/json",
    "Content-type": "application/json"  
  },  
  body: JSON.stringify({email: Vue.prototype.$userEmail})
})
.then((response) => {
  return response.json();
})
.then( (data) => {
  Vue.http.headers.common['Authorization'] = `${data.token_type} ${data.access_token}`;
  Vue.prototype.$role = data.role;
  Vue.prototype.$expires_in = data.expires_in; 
  new Vue( {
    router,
    store,
    render: h => h( App ),
  } ).$mount( '#app' );
})  
.catch(function (error) {  
  console.log('Request failed', error);  
});

/* eslint-disable no-new */