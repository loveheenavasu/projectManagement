 <template>
   <Sidebar/>
  <main class="main">
     <Header/>       


            <div class="admin-block mb-3">
                <div class="container">
                  
                    <div class="row justify-content-center">
                        <div class="col-xl-8 col-sm-8 py-4 style-block">
                              <form @submit.prevent="updateUser" >
                      <!-- Email input -->
                      <div  class="form-outline mb-4">
                          <label class="form-label" for="form2Example1">Name </label>
                          <input type="text"  id="form2Example1" class="form-control" v-model="form.name"   />
                        
                          <span class="error" v-for="error in v$.name.$errors" :key="error.$uid">
                               {{ error.$message}}
                            </span>
                      </div>
                      <div class="form-outline mb-4">
                          <label class="form-label" for="form2Example1">Email address</label>
                          <input type="email"  id="form2Example1" class="form-control" v-model="form.email"    />
                        
                          <span class="error" v-for="error in v$.email.$errors" :key="error.$uid">
                              {{ error.$message}}
                            </span>
                      </div>
                      <div class="form-outline mb-4">
                          <label class="form-label" for="form2Example1">Password</label>
                          <input type="password"  id="form2Example1" class="form-control" v-model="form.password"/>
                        
                          <span class="error" v-for="error in v$.password.$errors" :key="error.$uid">
                              {{ error.$message}}
                            </span>
                      </div>
                      <input type="hidden" v-model="form.id" >

                      

                      

                      <!-- Submit button -->
                      <button type="submit" class="btn btn-primary btn-block mb-4">Update user</button>

  
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
     
      const users = ref(0);
      const form = reactive({
        email:'',
        name:'',
        password:''
      });
      const rules = {
        email:{required},
        name:{required},
        password:{required},
      };
      const v$=useValidate(rules, form)

      const editUser = async()=>{
        axios.get('/api/user-detail/'+id, { headers:{
            Authorization: "Bearer "+localStorage.getItem('access_token')
            }}).then((response) => {
              
              if(response.data.status=="Token is Expired"){
               this.logout();
              }else{
                  
              form.name=response.data.user.name;
              form.email=response.data.user.email;
              form.id=response.data.user.id;
              
              
              }
            
        }).catch((error) => {
            console.log('error page');
            console.log(error);
        })

        
        
      }
      const updateUser = async()=>{
        const result=await v$.value.$validate();
        if(result){
          console.log('test');
          axios.post('/api/update-user',form, { headers:{
            Authorization: "Bearer "+localStorage.getItem('access_token')
            }}).then((response) => {
            console.log(response);
            if(response.data.success==false){
                alert(response.data.message);
            }else{
               router.push('/user-list')
            }
            
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
      onMounted(editUser)
      return {
        v$,
        form,
        editUser,
        isAuthenticated,
        logout,
        id,
        updateUser
        
        
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