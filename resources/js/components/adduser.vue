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
              <form @submit.prevent="addUser" >
                      <!-- Email input -->
                      <div class="form-outline mb-4">
                        <label class="form-label" for="form2Example1">Name </label>
                        <input type="text" id="form2Example1" class="form-control"  v-model="form.name" />
                        
                        <span class="error" v-for="error in v$.name.$errors" :key="error.$uid">
                              {{ error.$message}}
                            </span>
                      </div>
                      <div class="form-outline mb-4">
                        <label class="form-label" for="form2Example1">Email address</label>
                        <input type="email" id="form2Example1" class="form-control"  v-model="form.email" />
                        
                        <span class="error" v-for="error in v$.email.$errors" :key="error.$uid">
                              {{ error.$message}}
                            </span>
                      </div>

                      <!-- Password input -->
                      <div class="form-outline mb-4">
                        <label class="form-label" for="form2Example2">Password</label>
                        <input type="password" id="form2Example2" class="form-control" v-model="form.password" />
                        <span class="error" v-for="error in v$.password.$errors" :key="error.$uid">
                              {{ error.$message}}
                            </span>
                        
                      </div>

                      

                      <!-- Submit button -->
                      <button type="submit" class="btn btn-primary btn-block mb-4">Add user</button>

  
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

      const addUser = async()=>{
        // let res = await axios.post('api/auth-login',form);
        // console.log(res.token);
        // if(res.token){
        //   console.log(res.token);
        // }


        const result=await v$.value.$validate();
        if(result){
          axios.post('api/add-user',form, { headers:{
            Authorization: "Bearer "+localStorage.getItem('access_token')
            }}).then((response) => {
            console.log(response);
            if(response.data.success==false){
                alert(response.data.message);
            }else{
               router.push('/user-list')
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
      onMounted(checkLogin)
      return {
        v$,
        form,
        addUser,
        isAuthenticated,
        logout
        
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