<template>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
  <nav class="navbar navbar-dark bg-drk-purple fixed-top flex-md-nowrap justify-content-between">
                <i class="fa fa-bars" aria-hidden="true"></i>
                <ul class="navbar-nav px-3">
                    <li class="nav-item text-nowrap">
                        
                      <a class="nav-link text-dark"  @click="logout">
                          <!-- <img src="image/user.jpg" alt=""> -->
                          Logout
                        </a>
                    </li>

                </ul>
            </nav>

    
</template>
<script>
  import { reactive , inject,ref, onMounted } from 'vue';
  import useValidate from '@vuelidate/core';
  import { required } from '@vuelidate/validators';
  import { useRouter } from "vue-router";
  import "../../css/custom.css"
export default {
    setup(){
      let cookies = inject('cookies')
      let isAuthenticated = ref(false)
      
      const router =useRouter();

      
      const checkLogin=async()=>{
        if(localStorage.getItem('access_token')){
          isAuthenticated.value = true;
        }
      }
      const logout = () =>{
        if(localStorage.getItem('access_token')){
          localStorage.setItem('access_token','')
          isAuthenticated.value = false;
          router.push('/')
        }
      }
      onMounted(checkLogin)
      return {
        
        isAuthenticated,
        logout
        
      }
    }
}
</script>
