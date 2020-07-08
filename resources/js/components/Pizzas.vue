<template>
    <div>
        <h2>Pizzas</h2>
    </div>
</template>

<script>
    export default {
        data() {
            return  {
                pizzas: [],
                pizza: {
                    id: '',
                    customer_name: '',
                    type: '',
                    crust: ''
                },
                pizza_id: '',
                pagination: {},
                edit: false
            }
        },

        create() {
            this.fetchPizzas();
        },

        methods: {
            fetchPizzas() {
                fetch('api/pizzas')
                    .then(res => res.json())
                    .then(res => { 
                        console.log(res.data);
                    }); // balikan (dili maka log())
            }
        }

    };
</script>