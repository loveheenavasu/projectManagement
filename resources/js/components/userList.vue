<template>
   <Sidebar/>
  <main class="main">
     <Header/>       


            <div class="admin-block mb-3">
                <div class="container">
                  
                  
                    <div class="row justify-content-center">
                        <div class="col-xl-8 col-sm-8 py-4 style-block">
                          <a class="nav-link text-right" href="/add-user">
                            Add user
                          </a>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for='(user, index) in users'>
                                        <td>{{user.name}} </td>
                                        <td>{{user.email}}</td>
                                        <td>
                                          <router-link :to="'/user-edit/' + user.id">Edit</router-link> / <button @click="userDelete(user.id,index)">Delete</button>
                                        </td>
                                        
                                    </tr>
                                </tbody>
                            </table>
                               <div class="pagination">
                          <nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item">
      <a class="page-link" href="#" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item">
      <a class="page-link" href="#" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav>
                        </div>

                        </div>
                        

                        
                    </div>

                </div>
            </div>
        </main>
    
</template>
<script>
  import { reactive , inject,ref, onMounted } from 'vue';
  import useValidate from '@vuelidate/core';
  import { required } from '@vuelidate/validators';
  import "../../css/custom.css";
  import Header from './header';
  import Sidebar from './sidebar';
  import { useRouter } from "vue-router";
export default {
    setup(){
      let cookies = inject('cookies');
      let isAuthenticated = ref(false);
      const users = ref(0);
      const router =useRouter();
      console.log(router);
      
      
      const form = reactive({
        email:'',
        password:'',
        name:''
      });
      const rules = {
        email:{required},
        password:{required},
        name:{required},
      };
      const v$=useValidate(rules, form)

      const getUsers = async()=>{
        axios.get('api/user-list', { headers:{
            Authorization: "Bearer "+localStorage.getItem('access_token')
            }}).then((response) => {
              
              console.log(response)
            if(response.data.status=="Token is Expired"){
               this.logout();
            }else{

              users.value=response.data.user;
              
            }
        }).catch((error) => {
            console.log('error page');
            console.log(error);
        })
        
        
      }
      
      const checkLogin=async()=>{
        if(localStorage.getItem('access_token')){
          isAuthenticated.value = true;
        }
      }
      const logout = () =>{
        if(localStorage.getItem('access_token')){
          localStorage.setItem('access_token','')
          isAuthenticated.value = false;
        }
      }
      const deleteFunc = () => {
         router.push('/user-list')
      }
      onMounted(getUsers)
      return {
        v$,
        form,
        getUsers,
        users,
        isAuthenticated,
        logout,
        deleteFunc,
        useRouter
        
      }

    },
    components: {
    'Header': Header,
    'Sidebar': Sidebar,
  },
  methods:{
        async userDelete(id,index){
         console.log(id, "sdfsf")
         
         // router.push('/user-list')
         
          const router =useRouter();
            axios.get('api/user-delete/'+id, { headers:{
            Authorization: "Bearer "+localStorage.getItem('access_token')
            }}).then((responsse) => {
              this.users.splice(index,1)
              
        }).catch((error) => {
            console.log('error page');
            console.log(error);
        })
        },
        
    }
}
</script>
<style>

  </style>