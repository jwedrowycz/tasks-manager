<template>
    <div>   
         <div class="col-md-4 my-3">
            <b-button v-b-modal.modal-form variant="primary">Dodaj zadanie</b-button>
             <b-form-checkbox
                id="checkbox_only_private"
                v-model="checked.only_private"
                value="true"
                unchecked-value="false"
                @change="filterTasks">
                Tylko prywatne zadania
                </b-form-checkbox>

            <b-modal id="modal-form"
                @ok="handleOk"
                title="Dodaj zadanie"
                ref="modal-form"
                >
                <form @submit.prevent="handleSubmit">
                    <div class="form-group">
                        <label for="title" class="col-form-label">Nazwa zadania:</label>
                        <small class="text-danger">(wymagane)</small>
                        <input type="text" class="form-control" v-model="fields.title">
                        <div v-if="errors && errors.title" class="text-danger">{{ errors.title[0] }}</div>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Opis zadania:</label>
                        <small class="text-danger">(wymagane)</small>
                        <textarea class="form-control" id="message-text" v-model="fields.description"></textarea>
                        <div v-if="errors && errors.description" class="text-danger">{{ errors.description[0] }}</div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <label for="message-text" class="col-form-label">Termin rozpoczęcia:</label>
                            <small class="text-danger">(wymagane)</small>
                            <b-form-datepicker locale="pl" id="start-datepicker" v-model="fields.start" class="mb-2"></b-form-datepicker>
                            <div v-if="errors && errors.start" class="text-danger">{{ errors.start[0] }}</div>
                        </div>
                        <div class="col">
                            <label for="message-text" class="col-form-label">Przewidywany termin realizacji:</label>
                            <b-form-datepicker locale="pl" id="exp_end-datepicker" v-model="fields.expected_end" class="mb-2"></b-form-datepicker>
                            <div v-if="errors && errors.expected_end" class="text-danger">{{ errors.expected_end[0] }}</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Widoczność:</label>
                        <b-form-radio v-model="fields.is_private" name="is_private" value="1">Prywatne</b-form-radio>
                        <b-form-radio v-model="fields.is_private" name="is_private" value="0">Publiczne</b-form-radio>
                    </div>
                </form>
            </b-modal>
        </div>      
        <table class="table table-striped" v-columns-resizable>
            <thead>
            <tr>
                <th>ID</th>
                <th>Nazwa zadania</th>
                <th>Opis</th>
                <th>Rozpoczęcie</th>
                <th>Przew. koniec. zad.</th>
                <th>Utworzono</th>
                <th>Utworzył</th>
                <th>Zakończone</th>
                <th>Akcje</th>
            </tr>
            </thead>
            <tbody :class="{'loading':loading}">
                <tr v-for="task in tasks.data" :key="task.id">
                    <td>{{ task.id }}</td>
                    <td>{{ task.title }}</td>
                    <td>{{ task.description }}</td>
                    <td>{{ task.start }}</td>
                    <td>{{ task.expected_end }}</td>
                    <td>{{ task.created_at }}</td>
                    <td>{{ task.user.name }}</td>
                    <td class="text-center" >
                        <b-icon v-if="task.end != null" icon="check-square" scale="2" variant="success"></b-icon>
                    </td>
                    <td class="actions">
                        <b-button v-if="authUser.email == task.user.email && task.end == null" v-b-modal="'complete-modal' + task.id" variant="secondary">Zakończ</b-button>
                        <b-modal :id="'complete-modal' + task.id" @ok="completeTask(task.id)" >Czy na pewno chcesz zakończyć to zadanie?</b-modal>
                        
                        <b-button v-if="authUser.email == task.user.email" v-b-modal="'confirm-modal' + task.id" variant="danger">Usuń</b-button>
                        <b-modal :id="'confirm-modal' + task.id" @ok="deleteTask(task.id)" >Czy na pewno chcesz usunąć te zadanie?</b-modal>
                    </td>
                </tr>
            </tbody>
        </table>
        <pagination class="mx-3" :data="tasks" @pagination-change-page="loadTasks"></pagination>
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
                authUser: window.authUser,   
                checked: {
                },          
            }
        },
        mounted() {
            this.loadTasks();
            this.fields.is_private = 0;
        },
        methods: {
            loadTasks(page = 1) {
                axios.get('/api/tasks?page=' + page)
                    .then((response) => {
                        this.tasks = response.data;
                        this.loading = false;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                    
            },
            handleSubmit() {
              axios.get('/sanctum/csrf-cookie').then(response => {
                  axios.post('/api/tasks', this.fields).then(response => {
                    this.fields = {};
                    this.success = true;
                    this.errors = {};
                    this.loadTasks();
                    this.makeToast('Zadanie zostało dodane', 'Menadżer Zadań', 'success');
                    this.fields.is_private = 0;
                    this.$refs['modal-form'].hide();
                  }).catch(error => {
                      if (error.response.status == 422) {
                          this.errors = error.response.data.errors;
                      } else {
                            this.makeToast('Wystąpił nieoczekiwany błąd', 'Menadżer Zadań', 'danger');
                      }
                  });
                })
            },
            handleOk(bvModalEvt) {
                bvModalEvt.preventDefault()
                this.handleSubmit();

            },
            deleteTask(id) {
                axios.get('sanctum/csrf-cookie').then(response => {
                    axios.delete('/api/tasks/'+id);
                    this.loadTasks();
                    this.makeToast('Zadanie zostało usunięte', 'Menadżer Zadań', 'info');

                }).catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                });
            },
            completeTask(id) {
                axios.get('sanctum/csrf-cookie').then(response => {
                    axios.put('/api/tasks/complete/'+id);
                    this.loadTasks();
                    this.makeToast('Zadanie zostało zakończone','Menadżer Zadań', 'success')
                });
            },
            filterTasks(page = 1) {
                axios.get('api/tasks', {
                    params: this.checked
                });
            },
            makeToast(msg, title, variant) {
                this.$root.$bvToast.toast(msg, {
                    title: title,
                    autoHideDelay: 7000,
                    variant: variant,
                });
            },
           
        },
    }
</script>