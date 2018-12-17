@extends('master')

@section('title', 'Restaurant Manager')

@section('content')
<div>
    <div>
        <ul>
            <li><router-link to="/items">Items</router-link></li> 
            <li><router-link to="/" v-show="this.$store.state.user">Restaurant Management</router-link></li>
            <li><router-link to="/profile" v-show="this.$store.state.user">Profile</router-link></li>        
            <li style="float:right" class="active"><router-link to="/login" v-show="!this.$store.state.user">Login</router-link></li>
            <li style="float:right" class="active"><router-link to="/logout" v-show="this.$store.state.user">Logout</router-link></li>
            <li><router-link to="/meals">Menu</router-link></li>
            <li><router-link to="/users">users</router-link></li>
        </ul>
        <router-view></router-view>
    </div>
    
</div>
    
@endsection

@section('pagescript')
<script src="js/vue.js"></script>
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