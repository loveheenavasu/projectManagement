require('./bootstrap');


import { createApp } from 'vue'
import router from './router'
import App from './layouts/App'
import "../css/bootstrap.css"

//const app = createApp({})


console.log('test');

//app.mount('#app')
createApp(App)
	.use(router)
		.mount('#app');
// createApp({
//     components: {
//         login
//     }
// }).use(router).mount('#app')

