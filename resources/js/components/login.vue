<template>
 
      <form @submit.prevent="login" >
              <!-- Email input -->
          <div class="container login-form">
                <h2 class="login-text">Login</h2>
               <div id="wrong-input" class="w-50 mx-auto  alert alert-danger" role="alert" style="display:none">
              </div>
              <div class="form-group w-50 mx-auto">

                  <label class="form-label" for="form2Example1">Email address</label>
                  <input type="email" placeholder="Email" id="form2Example1" class="form-control"  v-model="form.email" />
                  <span class="error" v-for="error in v$.email.$errors" :key="error.$uid">
                        {{ error.$message}}
                  </span>
              </div>

              <!-- Password input -->
              <div class="form-outline mb-4 w-50 mx-auto">
                  <label class="form-label" for="form2Example2">Password</label>
                  <input type="password" placeholder="Password" id="form2Example2" class="form-control" v-model="form.password" />
                  <span class="error" v-for="error in v$.password.$errors" :key="error.$uid">
                        {{ error.$message}}
                  </span>
                
              </div>

          

            <!-- Submit button -->
            <div class="w-50 mx-auto">
                <button type="submit" class="btn btn-primary">Sign in</button>
            </div>
          </div>
  </form>


        
</template>
<script>
  import { reactive , inject,ref, onMounted } from 'vue';
  import useValidate from '@vuelidate/core';
  import { required } from '@vuelidate/validators';
  import { useRouter } from "vue-router";
  import "../../css/custom.css"
export default {
    setup(){
      let cookies = inject('cookies')
      let isAuthenticated = ref(false)
      const form = reactive({
        email:'',
        password:''
      });
      const rules = {
        email:{required},
        password:{required}
      };
      const v$=useValidate(rules, form)
      const router =useRouter();

      const login = async()=>{
        const result=await v$.value.$validate();
        if(result){
          axios.post('api/auth-login',form).then((response) => {
              if(response.data.token){
                console.log('hello');
                localStorage.setItem('access_token', response.data.token)
                localStorage.setItem('access_token', response.data.token)
                isAuthenticated.value = true;
                router.push('/dashboard')
            }else{
              document.getElementById('wrong-input').style.display = 'block';
              document.getElementById("wrong-input").innerHTML = "Invalid credential !!!";
            }
        }).catch((error) => {
            document.getElementById("wrong-input").innerHTML = "Invalid credential !!!";
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
        login,
        isAuthenticated,
        logout
        
      }
    }
}
</script>
<style>
.login-form{
      width: 100%;
    max-width: 450px;
    margin: auto;
    padding-top: 100px;
  }
  .login-text{
    text-align: center;
    padding-bottom: 20px;
  }
  </style>}
