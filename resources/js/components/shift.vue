<template>
<div>
    <a v-if="user.shift_active" class="btn btn-xs btn-success" @click.prevent="endShift(user)"
    >End Shift</a>
    <a v-else class="btn btn-xs btn-warning"  @click.prevent="startShift(user)"
    >Start Shift</a>
    <span v-if="user.shift_active">Current user is active - {{ this.$store.state.user.name}} -
         last shift started  {{this.$store.state.user.last_shift_start}} </span>
    <span v-else> Current user not active - {{ this.$store.state.user.name}} -
        last shift ended  {{this.$store.state.user.last_shift_end}}</span>
</div>
</template>
<script type="text/javascript">
    // Component code (not registered)
    module.exports={
       props: ["user"],
        data: function(){
            return{
            };
        },
        methods: {
            startShift: function(user){
               axios.post('api/users/start/'+user.id)
                    .then(response=>{
                        // Copy object properties from response.data.data to this.user
                        // without creating a new reference
                        //user.shift_active=!user.shift_active;
                        Object.assign(user, response.data.data);
                        this.$store.getters.startShift = response.data.shift_active;

                        user.shift_active = !user.shift_active;
                        this.$emit('update-view',user);
                        this.$emit('message', this.message)
                    });

            },
            endShift: function(user){
               axios.post('api/users/end/'+user.id)
                    .then(response=>{
                        // Copy object properties from response.data.data to this.user
                        // without creating a new reference
                        user.shift_active=!user.shift_active;
                        Object.assign(user, response.data.data);
                        this.$emit('update-view',user);
                        this.$emit('message', this.message)
                    });

            },

        },
        /*computed:{
            user(){
                return this.$store.state.user;
            }
        }*/
    }
</script>

<style scoped>
    tr.activerow {
        background: #123456  !important;
        color: #fff          !important;
    }

    .center {
        text-align: center;
    }

    .button {
        background-color: #4caf50;
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
    }
</style>