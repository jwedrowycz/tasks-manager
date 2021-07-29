<template>
    <div>   
         <div class="col-md-4 my-3">
            <b-button v-b-modal.modal-1 variant="primary">Dodaj zadanie</b-button>

            <b-modal id="modal-1"
                @ok="handleOk"
                title="Dodaj zadanie">
                <form @submit.prevent="submit">
                    <div class="form-group">
                        <label for="title" class="col-form-label">Nazwa zadania:</label>
                        <input type="text" class="form-control" v-model="fields.title">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Opis zadania:</label>
                        <textarea class="form-control" id="message-text" v-model="fields.description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Przewidywany termin realizacji:</label>
                        <b-form-datepicker locale="pl" id="example-datepicker" v-model="fields.expected_end" class="mb-2"></b-form-datepicker>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Widoczność:</label>
                        <b-form-radio v-model="fields.is_private" name="is_private" value="1">Prywatne</b-form-radio>
                        <b-form-radio v-model="fields.is_private" name="is_private" value="0">Publiczne</b-form-radio>
                    </div>
                </form>
            </b-modal>
        </div>      
        <table class="table" >
            <thead>
            <tr>
                <th>ID</th>
                <th>Nazwa zadania</th>
                <th>Opis</th>
                <th>Przew. koniec. zad.</th>
                <th>Utworzono</th>
                <th>Utworzył</th>
                <th>Akcje</th>
            </tr>
            </thead>
            <tbody >
                <tr v-for="task in tasks" :key="task.id" :class="{'spinner-border':loading}">
                    <td>{{ task.id }}</td>
                    <td>{{ task.title }}</td>
                    <td>{{ task.description }}</td>
                    <td>{{ task.expected_end }}</td>
                    <td>{{ task.created_at }}</td>
                    <td>{{ task.user }}</td>
                    <td v-if="email == task.email">
                        <b-button v-b-modal="'confirm-modal' + task.id" variant="danger">Usuń</b-button>
                        <b-modal :id="'confirm-modal' + task.id" @ok="deleteTask(task.id)" >Czy na pewno chcesz usunąć te zadanie?</b-modal>
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
                tasks: [],
                loading: true,
                fields: {},
                success: false,
                errors: {},
            }
        },
        mounted() {
            this.loadTasks();
        },
        methods: {
            loadTasks() {
                axios.get('/api/tasks')
                    .then((response) => {
                        this.tasks = response.data.data;
                        this.loading = false;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                    
            },
            updateTasks() {
                 console.log('huj');
            },

            handleSubmit() {
              axios.get('/sanctum/csrf-cookie').then(response => {
                  axios.post('/api/tasks', this.fields).then(response => {
                    this.fields = {};
                    this.success = true;
                    this.errors = {};
                    this.loadTasks();
                  }).catch(error => {
                      if (error.response.status == 422) {
                          this.errors = error.response.data.errors;
                      }
                      console.log('Error');
                  });
                })
            },
            handleOk(bvModalEvt) {
                this.handleSubmit();

            },

            deleteTask(id) {
                axios.get('sanctum/csrf-cookie').then(response => {
                    axios.delete('/api/tasks/'+id);
                    this.loadTasks();
                });
            }
           
        },
    }
</script>