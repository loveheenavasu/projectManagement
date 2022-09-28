<template>
   <Header/>

<div class="container-fluid">
  <div class="row">
    
<Sidebar/>
    <main class="col-md-10" id="main">
      

      <section class="spacethis">
        <div class="row">
          <div class="col-md-6">
            <h5 class="title">Requests</h5>
              <form @submit.prevent="addProject" >
                      <!-- Email input -->
                      <div class="form-outline mb-4">
                        <label class="form-label" for="form2Example1">Select user </label>
                        
                         <select class="form-control" v-model="form.project" >
                            <option  v-for="option in useroption" :value="option.id">
                            {{ option.name}}
                            </option>
                          </select>
                        
                        <span class="error" v-for="error in v$.name.$errors" :key="error.$uid">
                              {{ error.$message}}
                            </span>
                      </div>
                      <div class="form-outline mb-4">
                        <label class="form-label" for="form2Example1">Select project </label>
                        
                         <select class="form-control" v-model="form.project" >
                            <option  v-for="option in projectoption" :value="option.id">
                            {{ option.name}}
                            </option>
                          </select>
                        
                        <span class="error" v-for="error in v$.name.$errors" :key="error.$uid">
                              {{ error.$message}}
                            </span>
                      </div>
                     

                      

                      

                      <!-- Submit button -->
                      <button type="submit" class="btn btn-primary btn-block mb-4">Assign Project</button>

  
            </form>
            
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
      const router =useRouter()
      
      const form = reactive({
        name:''
      });
      const rules = {
        name:{required},
      };
      let projectoption=ref(false);
      let useroption=ref(false);
      const v$=useValidate(rules, form)

      const addProject = async()=>{
        console.log(form);
        const result=await v$.value.$validate();
        if(result){
          axios.post('api/add-project',form, { headers:{
            Authorization: "Bearer "+localStorage.getItem('access_token')
            }}).then((response) => {
             console.log(response);
            if(response.data.success==false){
                alert(response.data.message);
            }else{
               router.push('/project-list')
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
      const projectList = async()=>{
        axios.get('/api/project-list', { headers:{
            Authorization: "Bearer "+localStorage.getItem('access_token')
            }}).then((response) => {
              
              if(response.data.status=="Token is Expired"){
               this.logout();
              }else{
                  console.log(response);
                  projectoption.value=response.data.projects;
                  console.log(projectoption,'asfsdf')
              //form.name=response.data.projects;
              //form.id=id;
              
              
              
              }
            
        }).catch((error) => {
            console.log('error page');
            console.log(error);
        })
        axios.get('/api/user-list', { headers:{
            Authorization: "Bearer "+localStorage.getItem('access_token')
            }}).then((response) => {
              
              if(response.data.status=="Token is Expired"){
               this.logout();
              }else{
                  console.log(response,'------');
                  useroption.value=response.data.user;
                  console.log(useroption,'asfsdf')
              //form.name=response.data.projects;
              //form.id=id;
              
              
              
              }
            
        }).catch((error) => {
            console.log('error page');
            console.log(error);
        })

        
        
      }
      
      onMounted(projectList)
      
      return {
        v$,
        form,
        projectList,
        addProject,
        isAuthenticated,
        selected: 1,
        projectoption,
        useroption
      
        
        
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