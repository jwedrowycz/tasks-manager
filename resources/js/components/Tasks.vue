<template>
    <div>
        <h2 class="text-center">Lista zadań</h2>
 
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nazwa zadania</th>
                <th>Opis</th>
                <!-- <th>Actions</th> -->
            </tr>
            </thead>
            <tbody>
            <tr v-for="task in tasks">
                <td>{{ task.id }}</td>
                <td>{{ task.title }}</td>
                <td>{{ task.description }}</td>
                <td>
                    <!-- <div class="btn-group" role="group">
                        <router-link :to="{name: 'edit', params: { id: product.id }}" class="btn btn-success">Edit</router-link>
                        <button class="btn btn-danger" @click="deleteProduct(product.id)">Delete</button>
                    </div> -->
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    
</template>
 
<script>
    export default {
        data: function () {
            return {
                tasks: []
            }
        },

        mounted() {
            this.loadTasks();
        },
        methods: {
            loadTasks: function() {
                axios.get('/api/tasks')
                .then((response) => {
                    this.tasks = response.data.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
        }
    }
</script>