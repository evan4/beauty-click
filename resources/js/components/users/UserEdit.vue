<template>
  <div>

  </div>
</template> 
<script>
import { mapGetters } from 'vuex';

export default {
    data() {
      return {
        id: ''
      }
    },
    created(){
      this.id = this.$route.query.id;

    },
    methods: {
      
      closeAlert(){
        this.$store.dispatch( 'closeAlert')
      }
    }
}
</script>