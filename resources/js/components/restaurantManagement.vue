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
                    <td><router-link class="button" to="/staistics">Statistics</router-link></td>
                    <td><router-link class="button" to="/items">Items</router-link></td>
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
            title: 'Restaurant Management'
        }
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
