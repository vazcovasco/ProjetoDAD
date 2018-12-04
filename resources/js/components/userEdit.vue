<template>
<div class="jumbotron">
			<h1>Edit User</h1>   

      
        <form method="PUT" action="api/users/">
            <div class="form-group">
                <label for="name">name</label>
                <input
                    type="text" class="form-control" v-model="form.name"
                    name="name" id="name"/>
            </div>
            <div class="form-group">
                <label for="username">username</label>
                <input
                    type="text" class="form-control" v-model="form.username"
                    name="username" id="username"/>
            </div>
            <div class="form-group">
                <label for="email">email</label>
                <input
                    type="text" class="form-control" v-model="form.email"
                    name="email" id="email"/>
            </div>
            <select v-model="form.type">
                <label for="type">Type</label>
                <option>Waiter</option>
                <option>Cook</option>
                <option>Manager</option>
            </select>

            <br>
      <button @click="editUser()">Cancel</button>
        <button @click="saveUser()">Save</button>
        </form>

        
	</div>

</template>

<script type="text/javascript">
  import Form from 'vform'
	export default{
        props: ["user"],
        data: function(){
            return{  
                
                form: new Form({
                    name: '',         
                    username: '',
                    email: '',
                    type:''
                    })
                		
            }
        },
	    methods: {
            editUser(){
                this.form.name = this.user.name;
                this.form.username = this.user.username;
                this.form.email = this.user.email;
            },
            cancelEdit(){
                this.form.name='';
                this.form.username='';
                this.form.email ='';

            },
            updateUser(oldUser,newUser)
            {
                this.$http.patch("/user/"+oldUser.id, newUser).then(response => {
                        this.$emit('update-user');
                        console.log(response.data);
                });
            }
        }
            
		
	}
</script>

<style scoped>	

</style>