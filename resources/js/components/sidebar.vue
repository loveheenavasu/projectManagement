<template>
  <aside class="slidebar active" id="sidebar">
            <div class="sidebar-sticky">
                <a class="navbar-brand" href="#">Project Management</a>
                <ul class="nav flex-column">
                    <li class="nav-item" v-if="role == 'admin'">

                        <a  class="nav-link" href="/dashboard">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            Dashboard
                        </a>
                        
                    </li>
                    <li v-if="role == 'admin'" class="nav-item">
                        <a  class="nav-link" href="/user-list">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            Users
                        </a>
                        
                    </li>
                    <li  v-if="role == 'employee'" class="nav-item">
                        <a  class="nav-link" href="/my-tasks">
                           <i class="fa-solid fa-list-check"></i>
                            My tasks
                        </a>
                        
                    </li>
                    <li class="nav-item" v-if="role == 'admin'">
                        <a class="nav-link" href="/project-list">
                            <i class="fa-solid fa-list-check"></i>
                            Projects
                        </a>
                        
                    </li>
                   <!--  <li class="nav-item">
                        <a class="nav-link" href="#">
                            Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            Customers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fa fa-file" aria-hidden="true"></i>
                            Reports
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Integrations
                        </a>
                    </li>
                </ul>

                <h6 class="sidebar-heading d-flex align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Saved reports</span>
                    <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
                        <span data-feather="plus-circle"></span>
                    </a>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Current month
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Last quarter
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Social engagement
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Year-end sale
                        </a>
                    </li> -->
                </ul>
            </div>
        </aside>
</template>
 <script>
  import { reactive , inject,ref, onMounted } from 'vue';
  import useValidate from '@vuelidate/core';
  import { required } from '@vuelidate/validators';
  import { useRouter } from "vue-router";
  import "../../css/custom.css"
export default {
    setup(){
      
      let isAuthenticated = ref(false)
      let role = ref(false)
     
      const router =useRouter();

      
      const checkrole = () =>{
        role.value=localStorage.getItem('role');
    }
      onMounted(checkrole)
      return {
        isAuthenticated,
        checkrole,
        role
        
      }
    }
}
</script>
