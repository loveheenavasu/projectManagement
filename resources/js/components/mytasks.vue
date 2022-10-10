<template>
  <Sidebar/>
  <main class="main">
     <Header/>       


            <div class="admin-block mb-3">
                <div class="container">
                  
                  
                    <div class="row justify-content-center">
                        <div class="col-xl-8 col-sm-8 py-4 style-block">
                          
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Task Name</th>
                                        <th>Task Detail</th>
                                        <th>Project Name</th>
                                        <th>Status</th>
                                        
                                        <th>Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for='(user, index) in users'>
                                        <td>{{user.user_task_detail.taskname}} </td>
                                        <td>{{user.user_task_detail.taskdetail}} </td>
                                        <td>{{user.project_detail.name}} </td>
                                         <td>{{user.status}}{{user.id}} </td>

                                        
                                        <td >
                                          
                                          
                                          <button v-if="user.status == 'assigned'" @click="changeStatus(user.task_id,'start')">Start task</button>
                                          
                                          <button v-if="user.status != 'assigned'" @click="changeStatus(user.task_id,'stop')">Stop task</button>
                                        </td>
                                        
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
          let user_id=localStorage.getItem('user_id');

          axios.get('/api/user-task-list/'+user_id, { headers:{
            Authorization: "Bearer "+localStorage.getItem('access_token')
            }}).then((response) => {
              
              console.log(response)
            if(response.data.status=="Token is Expired"){
               this.logout();
            }else{

              users.value=response.data.data;
              
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
        async changeStatus(id,working_status){
          if (window.confirm("Do you start task ?")) {
             let task_id=id;
             let user_id=localStorage.getItem('user_id');
             const form = {
                task_id:task_id,
                user_id:user_id,
                working_status:working_status
          };
             //console.log(user_id);
             
             // router.push('/user-list')
             
              const router =useRouter();
              axios.post('api/task-time',form, { headers:{
                  Authorization: "Bearer "+localStorage.getItem('access_token')
                  }}).then((response) => {
                    // this.users.splice(index,1)
                    //router.push('/my-tasks')
                    window.location.reload();
                    
              }).catch((error) => {
                  console.log('error page');
                  console.log(error);
              })
        }
        },
        
    }
}
</script>
<style>

  </style>