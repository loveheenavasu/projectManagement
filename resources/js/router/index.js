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
]



const router=createRouter({
    history: createWebHistory(),
    routes
});
export default router;

