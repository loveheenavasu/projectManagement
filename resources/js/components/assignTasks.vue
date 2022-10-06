<template>
   <Sidebar/>
  <main class="main">
     <Header/>       


            <div class="admin-block mb-3">
                <div class="container">
                  
                  
                    <div class="row justify-content-center">
                        <div class="col-xl-8 col-sm-8 py-4 style-block">
                          
                            <form @submit.prevent="assignTask" >
                      <!-- Email input -->
                              
                              
                          <div class="form-outline mb-4">
                                <label class="form-label" for="form2Example1">Select user </label>
                              <select class="form-control" v-model="form.user_id" >
                                <option value="">Select</option>
                                <option  v-for="option in users" :value="option.id">
                                {{ option.name}}
                                </option>
                            </select>

                          </div>
                          <div class="form-outline mb-4">
                                <label class="form-label" for="form2Example1">Start date </label>
                                <input type="date" id="form2Example1" class="form-control"  v-model="form.starting_date" />
                                
                                <span class="error" v-for="error in v$.starting_date.$errors" :key="error.$uid">
                                      {{ error.$message}}
                                    </span>
                            </div>
                            <div class="form-outline mb-4">
                                <label class="form-label" for="form2Example1">Start date </label>
                                <input type="date" id="form2Example1" class="form-control"  v-model="form.end_date" />
                                
                                <span class="error" v-for="error in v$.ending_date.$errors" :key="error.$uid">
                                      {{ error.$message}}
                                    </span>
                            </div>
                            <div class="form-outline mb-4">
                                <label class="form-label" for="form2Example1">Select Staus </label>
                              <select class="form-control" v-model="form.status" >
                                <option value="">Select</option>
                                <option value="assigned">Assigned</option>
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                            </select>

                          </div>
                              <input type="hidden" v-model="form.project_id" >
                              <input type="hidden" v-model="form.task_id" >
                      
                                <!-- Submit button -->
                              <button type="submit" class="btn btn-primary btn-block mb-4">Assign Project to user</button>

  
            </form>
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
  import { useRouter,useRoute } from "vue-router";
export default {
    setup(){
      let cookies = inject('cookies');
      let isAuthenticated = ref(false);
      let users=ref(false);
      let project_id=ref(false);
      let task_id=ref(false);

      const router =useRouter()
      const route=useRoute()
      //const task_id = route.params.task_id;
     // const id = route.params.project_id;

      
      const form = reactive({
        user_id:'',
        starting_date:'',
        ending_date:'',
        status:''
      });
      const rules = {
        user_id:{required},
        starting_date:{required},
        ending_date:{required},
        status:{required},
      };
      const v$=useValidate(rules, form)

      const assignTask = async()=>{
        console.log('sadas');
        const result=await v$.value.$validate();
        if(result){
          axios.post('/api/assign-task',form, { headers:{
            Authorization: "Bearer "+localStorage.getItem('access_token')
            }}).then((response) => {
             console.log(response);
            if(response.data.success==false){
                alert(response.data.message);
            }else{
               router.push('/project-tasks/'+project_id)
            }
            //   if(response.data.token){
            //     console.log('hello');
            //     localStorage.setItem('access_token', response.data.token)
            //     isAuthenticated.value = true
            // }else{
            //   console.log('error');
            // }
        }).catch((error) => {
            console.log('error page');
        })
        }else{
          console.log('error form not submitted');
        }
        
      }

      const getUsers = async()=>{
       axios.get('/api/user-list', { headers:{
            Authorization: "Bearer "+localStorage.getItem('access_token')
            }}).then((response) => {
              
              console.log(response)
            if(response.data.status=="Token is Expired"){
               this.logout();
            }else{

              users.value=response.data.user;
              form.project_id=route.params.project_id;;
              form.task_id=route.params.task_id;;
              
              //user_role.value=
              
            }
        }).catch((error) => {
            console.log('error page');
            console.log(error);
        })
        
        
      }
      onMounted(getUsers)
      
      
      
      return {
        v$,
        form,
        isAuthenticated,
        getUsers,
        users,
        assignTask
        
        
      }

    },
    components: {
    'Header': Header,
    'Sidebar': Sidebar,
  }
}
</script>
<style>

  </style>