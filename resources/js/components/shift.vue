<template>
<div>
    <button @click="startShift(user)">edit</button>
    <span v-if="user.shift_active==1">Current user is active -
        last shit started  {{user.last_shift_start}}</span>
</div>



</template>

<script type="text/javascript">
    // Component code (not registered)
    module.exports={
      //  props: ["users"],
        data: function(){
            return{



            };
        },
        methods: {
            startShift() {
                axios.patch('api/users/' + user.id)
                    .then(response => {
                        // Copy object properties from response.data.data to this.user
                        // without creating a new reference
                        user.shift_active = !user.shift_active;
                        //Object.assign(user, response.data.data);
                        this.$emit('message', this.message)
                    })
                    .catch(erros => {
                        console.log(erros);
                    })
            },
            endShift() {
                axios.patch('api/users/' + user.id)
                    .then(response => {
                        // Copy object properties from response.data.data to this.user
                        // without creating a new reference
                        user.shift_active = !user.shift_active;
                        //Object.assign(user, response.data.data);
                        this.$emit('message', this.message)
                    })
                    .catch(erros => {
                        console.log(erros);
                    })


            },


        }
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