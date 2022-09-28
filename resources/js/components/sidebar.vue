<template>
<aside class="col-md-2" id="sidebar">
      <ul class="sidebar-menu">
        <li>
          <a href="" class="active"> <i class="fa fa-dashboard"></i> Dashboard</a>
        </li>
        <li>
          <a href="/add-user"> <i class="fa fa-shopping-bag" aria-hidden="true"></i>Add users</a>
        </li>
        
        <li>
          <a href="/user-list"> <i class="fa fa-list" aria-hidden="true"></i>Users List</a>
        </li>
        
              
      </ul>
    </aside>
</template>
  <script>
export default {
    setup: () => ({
        title: 'register'
    })
}
</script>
<style>
  #sidebar {
    background-color: #a94442;
    padding-top: 30px;
}
</style>