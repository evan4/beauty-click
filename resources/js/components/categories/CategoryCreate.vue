<template>
  <div>
    <h1>Новая категория</h1>
    <b-alert
      :show="showAlert"
      dismissible
      :variant="alertType"
      @input="closeAlert"
    >{{alertMsg}}</b-alert>

    <b-form @submit.prevent="onSubmit">
      
      <b-form-group id="input-group-1" label="Название категории:" label-for="input-title">
        <b-form-input
          id="input-title"
          v-model="formData.title"
          required
          placeholder="Введите название категории"
        ></b-form-input>
      </b-form-group>

      <b-form-group id="input-group-2" label="Описание категории:" label-for="input-description">
        <b-form-textarea
          id="input-description"
          v-model="formData.description"
        ></b-form-textarea>
      </b-form-group>

      <b-button type="submit" variant="primary">Создать</b-button>
    </b-form>
  </div>
</template> 
<script>

import { mapGetters } from 'vuex';

export default {
    data() {
      return {
        errors: false,
        disableEmailField: false,
        formData: {
          title: '',
          description: '',
        },
      }
    },
    created(){
     
    },
     computed: {
      ...mapGetters( [ 'alertType', 'alertMsg', 'showAlert' ] ),
    },
    methods: {
      onSubmit(evt) {

        console.log(this.formData);

        if ( !this.formData.title ) {

          this.errors.push( 'Title required.' );

        }

        if ( !this.errors.length ) {
          
          this.$store.dispatch( 'categories/createCategory', this.formData)

        }
      },
      closeAlert(){
        this.$store.dispatch( 'closeAlert')
      }
    },
    destroyed() {

      this.errors = [];
      this.formData = {
        title: '',
        description: '',
      };

    },
}
</script>