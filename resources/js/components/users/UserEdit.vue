<template>
  <div>
    <h1>Редактирование пользователя</h1>
    <b-alert
      :show="showAlert"
      dismissible
      :variant="alertType"
      @input="closeAlert"
    >{{alertMsg}}</b-alert>

    <b-form @submit.prevent="onSubmit">
      
      <b-form-group id="input-group-2" label="Имя:" label-for="input-name">
        <b-form-input
          id="input-name"
          v-model="formData.name"
          required
          placeholder="Введите имя"
        ></b-form-input>
      </b-form-group>

      <b-form-group
        id="input-group-1"
        label="Email"
        label-for="input-email"
        description="Мы никогда не будем делиться вашей электронной почтой с кем-либо еще."
      >
       <b-form-input
          id="input-email"
          v-model="formData.email"
          type="email"
          @keyup="checkUniqueEmail"
          :disabled="disableEmailField"
          ref="email"
          required
          placeholder="email"
        ></b-form-input>
        <b-form-invalid-feedback :state="!uniqueEmail">{{uniqueEmailHint}}</b-form-invalid-feedback>
      </b-form-group>

       <b-form-group id="input-group-3" label="Пароль:" label-for="input-password"
        description="Your password must be min 8 characters long">

      <b-form-input
          id="input-password"
          v-model="formData.password"
          type="password"
          placeholder="Пароль"
        ></b-form-input>
      <b-form-invalid-feedback :state="!passwordValidation">{{passwordValidHint}}</b-form-invalid-feedback>

      </b-form-group>

      <b-form-group id="input-group-3" label="Роль" label-for="input-3">
        <b-form-select
          id="input-3"
          v-model="formData.role"
          :options="roles"
          required
        ></b-form-select>
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
        emailReg: /^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$/,
        uniqueEmail: false,
        uniqueEmailHint: 'Пользователь с таким email уже существует',
        passwordValidHint: 'Пароль должен быть не меньше 8 символов',
        errors: false,
        disableEmailField: false,
        originalEmail: null,
        formData: null,
        roles: [ 'клиент', 'продавец' ],
      }
    },
    created(){
     const user = this.$store.getters['users/currentuser'](+this.$route.params.id);
     this.originalEmail = user.email;
     this.formData = {
        id: user.id,
        email: user.email,
        name: user.name,
        password: '',
        role:  user.roles[0].name,
     }
    },
     computed: {
      ...mapGetters( [ 'alertType', 'alertMsg', 'showAlert' ] ),
      emailValidation() {
        return this.formData.email !== this.originalEmail && 
          this.emailReg.test(String(this.formData.email).toLowerCase());
      },
      passwordValidation(){
        return this.formData.password >= 8;
      }
    },
    methods: {
      checkUniqueEmail(){
        if(this.emailValidation){
          this.disableEmailField = true;

          this.$store.dispatch( 'users/checkEmailUniqueness', this.formData.email)
          .then(
            result => {
              console.log(result);
              if(result){
                this.uniqueEmail = true;
              }else{
                this.uniqueEmail = false;
              }
              this.disableEmailField = false;
              this.$refs.email.focus()
            },
            error => {
              this.$store.dispatch( 'openAlert', {
                alertType : 'danger',
                alertMsg : 'Произошла ошибка. Попробуйте еще раз'
              });
              this.disableEmailField = false;
              
            }
          );
          
        }else{
          this.uniqueEmail = false;
        }
        //
      },
      onSubmit(evt) {

        console.log(this.formData);

        if ( !this.formData.name ) {

          this.errors.push( 'Name required.' );

        }
        if ( !this.formData.email ) {

          this.errors.push( 'Email required.' );

        }
        if ( this.uniqueEmail ) {

          this.errors.push(this.uniqueEmailHint);

        }

        if ( !this.errors.length ) {
          
          this.$store.dispatch( 'users/updateUser', this.formData)

        }
      },
      closeAlert(){
        this.$store.dispatch( 'closeAlert')
      }
    },
    destroyed() {

      this.errors = [];
      this.formData = {
        id: null,
        name: '',
        email: '',
        password: '',
        role: '',
      };

    },
}
</script>