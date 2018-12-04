<template>

	<div>
		<div class="jumbotron">
			<h1>{{ title }}</h1>
		</div>

		<div> 
	    <item-list :items="items" ></item-list>

		</div>
	</div>

</template>

<script type="text/javascript">
	
	export default {
		data: function(){
			return { 
		        title: 'List items',
		        showSuccess: false,
		        successMessage: '',
		        currentUser: null,
				items: [],
			}
		},
	    methods: {
	    	getItems: function(){
              axios.get('api/items')
					.then(response=>{ this.items = response.data; }); // ver a estrutura do json
						
			},
		},
	    mounted() {
			this.getItems();
		}	
	}

</script>

<style scoped>	
p {
	font-size: 2em;
	text-align: center;
}
</style>