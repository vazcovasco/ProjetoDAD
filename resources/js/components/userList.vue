<template>
	<table class="table table-striped">
	    <thead>
	        <tr>
	            <th>Name</th>
	            <th>Email</th>
	            <th>Age</th>
	            <th>Department</th>
	            <th>Actions</th>
	        </tr>
	    </thead>
	    <tbody>
	        <tr v-for="user in users"  :key="user.id" >
	            <td>{{ user.name }}</td>
	            <td>{{ user.username }}</td>
	            <td>{{ user.email }}</td>
	            <td ><img width="100px" :src="getProfileImage(user.photo_url)"></td>
	            <td>
					<router-link class="btn btn-default" :to="'/user/'+ user.id">Edit U </router-link>
                    <button @click="deleteUser(user)">Delete</button>
	            </td>
	        </tr>
	    </tbody>
	</table>
</template>

<script type="text/javascript">
	// Component code (not registered)
	module.exports={
		props: ["users"],
		data: function(){
			return{};			
		},
        methods: {
            editUser: function(user){
                this.editingUser = user;
                this.$emit('edit-click', user);
            },		
            deleteUser: function(user) {
     			 this.$emit("delete-user", user);
   				 		
			},
			getProfileImage(photo_url) {
      			return `storage/profiles/${photo_url}`;
			}
			
		}
		
		
	}
</script>

<style scoped>
	tr.activerow {
  		background: #123456  !important;
  		color: #fff          !important;
}

</style>