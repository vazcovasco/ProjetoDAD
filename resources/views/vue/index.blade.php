@extends('master')

@section('title', 'Restaurant Manager')

@section('content')
<div>
    <div>
        <ul>
            <li><router-link to="/items">Menu</router-link></li> 
            <li v-if="this.$store.getters.loggedIn && this.$store.getters.isManager"><router-link to="/restaurantManagement">Restaurant Management</router-link></li>
            <li v-if="this.$store.getters.loggedIn"><router-link to="/profile">Profile</router-link></li>        
            <li style="float:right" class="active" v-if="!this.$store.getters.loggedIn"><router-link to="/login">Login</router-link></li>
            <li style="float:right" class="active" v-if="this.$store.getters.loggedIn"><router-link to="/logout">Logout</router-link></li>
            <li><router-link to="/invoices">invoices</router-link></li>
            <li><router-link to="/orders">orders</router-link></li>
            <li><router-link to="/users">users</router-link></li>
            <li><router-link to="/meals">meals</router-link></li>

        </ul>
   <div>
        <shift :user="user" v-if="this.$store.getters.loggedIn" ></shift>
    </div>
        <router-view></router-view>

    </div>
</div>
    
@endsection

@section('pagescript')
<script src="js/vue.js">
</script>
 @stop  


<style lang="scss">
  ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #333;
}

li {
  float: left;
}

li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

li a:hover:not(.active) {
  background-color: #111;
}

.active {
  background-color: #4CAF50;
}
</style>