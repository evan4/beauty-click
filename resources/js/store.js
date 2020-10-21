import Vue from 'vue';
import Vuex from 'vuex';

import users from './Modules/users';

Vue.use( Vuex );

export default new Vuex.Store( {
  state: {
    alertType: 'danger',
    alertMsg: 'Произошла ошибка. Попробуйте еще раз',
    showAlert: false
  },
  getters: {
    alertType(state){
      return state.alertType;
    },
    alertMsg(state){
      return state.alertMsg;
    },
    showAlert(state){
      return state.showAlert;
    }
  },
  mutations: {
    openAlert(state, payload){
      const {alertType, alertMsg} = payload;

      state.showAlert = true;
      state.alertType = alertType;
      state.alertMsg = alertMsg;
    },
    closeAlert(state, payload){
      state.showAlert = false;
    }
  },
  actions: {
    openAlert({ commit}, payload) {
      commit('openAlert', payload);
      setTimeout(() => {
        commit('closeAlert');
      }, 3000);
    },
    closeAlert({ commit}){
      commit('closeAlert');
    }
  },
  modules: {
    users,
  },
} );
