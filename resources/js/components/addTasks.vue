<template>
   <Sidebar/>
  <main class="main">
     <Header/>       


            <div class="admin-block mb-3">
                <div class="container">
                  
                  
                    <div class="row justify-content-center">
                        <div class="col-xl-8 col-sm-8 py-4 style-block">
                          
                            <form @submit.prevent="addTask" >
                      <!-- Email input -->
                              <div class="form-outline mb-4">
                                <label class="form-label" for="form2Example1">Task Name </label>
                                <input type="text" id="form2Example1" class="form-control"  v-model="form.taskname" />
                                
                                <span class="error" v-for="error in v$.taskname.$errors" :key="error.$uid">
                                      {{ error.$message}}
                                    </span>
                              </div>
                              <div class="form-outline mb-4">
                                <label class="form-label" for="form2Example1">Task Description </label>
                                <input type="text" id="form2Example1" class="form-control"  v-model="form.taskdetail" />
                                
                                <span class="error" v-for="error in v$.taskdetail.$errors" :key="error.$uid">
                                      {{ error.$message}}
                                    </span>
                              </div>
                              <!-- <div class="form-outline mb-4">
                                <label class="form-label" for="form2Example1">Select project </label>
                              <select class="form-control" v-model="form.project_id" >
                              <option  v-for="option in projectoption" :value="option.id">
                              {{ option.name}}
                              </option>
                            </select>
                          </div> -->
                              <input type="hidden" v-model="form.project_id" >
                      
                                <!-- Submit button -->
                              <button type="submit" class="btn btn-primary btn-block mb-4">Add Project</button>

  
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

      const router =useRouter()
      const route=useRoute()
      const id = route.params.id;
      let project_id=ref(false);
      
      const form = reactive({
        taskname:'',
        taskdetail:'',
        project_id:''
      });
      const rules = {
        taskname:{required},
        taskdetail:{required},
        project_id:{required}
      };
      const v$=useValidate(rules, form)

      const addTask = async()=>{
        console.log(form);
        const result=await v$.value.$validate();
        if(result){
          axios.post('/api/add-task',form, { headers:{
            Authorization: "Bearer "+localStorage.getItem('access_token')
            }}).then((response) => {
             console.log(response);
            if(response.data.success==false){
                alert(response.data.message);
            }else{
               router.push('/project-tasks/'+id)
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

      const getProject = async()=>{
          project_id
          form.project_id=id;
          
        
        
      }
      onMounted(getProject)
      
      
      
      return {
        v$,
        form,
        addTask,
        isAuthenticated,
        getProject,
        
        
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