import Vue from 'vue';
import Router from 'vue-router';

import Home from './components/Home/Home.vue';
import Users from './components/users/Users.vue';
import UserEdit from './components/users/UserEdit.vue';
import UserCreate from './components/users/UserCreate.vue';
import NotFound from './components/404/index.vue';

Vue.use( Router );

const routes = new Router( {
  mode: 'history',
  routes: [
    {
      path: '/dashboard/',
      name: 'home',
      component: Home,
    },
    {
      path: '/dashboard/users',
      component: Users,
    },
    {
      path: '/dashboard/users/create',
      component: UserCreate,
    },
    {
      path: '/dashboard/users/:id',
      component: UserEdit,
    },
    
    {
      path: '*',
      name: 'NotFound',
      component: NotFound,
    },
  ],
} );

export default routes;
