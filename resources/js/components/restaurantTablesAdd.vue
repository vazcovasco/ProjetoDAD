<template>
	<div class="jumbotron">
		<h1>Create Table</h1>
        
        <form method="POST" action="api/create_tables/">
            <div class="form-group">
                <label for="table_number">Table Number</label>
                <input
                    type="text" class="form-control" v-model="form.table_number"
                    name="name" id="name"/>
            </div>

        <br>
        <a class="btn btn-default" v-on:click.prevent="createTable()">Add</a>
        <a class="btn btn-default" v-on:click.prevent="cancelTable()">Cancel</a>
        </form>

        
	</div>

</template>

<script type="text/javascript">
    import Form from 'vform'
	// Component code (not registered)
	export default{
		//props: ["orders"],
		data: function(){
           	return{
                restaurant_tables: [],
                form: new Form({
                    table_number: '',
                })
            }			
		},
        methods: {
            getTables: function(){
              axios.get('api/restaurant_tables')
                    .then(response=>{ this.restaurant_tables = response.data; 
                    //console.log(response);
                    }); // ver a estrutura do json
						
            },
            createTable(){
                 this.form.post('api/restaurant_tables/')
                   .then(response => {          
                   })   
                   .catch(error => console.log('Whoops'));
            },
            cancelTable(){
                this.$router.push("/");
            }
			
        },
        mounted() {
            this.getTables();
		}
			
	}
</script>

<style scoped>
	tr.activerow {
  		background: #123456  !important;
  		color: #fff          !important;
}

</style>