@extends('master')

@section('title', 'Restaurant Manager')

@section('content')
<div>
    <div>
        <ul>
            <li><router-link to="/items">Menu</router-link></li> 
            <li v-if="this.$store.getters.loggedIn"><router-link to="/restaurantManagement">Restaurant Management</router-link></li>
            <li v-if="this.$store.getters.loggedIn"><router-link to="/profile">Profile</router-link></li>        
            <li style="float:right" class="active" v-if="!this.$store.getters.loggedIn"><router-link to="/login">Login</router-link></li>
            <li style="float:right" class="active" v-if="this.$store.getters.loggedIn"><router-link to="/logout">Logout</router-link></li>
        </ul>

        <shift :user="user" v-if="this.$store.getters.loggedIn"></shift>

        <div v-if="this.$store.getters.loggedIn">
            <table class="table">
                <tbody class="center">
                    <tr>
                        <div>
                        <input type="text" id="inputGlobal" class="inputchat" v-model="msgGlobalText" @keypress.enter="sendGlobalMsg">
                        </div> 
                        <div> 
                        <textarea id="textGlobal" class="inputchat" v-model="msgGlobalTextArea">Global Chat</textarea>
                        </div> 
                    </tr>
                </tbody>
            </table>
        </div>
          

        <router-view></router-view>

    </div>
</div>
    
@endsection

@section('pagescript')
<script src="js/vue.js">

import shift from '../../assets/js/components/shift.vue'

    export default {
        data: function(){
            return {
            }
        },  
        components: {
            'shift': shift
        },
    }

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

.center {
  text-align: center;
}
</style>