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
                        <label class="form-label" for="form2Example1">Project Name </label>
                        <input type="text" id="form2Example1" class="form-control"  v-model="form.name" />
                        
                        <span class="error" v-for="error in v$.name.$errors" :key="error.$uid">
                              {{ error.$message}}
                            </span>
                      </div>
                      

                      

                      

                      <!-- Submit button -->
                      <button type="submit" class="btn btn-primary btn-block mb-4">Add Project</button>

  
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
      
      
      
      return {
        v$,
        form,
        addProject,
        isAuthenticated,
        
        
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