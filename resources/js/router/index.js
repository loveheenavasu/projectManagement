import { createRouter, createWebHistory } from 'vue-router'

import login from '../components/login'
import register from '../components/register'
import dashboard from '../components/dashboard'
import Welcome from '../components/Welcome'
import adduser from '../components/adduser'
import edituser from '../components/edituser'
import userList from '../components/userList'
import addproject from '../components/addproject'
import projectList from '../components/projectList'
import editproject from '../components/editproject'
import assignproject from '../components/assignproject'
import projectTasks from '../components/projectTasks'
import addTasks from '../components/addTasks'
import assignTasks from '../components/assignTasks'
import tasksdetails from '../components/tasksdetails'
import mytasks from '../components/mytasks'
import changeTaskStatus from '../components/changeTaskStatus'




const routes = [
    {
        path: "/",
        name: "login",
        component: login,
      },
    
    {
        path: '/register',
        name: 'register',
        component: register
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: dashboard
    },
    {
        path: '/add-user',
        name: 'adduser',
        component: adduser
    },
    {
        path: '/user-list',
        name: 'userList',
        component: userList
    },
    {
        path: '/user-edit/:id',
        name: 'edituser',
        component: edituser
    },
    {
        path: '/add-project',
        name: 'addproject',
        component: addproject
    },
    {
        path: '/project-list',
        name: 'projectList',
        component: projectList
    },
     {
        path: '/project-edit/:id',
        name: 'editproject',
        component: editproject
    },
    {
        path: '/assign-project',
        name: 'assignproject',
        component: assignproject
    },
    {
        path: '/project-tasks/:id',
        name: 'projectTasks',
        component: projectTasks
    },
    {
        path: '/add-tasks/:id',
        name: 'addTasks',
        component: addTasks
    },
    {
        path: '/assign-task/:project_id/:task_id',
        name: 'assignTasks',
        component: assignTasks
    },
    {
        path: '/task-details/:task_id',
        name: 'tasksdetails',
        component: tasksdetails
    },
    {
        path: '/my-tasks',
        name: 'mytasks',
        component: mytasks
    },
    {
        path: '/change-task-status/:id',
        name: 'changeTaskStatus',
        component: changeTaskStatus
    },
]



const router=createRouter({
    history: createWebHistory(),
    routes
});
export default router;
router.beforeEach((to, from, next) => {
   const publicPages = ['/'];
    const authRequired = !publicPages.includes(to.path);
  const token = localStorage.getItem('access_token')
  if (authRequired ) {
    if (!token) { 
      next('/');
    }
  }
  next();
});
