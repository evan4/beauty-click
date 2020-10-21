<template>
  <div>
    <div class="header-top">
      <h1>Список пользователей</h1>

      <router-link class="btn btn-primary header-top__btn" role="button" 
      to="/dashboard/users/create">
          <span>Создать</span>
      </router-link>

    </div>
    
    <b-alert
      :show="showAlert"
      dismissible
      :variant="alertType"
      @input="closeAlert"
    >{{alertMsg}}</b-alert>

    <b-table striped hover 
    :sort-by.sync="sortBy"
    :sort-desc.sync="sortDesc"
    :current-page="currentPage"
    :items="users" :fields="fields"
    responsive="sm">
      <!-- A custom formatted column -->
      <template v-slot:cell(name)="data">
        <router-link class="nav-link" 
        :to="`/dashboard/users/${data.item.id}`">{{ data.value }}</router-link>
      </template>
      <template v-slot:cell(roles)="data">{{ data.value.length > 0 ? data.value[0].name : ''  }}</template>
      <!-- A virtual column -->
      <template v-slot:cell(delete)="data">
        <i class="fas fa-trash-alt text-danger" role="button" @click="deleteUser(data.item.id)"></i>
      </template>
    </b-table>
    <b-pagination
      v-model="currentPage"
      :total-rows="usersCount"
      :per-page="perPage"
      first-text="⏮"
      prev-text="⏪"
      next-text="⏩"
      last-text="⏭"
      class="mt-4"
      aria-controls="my-table"
    ></b-pagination>
  </div>
</template>
<script>
import { mapGetters } from 'vuex';

export default {
    data() {
      return {
        sortBy: 'name',
        currentPage: 1,
        sortDesc: false,
        fields: [
          {
            key: 'name',
            label: 'Имя',
            sortable: true
          },
          {
            key: 'email',
            sortable: true
          },
          {
            key: 'roles',
            label: 'Роль',
          },
          {
            key: 'delete',
            label: 'Удалить'
          },
        ]
      };
  },
  created() {

    this.$store.dispatch( 'users/getUsers', {
      offset: 1,
      sortDesc: false,
      sortBy: 'name'
    } );

  },
  methods: {
    deleteUser(id){
      this.$store.dispatch( 'users/deleteuser', id )
    },
    closeAlert(){
      this.$store.dispatch( 'closeAlert')
    }
  },
  computed: {
    ...mapGetters( 'users', [ 'users', 'usersCount', 'perPage' ] ),
    ...mapGetters( [ 'alertType', 'alertMsg', 'showAlert' ] ),
  },
  watch: {
    currentPage: function (newPage, oldPage) {
      
      this.$store.dispatch( 'users/getUsers', {
          page: newPage,
          sortDesc: false,
          sortBy:  this.sortBy
        });
    },
    sortDesc: function (newDescValue, old) {
      
      this.$store.dispatch( 'users/getUsers', {
        page: this.currentPage,
        sortDesc:  newDescValue,
        sortBy: this.sortBy
      });
    },
    sortBy: function (newsortBy, old) {
      this.$store.dispatch( 'users/getUsers', {
        page: his.currentPage,
        sortDesc: this.sortDesc,
        sortBy: newsortBy
      });
    },
  }
}
</script>