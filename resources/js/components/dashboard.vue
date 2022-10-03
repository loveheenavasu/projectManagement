<template>
   <Header/>

<div class="container-fluid">
  <div class="row">
    
    <Sidebar/>
    <main class="col-md-10" id="main">
      <section class="spacethis">
        <div class="row">
          <div class="col-md-6">
            <h5 class="title">Dash</h5>
            
            
          </div>

          
        </div>
      </section>

      
    </main>
  </div>
</div>
    
</template>
<script>
    import "../../css/theme_css/dashboard.css"
    import Header from './header'
    import Sidebar from './sidebar'
export default {
    setup: () => ({
        title: 'dashboard'
    }),
    components: {
    'Header': Header,
    'Sidebar': Sidebar,
  }
}
</script>