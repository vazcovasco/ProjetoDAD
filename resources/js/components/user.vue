<template>
	<div>
		<div class="jumbotron">
			<h1>{{ title }}</h1>
		</div>
		
 		<router-link to="/users/add"> <button>Add</button>  </router-link>
		 
		 
		
		<user-list :users="users" @delete-click="deleteUser" ref="usersListRef" @edit-click="editUser"></user-list>

		<user-edit :user="currentUser" @user-saved="saveUser"  @user-canceled="cancelEdit" v-if="currentUser"></user-edit>


	</div>				
</template>

<script type="text/javascript">
	import UserEdit from './userEdit.vue';
	import UserList from './userList.vue';
	
	export default {
		data: function(){
			return { 
		        title: 'List Users',
		        editingUser: false,
				showSuccess: false,
				showFailure: false,
				successMessage: '',
				failMessage: '',
				currentUser: null,
				currentUserIndex: -1,
				users: [],
		    };
		},
	    methods: {
	         editUser: function(user){
	            this.currentUser = user;
				this.showSuccess = false;
				
	        },
	        deleteUser: function(user){		
	             axios.delete('api/users/', {params:{id:user.id}})
	                .then(response => {
	                    this.showSuccess = true;
						this.successMessage = 'User Deleted';
						this.getUsers();	                    
	                }); 
	        },
	        saveUser: function(){
                this.currentUser = null;
                this.$refs.usersListRef.editingUser = null;
                this.showSuccess = true;
                this.successMessage = 'User Saved';
            },
            cancelEdit: function(){
                this.currentUser = null;
                this.$refs.usersListRef.editingUser = null;
            },
	        getUsers: function(){
	            axios.get('api/users')
	                .then(response=>{this.users = response.data; });
			},
			childMessage: function(message){
				this.showSuccess = true;
	            this.successMessage = message;
			},
			toggleBlockUser: function(user){
                if (user.blocked === 1) {
					this.message = 'User Unbloked';

                } else {
                    this.message = 'User Bloked';
                }
                axios.post('api/users/block/'+user.id)
                    .then(response=>{
                        // Copy object properties from response.data.data to this.user
                        // without creating a new reference
						Object.assign(user, response.data.data);
						this.$emit('update-view',user);
                        this.$emit('message', this.message)
					});
				
            }
			
		},
		components: {
			'user-list':UserList,
			'user-edit':UserEdit
		}, 
	    mounted() {
			this.getUsers();
		}

		
	}
</script>

<style scoped>	
p {
	font-size: 2em;
	text-align: center;
}
</style>