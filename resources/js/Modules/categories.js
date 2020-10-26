
import Vue from 'vue'
import router from '../router';

const categories = {
  namespaced: true,
  state: {
    categories: [],
    categoriesCount: 0,
    limit: 10,
    offset: 1,
  },
  getters: {
    categories(state) {

      return state.categories;

    },
    categoriesCount(state) {
      return state.categoriesCount;
    },
    perPage(state) {
      return state.limit;
    },
    currentCategory: state => id => {
      return state.categories.find(category => category.id === id);
    }
  },
  mutations: {
    getCategories(state, payload) {
      const {categories} = payload;

      state.categories = categories.data;
      state.categoriesCount = +categories.total;

    },
  },
  actions: {
    // получение списка пользователей
    getCategories({ commit, state }, payload) {
      let {page, sortDesc, sortBy} = payload;

      Vue.http.get('categories', {
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
          commit('getCategories', response);
        }, response => {
          dispatch('openAlert',{
            alertType : 'danger',
            alertMsg : 'Произошла ошибка. Попробуйте еще раз'
          }, { root: true })
        });
    },
    createCategory({ dispatch, commit, state }, payload) {
        const {title, description } = payload;

         Vue.http.post('categories', { 
          title, description
         })
          .then((response) => {
            return response.json();
          })
          .then(response => {
            console.log(response);
            dispatch('openAlert',{
              alertType : 'success',
              alertMsg : 'Категория успешно создана'
            }, { root: true })
            router.push( '/dashboard/categories' );
          }, response => {
            dispatch('openAlert',{
              alertType : 'danger',
              alertMsg : 'Произошла ошибка. Попробуйте еще раз'
            }, { root: true })
          });
    },
    updateСategorн({ dispatch, commit, state }, payload) {
      const {title, description} = payload;
       Vue.http.patch(`categories/${id}`, { 
        title, description
       })
        .then((response) => {
          return response.json();
        })
        .then(response => {
          console.log(response);
          dispatch('openAlert',{
            alertType : 'success',
            alertMsg : 'Данные успешно обновлены'
          }, { root: true })
          router.push( '/dashboard/categories' );
        }, response => {
          dispatch('openAlert',{
            alertType : 'danger',
            alertMsg : 'Произошла ошибка. Попробуйте еще раз'
          }, { root: true })
        });
    },
    deleteCategory({ dispatch, commit, state }, payload) {
      return new Promise((resolve, reject) => {
        const categoryId = !Number.isNaN(Number(payload)) ? +payload : null;

        if (categoryId) {
          Vue.http.delete(`categories/${categoryId}`)
            .then((response) => {
              return response.json();
            })
            .then(response => {
              if(response.success){
                dispatch( 'openAlert', {
                  alertType : 'success',
                  alertMsg : 'Категория успешно удалена'
                }, { root: true });
                resolve(response.success)
              }else{
                dispatch('openAlert',{
                  alertType : 'danger',
                  alertMsg : 'Произошла ошибка. Попробуйте еще раз'
                }, { root: true });
                reject(response)
              }
              
            }, response => {
              dispatch('openAlert',{
                alertType : 'danger',
                alertMsg : 'Произошла ошибка. Попробуйте еще раз'
              }, { root: true });
              reject(response)
            });
        }
      });
    }
  },
};

export default categories;
