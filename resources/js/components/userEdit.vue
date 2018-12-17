<template>
	<div class="jumbotron">
	    <h2>Edit User</h2>
	    <div class="form-group">
	        <label for="inputName">Name</label>
	        <input
	            type="text" class="form-control" v-model="user.name"
	            name="name" id="inputName" 
	            placeholder="Name"/>
	    </div>
        <div class="form-group">
	        <label for="inputUserName">Username</label>
	        <input
	            type="text" class="form-control" v-model="user.username"
	            name="username" id="inputUserName" 
	            placeholder="Username"/>
	    </div>
	    <div class="form-group">
	        <label for="inputEmail">Email</label>
	        <input
	            type="email" class="form-control" v-model="user.email"
	            name="email" id="inputEmail"
	            placeholder="Email address"/>
	    </div>
	    <div class="form-group">
	        <label for="inputPhoto">Photo</label>
            <br>
	        <img  width="100px" :src="getProfileImage(user.photo_url)">
            <br>
            <input type="file" @change="onFileSelected">
            <button @click="onUpload">Upload</button>
	    </div>

	    <div class="form-group">
	        <a class="btn btn-primary" v-on:click.prevent="saveUser()">Save</a>
	        <a class="btn btn-light" v-on:click.prevent="cancelEdit()">Cancel</a>
	    </div>
	</div>
</template>

<script type="text/javascript">
	props: ["user"],
	module.exports={

        data() {
            return {
				  user: {
                    email:"",
					username:"",
					name:""
					
                },
				selectedFile: null
				
            }
        },
	    methods: {
	        saveUser: function(){

	            axios.put('api/users/' + this.user.id, this.user)
	                .then(response=>{
	                	Object.assign(this.user, response.data.data);
	                	this.$emit('user-saved', this.user);
	                });
	        },
	        cancelEdit: function(){
	        	axios.get('api/users/'+this.user.id)
	                .then(response=>{
	                	Object.assign(this.user, response.data.data);
	                	this.$emit('user-canceled', this.user);
	                });
            },
            getProfileImage(photo_url) {
      			return `storage/profiles/${photo_url}`;
            },
            onFileSelected(event) {
                this.selectedFile = event.target.files[0];
            },
            onUpload() {
                console.log("Here");
            }
		}
	}
</script>

<style scoped>	

</style>