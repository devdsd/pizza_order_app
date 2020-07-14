<template>
  <div>
    <h2>Order a Pizza</h2>
    <!-- To Order a Pizza -->
    <div class="jumbotron">
      <form @submit.prevent="addPizza()" class="mb-5">
        <div class="form-group">
          
          <strong><p> Customer Name: <p></strong>
          <input class="form-control" placeholder="Customer Name" v-model="pizza.customer_name" />
        </div>

        <div class="form-group">
          <strong>
            <label for="pizzatype">Choose pizza type:</label>
          </strong>
          <select class="form-control" id="pizzatype" v-model="pizza.type">
            <option value selected>Select pizza type ...</option>
            <option
              v-for="pizzatype in pizzatypes"
              v-bind:key="pizzatype.type"
              v-bind:value="pizzatype.value"
            >{{ pizzatype.type }}</option>
          </select>
        </div>

        <div class="form-group">
          <strong>
            <label for="pizzabase">Choose base type:</label>
          </strong>
          <select class="form-control" id="pizzabase" v-model="pizza.crust">
            <option value selected>Select crust ...</option>
            <option
              v-for="pizzacrust in pizzacrusts"
              v-bind:key="pizzacrust.crust"
              v-bind:value="pizzacrust.value"
            >{{ pizzacrust.crust }}</option>
          </select>
        </div>

        <button class="btn btn-outline-info" type="submit">Order Pizza</button>
      </form>
    </div>

    <h2>Pizza Orders</h2>

    <!-- Pagination -->
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li v-bind:class="[ {disabled: !pagination.previous_page_url} ]" class="page-item">
          <a
            class="page-link"
            href="#"
            @click="fetchPizzas(pagination.first_page_url)"
          >&lt;&lt; First</a>
        </li>

        <li v-bind:class="[ {disabled: !pagination.previous_page_url} ]" class="page-item">
          <a
            class="page-link"
            href="#"
            @click="fetchPizzas(pagination.previous_page_url)"
          >&lt; Previous</a>
        </li>

        <li class="page-item disabled">
          <a
            class="page-link text-dark"
            href="#"
          >Page {{ pagination.current_page }} of {{ pagination.last_page }}</a>
        </li>

        <li v-bind:class="[ {disabled: !pagination.next_page_url} ]" class="page-item">
          <a class="page-link" href="#" @click="fetchPizzas(pagination.next_page_url)">Next &gt;</a>
        </li>

        <li v-bind:class="[ {disabled: !pagination.next_page_url} ]" class="page-item">
          <a class="page-link" href="#" @click="fetchPizzas(pagination.last_page_url)">Last &gt;&gt;</a>
        </li>
      </ul>
    </nav>

    <!-- Main Pizza Order Container -->
    <div v-for="pizza in pizzas" v-bind:key="pizza.id" class="card card-body mb-3">
      <h3>{{ pizza.customer_name }}</h3>
      <hr />
      <p>
        <strong>Pizza Type:</strong>
        {{ pizza.type }}
      </p>
      <p>
        <strong>Crust:</strong>
        {{ pizza.crust }}
      </p>
      <hr />
      <p style="text-align: right;">
        <button class="btn btn-outline-primary" @click="editPizza(pizza)">Edit</button>

        <button class="btn btn-danger" @click="deletePizza(pizza.id)">Delete</button>
      </p>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      pizzas: [],
      pizza: {
        id: "",
        customer_name: "",
        type: "",
        crust: ""
      },
      pizza_id: "",
      pagination: {},
      pizzatypes: [
        { type: "Garlic Pizza", value: "Garlic Pizza" },
        { type: "Hawaiian", value: "Hawaiian" },
        { type: "Margherita", value: "Margherita" },
        { type: "Cheese Pizza", value: "Cheese Pizza" },
        { type: "Pepperoni Pizza", value: "Pepperoni Pizza" },
        { type: "Veggie Pizza", value: "Veggie Pizza" },
        { type: "Meat Pizza", value: "Meat Pizza" }
      ],

      pizzacrusts: [
        { crust: "Chessy Crust", value: "Chessy" },
        { crust: "Thick Crust", value: "Thick" },
        { crust: "Thin Crust", value: "Thin" },
        { crust: "Deep Crust", value: "Deep" },
        { crust: "Stuffed Crust", value: "Stuffed" }
      ],

      edit: false
    };
  },

  created() {
    this.fetchPizzas();
  },

  methods: {
    fetchPizzas(page_url) {
      let paginatevar = this;
      page_url = page_url || "/api/pizzas";
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
      };

      this.pagination = pagination;
    },

    deletePizza(id) {
      if (confirm("Are you sure to delete this order?")) {
        fetch(`api/pizza/${id}`, {
          method: "delete"
        })
          .then(res => res.json())
          .then(data => {
            alert("Pizza Order Removed!");
            this.fetchPizzas();
          })
          .catch(error => console.log(error));
      }
    },

    addPizza() {
      if (this.edit === false) {
        // Add Pizza
        fetch("api/pizza", {
          method: "post",
          body: JSON.stringify(this.pizza),
          headers: {
            "content-type": "application/json"
          }
        })
          .then(res => res.json())
          .then(data => {
            this.pizza.customer_name = "";
            this.pizza.type = "";
            this.crust = "";
            alert("Pizza Order Added!");
            this.fetchPizzas();
          })
          .catch(error => console.log(error));
      } else {
        // Edit Pizza
        fetch("api/pizza", {
          method: "put",
          body: JSON.stringify(this.pizza),
          headers: {
            "content-type": "application/json"
          }
        })
          .then(res => res.json())
          .then(data => {
            this.pizza.customer_name = "";
            this.pizza.type = "";
            this.crust = "";
            alert("Pizza Order Updated!");
            this.fetchPizzas();
          })
          .catch(error => console.log(error));
      }
    },

    editPizza(pizza) {
      this.edit = true;
      this.pizza.id = pizza.id;
      this.pizza.pizza_id = pizza.id;
      this.pizza.customer_name = pizza.customer_name;
      this.pizza.type = pizza.type;
      this.pizza.crust = pizza.crust;
    }
  }
};
</script>