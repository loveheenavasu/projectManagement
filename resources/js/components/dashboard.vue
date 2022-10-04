<template>
   


  <Sidebar/>
  <main class="main">
     <Header/>       


            <div class="admin-block mb-3">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-3 col-sm-6 py-2">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="color-deco" title="Number of Customers">Customers</h5>
                                    <h3 class="mt-3 mb-3">36,254</h3>
                                    <p class="mb-0">
                                        <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i> 5.27%</span>
                                        <span class="text-nowrap">Since last month</span>  
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 py-2">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="color-deco" title="Number of Customers">Customers</h5>
                                    <h3 class="mt-3 mb-3">36,254</h3>
                                    <p class="mb-0">
                                        <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i> 5.27%</span>
                                        <span class="text-nowrap">Since last month</span>  
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 py-2">
                             <div class="card">
                                <div class="card-body">
                                    <h5 class="color-deco" title="Number of Customers">Customers</h5>
                                    <h3 class="mt-3 mb-3">36,254</h3>
                                    <p class="mb-0">
                                        <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i> 5.27%</span>
                                        <span class="text-nowrap">Since last month</span>  
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 py-2">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="color-deco" title="Number of Customers">Customers</h5>
                                    <h3 class="mt-3 mb-3">36,254</h3>
                                    <p class="mb-0">
                                        <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i> 5.27%</span>
                                        <span class="text-nowrap">Since last month</span>  
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    
</template>
<script>
    import "../../css/custom.css"
    
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