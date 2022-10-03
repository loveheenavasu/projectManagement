<template>
    <header>
  <nav class="navbar navbar-expand-lg navbar-light  custom-nav">
    <i class="fa fa-bars mobile-menu"></i>
        
        <ul class="navbar-nav mt-2 mt-lg-0">
           <!-- <li class="drop">
              <a class="nav-link bell-icon-badge" href="#">
                <i class="fa fa-bell-o" aria-hidden="true"></i>
                <span class="bell-badge">10</span>
              </a>

              <ul class="drop-menu">
                <li><a href="#">Art</a></li>
                <li><a href="">Coding</a></li>
                <li><a href="">Design</a></li>
                <li><a href="">Web Development</a></li>
            </ul>
        </li> -->

          <li class="nav-item">
              <button class="nav-link user-prfile"  @click="logout">
                <!-- <img src="image/user.jpg" alt=""> -->
                Logout
              </button>
          </li>
    </ul>
  </nav>
</header>
    
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
          router.push('/login')
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
<style>
  .custom-nav {
    background-color: #a94342;
    height: var(--nav-size);
}
.navbar-light .navbar-nav .nav-link {
    color: #000000;
    color: rgba(0,0,0,.5);
    background: #ffffff;
    border-radius: 12px;
    font-size: 14px;
    padding: 10px 20px;
}

.navbar-light .navbar-brand 
    {
      color: #ffffff;
}
.navbar{
    flex-flow: row nowrap;
    justify-content: flex-start;
    padding: 20px 30px;
}
.form-inline {
    display: flex;
    flex-flow: row wrap;
    align-items: center;
    margin-right: 0px;
}
.navbar-nav {
    display: flex;
    flex-direction: column;
    padding-left: 0;
    margin-bottom: 0;
    list-style: none;
    margin-left: 50px !IMPORTANT;
}

</style>