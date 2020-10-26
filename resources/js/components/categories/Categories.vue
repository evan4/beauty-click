<template>
  <div>
    <div class="header-top">
      <h1>Список категорий</h1>

      <router-link class="btn btn-primary header-top__btn" role="button" 
      to="/dashboard/categories/create">
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
    :items="categories" :fields="fields"
    responsive="sm">
      <!-- A custom formatted column -->
      <template v-slot:cell(title)="data">
        <router-link class="nav-link" 
        :to="`/dashboard/categories/${data.item.id}`">{{ data.value }}</router-link>
      </template>

      <!-- A virtual column -->
      <template v-slot:cell(delete)="data">
        <i class="fas fa-trash-alt text-danger" role="button" @click="deleteCategory(data.item.id)"></i>
      </template>
    </b-table>

    <b-pagination v-if="categoriesCount > 10"
      v-model="currentPage"
      :total-rows="categoriesCount"
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
        sortBy: 'title',
        currentPage: 1,
        sortDesc: false,
        fields: [
          {
            key: 'title',
            label: 'Название',
            sortable: true
          },
          {
            key: 'description',
            label: 'Описание',
          },
          {
            key: 'delete',
            label: 'Удалить'
          },
        ]
      };
  },
  created() {

    this.$store.dispatch( 'categories/getCategories', {
      offset: 1,
      sortDesc: false,
      sortBy: 'title'
    } );

  },
  methods: {
    deleteCategory(id){
      this.$store.dispatch( 'categories/deleteCategory', id )
      .then(
        result => {
          
          this.$store.dispatch( 'categories/getCategories', {
            page: this.currentPage,
            sortDesc: this.sortDesc,
            sortBy: this.sortBy
          });
        },
        error => {
          console.log(error);
        }
      );
    
    },
    closeAlert(){
      this.$store.dispatch( 'closeAlert')
    }
  },
  computed: {
    ...mapGetters( 'categories', [ 'categories', 'categoriesCount', 'perPage' ] ),
    ...mapGetters( [ 'alertType', 'alertMsg', 'showAlert' ] ),
  },
  watch: {
    currentPage: function (newPage, oldPage) {
      
      this.$store.dispatch( 'categories/getCategories', {
          page: newPage,
          sortDesc: false,
          sortBy:  this.sortBy
        });
    },
    sortDesc: function (newDescValue, old) {
      
      this.$store.dispatch( 'categories/getCategories', {
        page: this.currentPage,
        sortDesc:  newDescValue,
        sortBy: this.sortBy
      });
    },
    sortBy: function (newsortBy, old) {
      this.$store.dispatch( 'categories/getCategories', {
        page: this.currentPage,
        sortDesc: this.sortDesc,
        sortBy: this.sortBy
      });
    },
  }
}
</script>