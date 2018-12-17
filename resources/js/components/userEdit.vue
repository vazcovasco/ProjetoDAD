<template>
	<div class="jumbotron">
	    <h2>Edit User</h2>
			<div class="form-group">
				<label for="inputName">Name</label>
				<input type="text" class="form-control" v-model="user.name" name="name" id="inputName" placeholder="Name"/>
			</div>
			<div class="form-group">
				<label for="inputUserName">Username</label>
				<input type="text" class="form-control" v-model="user.username" name="username" id="inputUserName" placeholder="Username"/>
			</div>
			<div class="form-group">
				<label for="inputEmail">Email</label>
				<input type="email" class="form-control" v-model="user.email" name="email" id="inputEmail" placeholder="Email address"/>
			</div>
			<div class="form-group">
				<label>Photo</label><br>
				<img width="100px" :src="getProfileImage(user.photo_url)"><br><br>
				<div class="container">
					<div class="large-12 medium-12 small-12 cell">
						<label>
							<input type="file" id="file" ref="file" v-on:change="handleFileUpload()">
						</label>
						<button v-on:click="submitFile()">Submit</button>
					</div>
				</div>
			</div>
			<div class="form-group">
				<a class="btn btn-primary" v-on:click.prevent="saveUser()">Save</a>
				<a class="btn btn-light" v-on:click.prevent="cancelEdit()">Cancel</a>
			</div>
	</div>
</template>

<script type="text/javascript">
<<<<<<< HEAD

	props: ['user'],
	module.exports={

        data() {
            return {
				  user: {
                    email:"",
					username:"",
					name:"",
					file: ""
                },
				selectedFile: null
				

=======
	module.exports = {
        props: ['user'],
        data() {
            return {
				file: '',
>>>>>>> f8082f0e8ad3f44638721f702755e09cbf4370cf
            }
        },
	    methods: {
	        saveUser: function(){

	            axios.put('api/users/' + this.user.id, this.user)
	                .then(response=>{
						console.log(response)
	                	Object.assign(this.user, response.data.data);
	                	this.$emit('user-saved', this.user);
	                });
	        },
	        cancelEdit: function(){
	        	axios.get('api/update/'+this.user.id)
	                .then(response=>{
	                	Object.assign(this.user, response.data.data);
	                	this.$emit('user-canceled', this.user);
	                });
            },
            getProfileImage(photo_url) {
      			return `storage/profiles/${photo_url}`;
            },
			handleFileUpload() {
				this.file = this.$refs.file.files[0];
			},
			submitFile(){
				let formData = new FormData();
				formData.append('file', this.file);
				console.log(this.user);
				axios.post( 'api/upload',
					formData,
					{
						headers: {
							'Content-Type': 'multipart/form-data'
						}
					}
					).then((response)=>{
						console.log(this.user);
						this.user.photo_url = response.data.replace('public/profiles/','');

						console.log('SUCCESS!!');
					})
					.catch(function(){
						console.log('FAILURE!!');
					});
				}
			}
	}
</script>

<style scoped>	

</style>