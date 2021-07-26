<template>
    <div>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nazwa zadania</th>
                <th>Opis</th>
                <th>Utworzono</th>
                <th>Utworzył</th>
                <!-- <th>Akcje</th> -->
            </tr>
            </thead>
            <tbody >
            <tr v-for="task in tasks" :key="task.id" :class="{'spinner-border':loading}">
                <td>{{ task.id }}</td>
                <td>{{ task.title }}</td>
                <td>{{ task.description }}</td>
                <td>{{ task.created_at }}</td>
                <td>{{ task.user }}</td>

            </tr>
            </tbody>
        </table>
    </div>
    
</template>
 
<script>
     export default {
        data: function () {
            return {
                tasks: [],
                loading: true
            }
        },
        methods: {
            loadTasks: function () {
                axios.get('/api/tasks')
                    .then((response) => {
                        this.tasks = response.data.data;
                        this.loading = false;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
        },
        mounted() {
            this.loadTasks();
        },
    }
</script>