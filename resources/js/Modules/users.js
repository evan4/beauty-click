
import Vue from 'vue'
import router from '../router';

const users = {
  namespaced: true,
  state: {
    users: [],
    usersCount: 0,
    limit: 10,
    offset: 1,
  },
  getters: {
    users(state) {

      return state.users;

    },
    usersCount(state) {
      return state.usersCount;
    },
    perPage(state) {
      return state.limit;
    },
    currentuser(state){
      const id = +this.$route.query.id;
      return state.users.map(user => user.id === id);
    }
  },
  mutations: {
    getUsers(state, payload) {
      const {users} = payload;

      state.users = users.data;
      state.usersCount = +users.total;

    },
    deleteuser(state, payload) {

    }
  },
  actions: {
    // получение списка пользователей
    getUsers({ commit, state }, payload) {
      let {page, sortDesc, sortBy} = payload;

      Vue.http.get(`users`, { 
        params: {
          page,
          sortDesc,
          sortBy
        } 
      })
        .then((response) => {
          return response.json();
        })
        .then(response => {
          console.log(response);
          commit('getUsers', response);
        }, response => {
          // error callback
        });
    },
    createUser({ dispatch, commit, state }, payload) {
        const {name, email, password, role} = payload;

        Vue.http.post(`users`, { 
          name, email, password, role
        })
          .then((response) => {
            return response.json();
          })
          .then(response => {
            console.log(response);
            dispatch('openAlert',{
              alertType : 'success',
              alertMsg : 'Пользователь успешно создан'
            })
            router.push( '/dashboard/users' );
          }, response => {
            
          });
    },
    checkEmailUniqueness({ commit, state }, payload) {
      return new Promise((resolve, reject) => {
        Vue.http.post(`users/checkEmailUniqueness`, {email: payload})
        .then((response) => {
          return response.json();
        })
        .then(response => {
          resolve(response.success)
        }, response => {
          reject()
        });
      })
    },
    deleteuser({ commit, state }, payload) {
      return new Promise((resolve, reject) => {
        const userId = !Number.isNaN(Number(payload)) ? +payload : null;

        if (userId) {
          Vue.http.delete(`users/${userId}`)
            .then((response) => {
              return response.json();
            })
            .then(response => {
              if(response.success){
                resolve(response.success)
              }else{
                reject()
              }
              
            }, response => {
              reject()
            });
        }
      })
    }
  },
};

export default users;
