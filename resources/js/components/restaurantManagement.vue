<template>
	<div>
		<div class="jumbotron">
			<h1>{{ title }}</h1>
        
        <table class="table table-striped">
            <tbody class="center">
                <tr>
                    <td><router-link class="button" to="/users">Users</router-link></td>
                    <td><router-link class="button" to="/orders">Orders</router-link></td>
                </tr>
                <tr>
                    <td><router-link class="button" to="/meals">Meals</router-link></td>
                    <td><router-link class="button" to="/invoices">Invoices</router-link></td>
                </tr>
                <tr>
                    <td><router-link class="button" to="/restaurant_statistics"> Restaurant Statistics</router-link></td>
                    <td><router-link class="button" to="/items">Items</router-link></td>
                </tr>
                <tr>
                    <td><router-link class="button" to="/restaurantTables">Tables</router-link></td>
                </tr>
            </tbody>
        </table>
    </div>
	</div>				
</template>

<script>
export default {
    data() {
        return {
            title: 'Restaurant Management',
            type: this.$store.state.user.type,
            isCook: false,
            isWaiter: false,
            isCashier: false,
            isManager: this.$store.getters.isManager
        }
    },
    methods: {
        returnUserType() {
            console.log(this.type);
            if(this.type === 'cook') {
                this.isCook = true;
            } else if(this.type === 'waiter') {
                this.isWaiter = true;
            } else if(this.type === 'cashier') {
                this.isWaiter = true;
            }
        }
    },
    created() {
        this.returnUserType();
    }
}
</script>

<style>
    .center {
        text-align: center;
    }

    .button {
        background-color: #4CAF50;
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
