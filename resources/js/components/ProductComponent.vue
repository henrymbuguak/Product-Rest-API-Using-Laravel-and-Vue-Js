<template>
    <div class="card">
        <div class="card-header">Products</div>
        <div class="card-body">
            <div class="alert" role="alert">

                <form @submit.prevent="submit">

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" v-model="fields.name" placeholder="Enter name" id="name" name="name" required>
                        <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" class="form-control" v-model="fields.description" placeholder="Enter description" id="description" name="description" required>
                        <div v-if="errors && errors.description" class="text-danger">{{ errors.description[0] }}</div>
                    </div>

                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="text" class="form-control" v-model="fields.quantity" placeholder="Enter quantity" id="quantity" name="quantity" required>
                        <div v-if="errors && errors.quantity" class="text-danger">{{ errors.quantity[0] }}</div>
                    </div>

                    <button type="submit" class="btn btn-primary">ADD</button>

                    <div v-if="success" class="alert alert-success mt-3">
                        Message sent!
                    </div>

                </form>


            </div>
            <br><br>

            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="product in products" :key="product.id">
                    <td>{{ product.name }}</td>
                    <td>{{ product.description }}</td>
                    <td>{{ product.quantity }}</td>
                    <td>edit</td>
                    <td>
                        <button type="button" class="btn btn-danger pull-right btn-sm" data-toggle="modal" v-on:submit.prevent="deleteData(product)" @click="deleteData(product, products) in result">Delete</button>

<!--                        <button type="button" class="btn btn-danger btn-sm btn pull-right">Delete</button>-->
                    </td>
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
                fields: {},
                errors: {},
                success: false,
                loaded: true,
                products: [],
            }
        },

        created(){
            axios.get('/api/products').then(response => {
                this.products = response.data.products
            }).catch(error => {
                this.loaded = true;
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors || {};
                }
            })
        },

        methods: {
            deleteData: function(product, id) {
                if (this.loaded) {
                    this.loaded = false;
                    this.success = false;
                    this.errors = {};

                    axios.delete('/api/products/' + product.id)
                        .then(response => {
                            this.result.splice(id, 1);
                            this.loaded = true;
                            this.success = true;
                            // console.log(this.product);
                        }).catch(error => {
                            this.loaded = true;
                            if (error.response.status === 422) {
                                this.errors = error.response.data.errors || {};
                            }
                    });
                }
            },

            submit() {
                if (this.loaded) {
                    this.loaded = false;
                    this.success = false;
                    this.errors = {};

                    axios.post('/api/products', this.fields).then(response => {
                        this.fields = {}; // clear form data
                        this.loaded = true;
                        this.success = true;
                    }).catch(error => {
                        this.loaded = true;
                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors || {};
                        }
                    });
                }
            },
        },

    }
</script>
