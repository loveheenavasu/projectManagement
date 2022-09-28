<template>
   <Header/>

<div class="container-fluid">
  <div class="row">
    
<Sidebar/>
    <main class="col-md-10" id="main">
      

      <section class="spacethis">
        <div class="row">
          <div class="col-md-6">
            <h5 class="title">Project List</h5>
               <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Assigned to</th>
                    <th>Action</th>
                    
                </tr>
            </thead>
            <tbody>
                <tr v-for='(user, index) in users'>
                    <td>{{user.name}} </td>
                    <td> 
                    <li v-if="!user.assigned_detail.length">No item found</li>
  <li v-for="item in user.assigned_detail">
    {{item.user_detail.name}}
  </li></td>
                    <td>
                      <router-link :to="'/project-edit/' + user.id">Edit</router-link> / <button @click="projectDelete(user.id,index)">Delete</button>
                    </td>
                    
                </tr>
            </tbody>
        </table>

  
                      
            
          </div>

          
        </div>
      </section>

      
    </main>
  </div>
</div>
    
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
        // let res = await axios.post('api/auth-login',form);
        // console.log(res.token);
        // if(res.token){
        //   console.log(res.token);
        // }


          axios.get('api/project-list', { headers:{
            Authorization: "Bearer "+localStorage.getItem('access_token')
            }}).then((response) => {
              
              console.log(response)
            if(response.data.status=="Token is Expired"){
               this.logout();
            }else{

              users.value=response.data.projects;
              
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
        async projectDelete(id,index){
         console.log(id, "sdfsf")
         
         // router.push('/user-list')
         
          const router =useRouter();
            axios.get('api/project-delete/'+id, { headers:{
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