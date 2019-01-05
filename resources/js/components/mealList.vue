<template>
    <div>
        <div class="container" id="meals">
            <div class="filter">
            <label for="active">
                <input id="active" type="radio" v-model="selectedCategory" value="active"/>Active
            </label>
            <label><input type="radio" v-model="selectedCategory" value="terminated"/> Terminated</label>
            <label><input type="radio" v-model="selectedCategory" value="paid"/> Paid</label>
            <label><input type="radio" v-model="selectedCategory" value="not paid"/> Not Paid</label>
        </div>
            filter data
            <div class="filter">
                <label><input type="text"  v-model="writtenDate" value="date" id="date"/>
                </label>
            </div>

            id_waiter_responsible
            <div class="filter">
                <label><input type="text"  v-model="writtenNumber" value="id_waiter"
                              id="id_waiter"/> </label>
            </div>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>id</th>
                    <th>Start</th>
                    <th>State</th>
                    <th>TableNumber</th>
                    <th>Responsible Waiter Id</th>
                    <th>Total Price Preview</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="meal in filteredMeals" :key="meal.id">
                    <td>{{ meal.id }}</td>
                    <td>{{ meal.start }}</td>
                    <td>{{ meal.state }}</td>
                    <td>{{ meal.table_number }}</td>
                    <td>{{ meal.responsible_waiter_id }}</td>
                    <td>{{ meal.total_price_preview}}</td>
                    <td>
                        <button v-if="meal.state=='active'" @click="showMeal(meal)">Show</button>
                    </td>

                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script type="text/javascript">
    // Component code (not registered)
    import moment from 'moment';

    export default {
        props: ["meals"],
        data: function () {
            return {
                selectedCategory: '',
                writtenNumber: '',
                writtenDate: '',
                showingMeal: null,

            };
        },
        methods: {
            getDate(date) {
                return moment(date, 'YYYY-MM-DD').format('YYYY-MM-DD');
            },
            showMeal: function (meal) {
                this.showingMeal = meal;
                this.$emit('show-click', meal);
            },
            startMeal: function () {
                this.$emit('meal-start-click');
            }
        },
        computed: {
            filteredMeals() {
                let category = this.selectedCategory;
                let inputValue = this.writtenNumber;
                let inputDate = this.writtenDate;


                return this.meals.filter((meal) => {
                    if (category === '' && (meal.state === 'active' || meal.state ==='terminated')) {
                        return true;
                    }

                    if (category === meal.state) {

                        let dateCmp = moment(inputDate, 'YYYY-MM-DD');
                        // console.log(dateCmp);

                        let dateCmpItem = moment(meal.start, 'YYYY-MM-DD');
                        console.log(dateCmpItem);

                        if (inputDate === '') {
                            return true;

                        }
                        console.log(dateCmp.diff(dateCmpItem));

                        if(dateCmp.diff(dateCmpItem) === 0) {

                            if (inputValue === '') {
                                return true;

                            }

                            if (inputValue.toString() === meal.responsible_waiter_id.toString()) {

                                return true;
                            }
                            return false;

                        }
                        return false;

                    }
                    return false;
                });
            }
        }
    }
</script>

<style scoped>
    tr.activerow {
        background: #123456 !important;
        color: #fff !important;
    }

</style>