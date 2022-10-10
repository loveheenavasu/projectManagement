<template>
   <Sidebar/>
  <main class="main">
     <Header/>       


            <div class="admin-block mb-3">
                <div class="container">
                  
                  
                    <div class="row justify-content-center">
                        <div class="col-xl-8 col-sm-8 py-4 style-block">
                          
                            <form @submit.prevent="changeStatus" >
                      <!-- Email input -->
                               <div class="form-outline mb-4">
                                <label class="form-label" for="form2Example1">Select Staus </label>
                              <select class="form-control" v-model="form.status" >
                                <option value="">Select</option>
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                            </select>
                            <input type="hidden" v-model="form.task_id">
                            <input type="hidden" v-model="form.user_id">

                          </div>
                      
                                <!-- Submit button -->
                              <button type="submit" class="btn btn-primary btn-block mb-4">Update</button>

  
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
      const router =useRouter();
      const route=useRoute()
      
      const form = reactive({
        status:'',
        user_id:'',
        task_id:''
      });
      const rules = {
        status:{required},
        user_id:{required},
        task_id:{required}
      };
      const v$=useValidate(rules, form)

      const changeStatus = async()=>{
        const result=await v$.value.$validate();
        if(result){
          axios.post('/api/update-task-status',form, { headers:{
            Authorization: "Bearer "+localStorage.getItem('access_token')
            }}).then((response) => {
             console.log(response);
            if(response.data.success==false){
                alert(response.data.message);
            }else{
               router.push('/my-tasks')
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
      const getDetail = async()=>{
          form.user_id=localStorage.getItem('user_id');
          form.task_id=route.params.id;
      }
      
      onMounted(getDetail)
      
      return {
        v$,
        form,
        changeStatus,
        isAuthenticated,
        getDetail
        
        
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