<template>
    <div class="jumbotron">
        <h1>Add User</h1>


        <form method="POST" action="api/users/">
            <div class="form-group">
                <label for="fullName">name</label>
                <input
                        type="text" class="form-control" v-model="form.name"
                        name="name" id="name"/>
            </div>
            <div class="form-group">
                <label for="username">username</label>
                <input
                        type="text" class="form-control" v-model="form.username"
                        name="name" id="name"/>
            </div>
            <div class="form-group">
                <label for="username">email</label>
                <input
                        type="text" class="form-control" v-model="form.email"
                        name="name" id="name"/>
            </div>
            <select v-model="form.type">
                <label for="username">Type</label>
                <option>Waiter</option>
                <option>Cook</option>
                <option>Manager</option>
            </select>

            <br>
            <a class="btn btn-default" v-on:click.prevent="CreateUser()">Add</a>
            <a class="btn btn-default" v-on:click.prevent="cancelAddUser()">Cancel</a>
        </form>


    </div>

</template>

<script type="text/javascript">
    import Form from 'vform'
    // Component code (not registered)
    export default{
        props: ["users"],
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
            CreateUser(){
                this.form.post('api/users/')
                // .then(response => console.log("Success"))
                    .then(response => {
                        console.log(response);
                    })
                    .catch(error => console.log('Whoops'));

            },
            getProfileImage(photo_url) {
                return `storage/profiles/${photo_url}`;
            },
            cancelAddUser(){
                this.$router.push("/");
            }



        },

    }
</script>

<style scoped>
    tr.activerow {
        background: #123456  !important;
        color: #fff          !important;
    }

</style>