<template>
   


  <Sidebar/>
  <main class="main">
     <Header/>       


            <div class="admin-block mb-3">
                <div class="container">
                  
                    <div class="row justify-content-center">
                        <div class="col-xl-8 col-sm-8 py-4 style-block">
                          <div id="wrong-input" class="alert alert-danger" role="alert" style="display:none">
                  </div>
                            <form @submit.prevent="addUser" >
                      <!-- Email input -->
                              <div class="form-outline mb-4">
                                <label class="form-label" for="form2Example1">Name </label>
                                <input type="text" id="form2Example1" class="form-control"  v-model="form.name" />
                                
                                <span class="error" v-for="error in v$.name.$errors" :key="error.$uid">
                                      {{ error.$message}}
                                    </span>
                              </div>
                              <div class="form-outline mb-6">
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
                        <select class="form-control" v-model="form.role_id" >
                            <option  v-for="option in roleoption" :value="option.id">
                            {{ option.name}}
                            </option>
                          </select>
                            <span class="error" v-for="error in v$.role_id.$errors" :key="error.$uid">
                                  {{ error.$message}}
                            </span>
                      

                      <!-- Submit button -->
                      <button type="submit" class="btn btn-primary btn-block mt-4">Add user</button>

  
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
  import { useRouter } from "vue-router";
export default {
    setup(){
      let cookies = inject('cookies');
      let isAuthenticated = ref(false);
      const router =useRouter();
      let roleoption=ref(false);
      
      const form = reactive({
        name:'',
        email:'',
        password:'',
        role_id:''
      });
      const rules = {
        name:{required},
        email:{required},
        password:{required},
        role_id:{required},

      };
      const v$=useValidate(rules, form)

      const addUser = async()=>{
        const result=await v$.value.$validate();
        console.log(result);
        if(result){
          axios.post('api/add-user',form, { headers:{
            Authorization: "Bearer "+localStorage.getItem('access_token')
            }}).then((response) => {
            console.log(response);
            if(response.data.success==false){
                //alert(response.data.message);
                document.getElementById('wrong-input').style.display = 'block';
                document.getElementById("wrong-input").innerHTML =response.data.message;
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
      const getRoles=async()=>{
        console.log('yesy');
        axios.get('/api/role-list', { headers:{
            Authorization: "Bearer "+localStorage.getItem('access_token')
            }}).then((response) => {
              
              if(response.data.status=="Token is Expired"){
               this.logout();
              }else{
                  console.log(response);
                  roleoption.value=response.data.roles;
                 
              //form.name=response.data.projects;
              //form.id=id;
              
              
              
              }
            
        }).catch((error) => {
            console.log('error page');
            console.log(error);
        })
      }
      const logout = () =>{
        if(localStorage.getItem('access_token')){
          localStorage.setItem('access_token','')
          isAuthenticated.value = false;
        }
      }
      onMounted(getRoles)
      return {
        v$,
        form,
        addUser,
        getRoles,
        isAuthenticated,
        logout,
        roleoption
        
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