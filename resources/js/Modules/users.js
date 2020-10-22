
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
    currentuser: state => id => {
      return state.users.find(user => user.id === id);
    }
  },
  mutations: {
    getUsers(state, payload) {
      const {users} = payload;

      state.users = users.data;
      state.usersCount = +users.total;

    },
  },
  actions: {
    // получение списка пользователей
    getUsers({ commit, state }, payload) {
      let {page, sortDesc, sortBy} = payload;

      Vue.http.get(`users`, {
        cache: false,
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
          dispatch('openAlert',{
            alertType : 'danger',
            alertMsg : 'Произошла ошибка. Попробуйте еще раз'
          }, { root: true })
        });
    },
    createUser({ dispatch, commit, state }, payload) {
        const {name, email, password, role} = payload;
        
         Vue.http.post('users', { 
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
            }, { root: true })
            router.push( '/dashboard/users' );
          }, response => {
            dispatch('openAlert',{
              alertType : 'danger',
              alertMsg : 'Произошла ошибка. Попробуйте еще раз'
            }, { root: true })
          });
    },
    updateUser({ dispatch, commit, state }, payload) {
      const {id, name, email, password, role} = payload;
      
       Vue.http.patch(`users/${id}`, { 
        name, email, password, role
      })
        .then((response) => {
          return response.json();
        })
        .then(response => {
          console.log(response);
          dispatch('openAlert',{
            alertType : 'success',
            alertMsg : 'Данные пользователя успешно обновлены'
          }, { root: true })
          router.push( '/dashboard/users' );
        }, response => {
          dispatch('openAlert',{
            alertType : 'danger',
            alertMsg : 'Произошла ошибка. Попробуйте еще раз'
          }, { root: true })
        });
    },
    checkEmailUniqueness({ commit, state }, payload) {
      return new Promise((resolve, reject) => {
        Vue.http.post('users/checkEmailUniqueness', {email: payload})
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
    deleteuser({ dispatch, commit, state }, payload) {
        const userId = !Number.isNaN(Number(payload)) ? +payload : null;

        if (userId) {
          Vue.http.delete(`users/${userId}`)
            .then((response) => {
              return response.json();
            })
            .then(response => {
              if(response.success){
                dispatch( 'openAlert', {
                  alertType : 'success',
                  alertMsg : 'Пользователь успешно удален'
                }, { root: true });
              }else{
                dispatch('openAlert',{
                  alertType : 'danger',
                  alertMsg : 'Произошла ошибка. Попробуйте еще раз'
                }, { root: true })
              }
              
            }, response => {
              dispatch('openAlert',{
                alertType : 'danger',
                alertMsg : 'Произошла ошибка. Попробуйте еще раз'
              }, { root: true })
            });
        }
    }
  },
};

export default users;
