<template>
    <div>
        <h2>Pizza Orders</h2>
            <!-- Pagination -->
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li v-bind:class="[ {disabled: !pagination.previous_page_url} ]" class="page-item"><a class="page-link" href="#" @click="fetchPizzas(pagination.first_page_url)"> &lt;&lt; First </a></li>

                <li v-bind:class="[ {disabled: !pagination.previous_page_url} ]" class="page-item"><a class="page-link" href="#" @click="fetchPizzas(pagination.previous_page_url)"> &lt; Previous </a></li>

                <li class="page-item disabled"><a class="page-link text-dark" href="#"> Page {{ pagination.current_page }} of {{ pagination.last_page }} </a></li>

                <li v-bind:class="[ {disabled: !pagination.next_page_url} ]" class="page-item"><a class="page-link" href="#" @click="fetchPizzas(pagination.next_page_url)"> Next &gt; </a></li>
                
                <li v-bind:class="[ {disabled: !pagination.next_page_url} ]" class="page-item"><a class="page-link" href="#" @click="fetchPizzas(pagination.last_page_url)"> Last &gt;&gt;</a></li>
                
            </ul>
        </nav>

        <div v-for="pizza in pizzas" v-bind:key="pizza.id" class="card card-body mb-3">
            <h3> {{ pizza.customer_name }} </h3>
            <hr>
            <p> <strong> Pizza Type: </strong> {{ pizza.type }} </p>
            <p> <strong> Crust: </strong> {{ pizza.crust }} </p>

        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
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
            };
        },

        created() {
            this.fetchPizzas();
        },

        methods: {
            fetchPizzas(page_url) {
                let paginatevar = this;
                page_url = page_url || '/api/pizzas' 
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => { 
                        // console.log(res.data);
                        this.pizzas = res.data;
                        paginatevar.makePagination(res.meta, res.links);
                    })
                    .catch(error => console.log(error));
            },

            makePagination(meta, links) {
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,

                    next_page_url: links.next,
                    previous_page_url: links.prev,
                    first_page_url: links.first,
                    last_page_url: links.last
                }

                this.pagination = pagination;
            }
        }

    };
</script>