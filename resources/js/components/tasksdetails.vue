<template>
  <Sidebar/>
  <main class="main">
     <Header/>       


            <div class="admin-block mb-3">
                <div class="container">
                  
                  
                    <div class="row justify-content-center">
                        <div class="col-xl-8 col-sm-8 py-4 style-block">
                                                    <!-- <router-link :to="'/add-tasks/' + project_id" class="nav-link text-right">Add Task</router-link> -->
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Project Name</th>
                                        <th>Task Name</th>
                                        <th>Assign To User</th>
                                        <th>Starting Date</th>
                                        <th>Ending Date</th>
                                         <th>Status</th>
                                       
                                        <th>Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for='(user, index) in users'>
                                        <td>{{user.project.name}} </td>
                                        <td> 
                                        {{user.task_detail.taskname}} 
                                        </td>  
                                        <td>{{user.user.name}}</td>
                                        <td>{{user.starting_date}}</td>
                                         <td>{{user.ending_date}}</td>
                                          <td>{{user.status}}</td>




                                        <td>
                                          <!-- <router-link :to="'/project-edit/' + user.id">Edit</router-link> / --> <button @click="taskDelete(user.id,index)">Delete</button>
                                          
                                          <!-- <router-link :to="'/assign-task/' + project_id+'/'+user.id">Assign task</router-link> 
                                        /<router-link :to="'/view-task/'+task.id">View task Details</router-link> --> </td>
                                        
                                    </tr>
                                </tbody>
        </table>
                        </div>
                        
                        
                        
                    </div>
                </div>
            </div>
        </main>
    
</template>
<script>
  import { reactive , ref, onMounted } from 'vue';
  import useValidate from '@vuelidate/core';
  import { required } from '@vuelidate/validators';
  import "../../css/custom.css";
  import Header from './header';
  import Sidebar from './sidebar';
  import { useRouter,useRoute } from "vue-router";
export default {
    setup(){
      //let cookies = inject('cookies');
      let isAuthenticated = ref(false);
      const users = ref(0);
      const router =useRouter();

       const route=useRoute()
      const user_role=ref(0);
      const project_id=ref(0);

      console.log(router);
      const id = route.params.id; 
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


          axios.get('/api/task-detail/'+id, { headers:{
            Authorization: "Bearer "+localStorage.getItem('access_token')
            }}).then((response) => {
              
              console.log(response)
            if(response.data.status=="Token is Expired"){
               this.logout();
            }else{

              users.value=response.data.data;
              project_id.value=id;
              //user_role.value=
              
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
         router.push('/task-detail')
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
        useRouter,
        project_id
        
      }

    },
    components: {
    'Header': Header,
    'Sidebar': Sidebar,
  },
  methods:{
        async taskDelete(id,index){
        // console.log(id, "sdfsf")
         
         // router.push('/user-list')
         
          const router =useRouter();
            axios.get('api/assign-task-delete/'+id, { headers:{
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